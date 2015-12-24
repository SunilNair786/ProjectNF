<?php
    $string = "5679a62cb0e30cf80800002sd,56782965b0e30c440f000029";
    $pos = strpos($string, "56782965b0e30c440f000029");
    if ($pos === false) {
        print "Not found\n";
    } else {
        print "Found!\n";
    }
?>