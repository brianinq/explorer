<?php
 function redirect($location){
     header("location:".$location);
     exit();
 }
 function subst($str){
     if (strlen($str) <=17) {
         echo $str;
     } else {
         echo substr($str, 0, 50) . '...';
     }
 }
?>