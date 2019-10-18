// Copyright (c) 2019, Facebook, Inc.
// All rights reserved.
//
// This source code is licensed under the MIT license found in the
// LICENSE file in the "hack" directory of this source tree.

//! A single-threaded reference-counting pointer type, which, as a performance
//! optimization, can cache the result of converting the pointed-to value to an
//! OCaml value. `RcOc` stands for "reference counted with Ocaml-value cache".
//!
//! Internally uses `std::rc::Rc`, so restrictions on `Rc` also apply to `RcOc`.
//! It is encouraged to follow `Rc` conventions (such as preferring the use of
//! `RcOc::clone(x)` rather than `x.clone()`) when using `RcOc`.

use std::cell::Cell;
use std::cmp::{Eq, Ord, Ordering, PartialEq, PartialOrd};
use std::convert::AsRef;
use std::fmt;
use std::hash::{Hash, Hasher};
use std::ops::Deref;
use std::rc::Rc;

use crate::{Arena, FromError, OcamlRep, Value};

const UNIT: usize = crate::value::isize_to_ocaml_int(0);
const INVALID_GENERATION: usize = usize::max_value();

struct OcamlValueCache<T> {
    forward_pointer: Cell<usize>,
    generation: Cell<usize>,
    value: T,
}

impl<T> OcamlValueCache<T> {
    #[inline(always)]
    pub fn new(value: T) -> Self {
        OcamlValueCache {
            forward_pointer: Cell::new(UNIT),
            generation: Cell::new(INVALID_GENERATION),
            value,
        }
    }

    #[inline(always)]
    pub fn get_in_generation(&self, generation: usize) -> Option<usize> {
        if generation == self.generation.get() {
            Some(self.forward_pointer.get())
        } else {
            None
        }
    }

    #[inline(always)]
    pub fn set(&self, value: usize, generation: usize) {
        assert!(generation != INVALID_GENERATION);
        self.forward_pointer.set(value);
        self.generation.set(generation);
    }

    #[inline(always)]
    fn clear(&self) {
        self.forward_pointer.set(UNIT);
        self.generation.set(INVALID_GENERATION);
    }
}

impl<T: Clone> Clone for OcamlValueCache<T> {
    #[inline(always)]
    fn clone(&self) -> Self {
        OcamlValueCache::new(self.value.clone())
    }
}

impl<T: PartialEq> PartialEq for OcamlValueCache<T> {
    #[inline(always)]
    fn eq(&self, other: &OcamlValueCache<T>) -> bool {
        self.value.eq(&other.value)
    }

    #[inline(always)]
    fn ne(&self, other: &OcamlValueCache<T>) -> bool {
        self.value.ne(&other.value)
    }
}

impl<T: Eq> Eq for OcamlValueCache<T> {}

pub struct RcOc<T> {
    ptr: Rc<OcamlValueCache<T>>,
}

impl<T> RcOc<T> {
    #[inline(always)]
    pub fn new(value: T) -> Self {
        Self {
            ptr: Rc::new(OcamlValueCache::new(value)),
        }
    }

    #[inline(always)]
    pub fn get_cached_value_in_generation(&self, generation: usize) -> Option<usize> {
        (*self.ptr).get_in_generation(generation)
    }

    #[inline(always)]
    pub fn set_cached_value(&self, value: usize, generation: usize) {
        (*self.ptr).set(value, generation)
    }

    #[inline(always)]
    pub fn clear_cache(&self) {
        (*self.ptr).clear();
    }

    #[inline(always)]
    pub fn get_mut(this: &mut Self) -> Option<&mut T> {
        Rc::get_mut(&mut this.ptr).map(|cache| {
            // We are about to give permission to mutate the value, so
            // invalidate the cache.
            cache.clear();
            &mut cache.value
        })
    }

    #[inline(always)]
    pub fn ptr_eq(this: &Self, other: &Self) -> bool {
        Rc::ptr_eq(&this.ptr, &other.ptr)
    }
}

