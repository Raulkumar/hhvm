<?php

 $i = 0; print ++$i; print "\t"; print (true===true) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===true) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = true; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === true	"; print "\n"; print ++$i; print "\t"; print (true===false) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===false) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = false; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === false	"; print "\n"; print ++$i; print "\t"; print (true===1) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===1) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = 1; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === 1	"; print "\n"; print ++$i; print "\t"; print (true===0) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===0) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = 0; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === 0	"; print "\n"; print ++$i; print "\t"; print (true===-1) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===-1) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = -1; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === -1	"; print "\n"; print ++$i; print "\t"; print (true==='1') ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ==='1') ? 'Y' : 'N'; $b = 1; $b = 't'; $b = '1'; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === '1'	"; print "\n"; print ++$i; print "\t"; print (true==='0') ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ==='0') ? 'Y' : 'N'; $b = 1; $b = 't'; $b = '0'; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === '0'	"; print "\n"; print ++$i; print "\t"; print (true==='-1') ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ==='-1') ? 'Y' : 'N'; $b = 1; $b = 't'; $b = '-1'; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === '-1'	"; print "\n"; print ++$i; print "\t"; print (true===nullptr) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===nullptr) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = nullptr; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === nullptr	"; print "\n"; print ++$i; print "\t"; print (true===array()) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array()) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array(); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array()	"; print "\n"; print ++$i; print "\t"; print (true===array(1)) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array(1)) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array(1); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array(1)	"; print "\n"; print ++$i; print "\t"; print (true===array(2)) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array(2)) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array(2); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array(2)	"; print "\n"; print ++$i; print "\t"; print (true===array('1')) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('1')) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('1'); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('1')	"; print "\n"; print ++$i; print "\t"; print (true===array('0' => '1')) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('0' => '1')) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('0' => '1'); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('0' => '1')	"; print "\n"; print ++$i; print "\t"; print (true===array('a')) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('a')) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('a'); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('a')	"; print "\n"; print ++$i; print "\t"; print (true===array('a' => 1)) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('a' => 1)) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('a' => 1); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('a' => 1)	"; print "\n"; print ++$i; print "\t"; print (true===array('b' => 1)) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('b' => 1)) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('b' => 1); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('b' => 1)	"; print "\n"; print ++$i; print "\t"; print (true===array('a' => 1, 'b' => 2)) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array('a' => 1, 'b' => 2)) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array('a' => 1, 'b' => 2); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array('a' => 1, 'b' => 2)	"; print "\n"; print ++$i; print "\t"; print (true===array(array('a' => 1))) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array(array('a' => 1))) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array(array('a' => 1)); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array(array('a' => 1))	"; print "\n"; print ++$i; print "\t"; print (true===array(array('b' => 1))) ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ===array(array('b' => 1))) ? 'Y' : 'N'; $b = 1; $b = 't'; $b = array(array('b' => 1)); print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === array(array('b' => 1))	"; print "\n"; print ++$i; print "\t"; print (true==='php') ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ==='php') ? 'Y' : 'N'; $b = 1; $b = 't'; $b = 'php'; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === 'php'	"; print "\n"; print ++$i; print "\t"; print (true==='') ? 'Y' : 'N'; $a = 1; $a = 't'; $a = true; print ($a ==='') ? 'Y' : 'N'; $b = 1; $b = 't'; $b = ''; print (true===$b) ? 'Y' : 'N'; print ($a ===$b) ? 'Y' : 'N'; print "\t"; print "true === ''	"; print "\n"; 