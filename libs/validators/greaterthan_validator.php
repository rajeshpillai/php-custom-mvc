<?php
/**
 * Description of required_validator
 *
 * @author rajesh
 */
class GreaterThanValidator extends Validator {
    
    function __construct() {
        $this->message = "should be greater";
    }
    
    public function validate($obj, $field, $rule, $message = null) {
        echo "Processing GREATER VALIDATOR for $field<br/>";
        
        if (!isset($rule["value"])) {
            throw new Exception("GreaterValidator: value is not set");
        } else {
            $value = $rule["value"];
        }
        
        if ($message == null) {
            if (isset($rule["message"])) {
                $message = $rule["message"];
            }else {
                $message = $this->message;
            }
        }
        
        if ($obj->$field <= $value) {
            //echo $field . " is less than $value <br/>";
            $obj->errors[$field] = $message;
            return false;
        }
        return true;
    }
}

?>