impl<T: Clone> RcOc<T> {
    #[inline(always)]
    pub fn make_mut(this: &mut Self) -> &mut T {
        // If the refcount is 1, Rc::make_mut will give permission to mutate the
        // value (rather than cloning it), so invalidate the cache.
        if Rc::strong_count(&this.ptr) == 1 {
            this.clear_cache();
        }
        &mut Rc::make_mut(&mut this.ptr).value
    }
}

impl<T> AsRef<T> for RcOc<T> {
    #[inline(always)]
    fn as_ref(&self) -> &T {
        &self.ptr.as_ref().value
    }
}

impl<T> Clone for RcOc<T> {
    #[inline(always)]
    fn clone(&self) -> Self {
        Self {
            ptr: Rc::clone(&self.ptr),
        }
    }
}

impl<T> Deref for RcOc<T> {
    type Target = T;

    #[inline(always)]
    fn deref(&self) -> &T {
        &self.ptr.deref().value
    }
}

impl<T: PartialEq> PartialEq for RcOc<T> {
    #[inline(always)]
    fn eq(&self, other: &RcOc<T>) -> bool {
        self.ptr.eq(&other.ptr)
    }

    #[inline(always)]
    fn ne(&self, other: &RcOc<T>) -> bool {
        self.ptr.ne(&other.ptr)
    }
}

impl<T: Eq> Eq for RcOc<T> {}

impl<T: PartialOrd> PartialOrd for RcOc<T> {
    #[inline(always)]
    fn partial_cmp(&self, other: &RcOc<T>) -> Option<Ordering> {
        (**self).partial_cmp(&**other)
    }

    #[inline(always)]
    fn lt(&self, other: &RcOc<T>) -> bool {
        **self < **other
    }

    #[inline(always)]
    fn le(&self, other: &RcOc<T>) -> bool {
        **self <= **other
    }

    #[inline(always)]
    fn gt(&self, other: &RcOc<T>) -> bool {
        **self > **other
    }

    #[inline(always)]
    fn ge(&self, other: &RcOc<T>) -> bool {
        **self >= **other
    }
}

impl<T: Ord> Ord for RcOc<T> {
    #[inline]
    fn cmp(&self, other: &RcOc<T>) -> Ordering {
        (**self).cmp(&**other)
    }
}

impl<T: Hash> Hash for RcOc<T> {
    fn hash<H: Hasher>(&self, state: &mut H) {
        (**self).hash(state);
    }
}

impl<T: fmt::Display> fmt::Display for RcOc<T> {
    fn fmt(&self, f: &mut fmt::Formatter<'_>) -> fmt::Result {
        fmt::Display::fmt(&**self, f)
    }
}

impl<T: fmt::Debug> fmt::Debug for RcOc<T> {
    fn fmt(&self, f: &mut fmt::Formatter<'_>) -> fmt::Result {
        fmt::Debug::fmt(&**self, f)
    }
}

impl<T> fmt::Pointer for RcOc<T> {
    fn fmt(&self, f: &mut fmt::Formatter<'_>) -> fmt::Result {
        fmt::Pointer::fmt(&(&**self as *const T), f)
    }
}

impl<T: OcamlRep + Clone> OcamlRep for RcOc<T> {
    fn into_ocamlrep<'a>(self, arena: &Arena<'a>) -> Value<'a> {
        let generation = arena.generation();
        match self.get_cached_value_in_generation(generation) {
            Some(value) => unsafe { Value::from_bits(value) },
            None => {
                let value = arena.add(self.as_ref().clone());
                self.set_cached_value(unsafe { value.to_bits() }, generation);
                value
            }
        }
    }

    fn from_ocamlrep(value: Value<'_>) -> Result<Self, FromError> {
        // NB: We don't get any sharing this way.
        Ok(RcOc::new(T::from_ocamlrep(value)?))
    }
}