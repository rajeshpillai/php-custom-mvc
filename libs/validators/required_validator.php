<?php
/**
 * Description of required_validator
 *
 * @author rajesh
 */
class RequiredValidator extends Validator {
    
    function __construct() {
        $this->message = "field is required";
    }
    
    public function validate($obj, $field, $rule, $message = null) {
        //echo "Processing REQUIRED VALIDATOR for $field<br/>";
        
        if ($message == null) {
            if (isset($rule["message"])) {
                $message = $rule["message"];
            }else {
                $message = $this->message;
            }
        }
        if (empty($obj->$field)) {
            //echo $field . " is not set <br/>";
            $obj->errors[$field] = $message;
            return false;
        }
        return true;
    }
}

?>
