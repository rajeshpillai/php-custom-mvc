<?php
class StringFunctions {
    static function startsWith($hayStack, $needle)
     {
         $criteria = "/^".$needle."/";
         
         if (preg_match($criteria, $hayStack)) {
             return true;
         }
         return false;
     }
}
?>
