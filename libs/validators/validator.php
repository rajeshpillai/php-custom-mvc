<?php
abstract class Validator {
    public $message = "";
    
    public function validate($obj, $field, $rule, $message = null) {
        return $this->validate($obj, $field, $rule, $message);
    }
}

?>
