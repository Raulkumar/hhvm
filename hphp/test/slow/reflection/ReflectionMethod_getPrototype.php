<?hh

function outputPrototype($rf) {
  try {
    $prototype = $rf->getPrototype();
    print $prototype->getDeclaringClass()->getName() .
      "::" . $prototype->getName();
    print "\n";
  } catch (ReflectionException $re) {
    print $re->getMessage(). "\n";
  }
}

interface Int1 {
  function method1();
}
interface Int2 {
  function method2();
}
interface Int3 extends Int2 {
  function method3();
}
interface Int4 {
  function method4();
}

class Cls1 {
  public function method1() {
  }
  private function method2() {
  }
}
class Cls2 {
  public function method1() {
  }
  public function method2() {
  }
}
abstract class Cls3 extends Cls2 implements Int3 {
}
class Cls4 extends Cls3 {
  public function method3() {
  }
}
class Cls5 extends Cls4 implements Int4 {
  public function method4() {
  }
}

trait Method3 {
  public function method3() {
  }
}

class Cls6 extends Cls4 implements Int4 {
  use Method3;
  function method4() {
  }
}
class Cls7 extends Cls6 {
  public function method1() {
  }
  public function method7() {
  }
}
class Cls8 extends Cls7 {
  public function method7() {
  }
}

class PDOSubClass extends PDO {
  public function commit() {
    return true;
  }
}

function main() {
  $tests = varray[
    varray["Cls1", "method1"],
    varray["Cls1", "method2"],
    varray["Cls2", "method2"],
    varray["Cls3", "method1"],
    varray["Cls3", "method3"],
    varray["Cls4", "method1"],
    varray["Cls4", "method3"],
    varray["Cls5", "method3"],
    varray["Cls5", "method4"],
    varray["Cls6", "method3"],
    varray["Cls6", "method4"],
    varray["Cls6", "method1"],
    varray["Cls7", "method1"],
    varray["Cls7", "method7"],
    varray["Cls8", "method1"],
    varray["Cls8", "method7"],
    // builtin class
    varray["PDO", "commit"],
    // sublcass of builtin class
    varray["PDOSubClass", "commit"],
  ];

  foreach ($tests as $test) {
    $rf = new ReflectionMethod($test[0], $test[1]);
    outputPrototype($rf);
  }
}



<<__EntryPoint>>
function main_reflection_method_get_prototype() {
main();
}
