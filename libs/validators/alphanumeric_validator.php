<?php
/**
 * Description of required_validator
 *
 * @author rajesh
 */
class AlphaNumericValidator extends Validator {
    
    function __construct() {
        $this->message = "only alphanumeric characters are allowed";
    }
    public function validate($obj, $field, $rule, $message = null) {
        echo "Processing ALPHANUMERIC VALIDATOR for $field<br/>";
        if ($message == null) {
            $message = $this->message;
        }
        if (!$this->validate_alphanumeric_not_start_with_underscore($obj->$field)) { 
          //echo "This contains characters other than letters and numbers<br/>"; 
          $obj->errors[$field] = $message;
          return false;
        } 
        return true;
    }
    
    private function validate_alphanumeric_not_start_with_underscore($input) 
    {
        //echo "validating input alphanumeic: $input <br/>";
        return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$input);
    }
    
    
}

?>
