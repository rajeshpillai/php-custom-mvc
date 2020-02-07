<?php
require_once 'libs/validators/required_validator.php';
require_once 'libs/validators/alphanumeric_validator.php';
require_once 'libs/validators/greaterthan_validator.php';


abstract class ActiveRecord {
    public static $className;
    public static $tableName;
    public static $primaryKey = "id";
    public static $describe;
    private static $db_quote_mark = "`";
    public static $rules = array();  // rules (validations)
    public static $labels = array();  // holds form display values
    
    protected static $validators=array(
        'required'=>'RequiredValidator',
        'number'=>'NumberValidator',
        'boolean'=>'BooleanValidator',
        'alphanumeric'=>'AlphaNumericValidator',
        'greater' => 'GreaterThanValidator',
        'emal' => 'EmailValidator'
    );

    
    public $errors = array(); // errors array
    public $_is_new_record;
    public $_run_validation = true;
    

    function __construct($data = null) {

        if ($data != null && is_array($data)) {
            //self::println("In AR ctor..");
            //self::println($data);
            foreach ($data as $k => $v) {
                //echo "setting variable $k <br/>";
                $this->$k = $v;
            }
            $this->_is_new_record = true;
        }

        //$this->_model = get_class($this);
        //$this->_table = strtolower(Inflect::pluralize($this->_model));
        //$this->_data = array();

        if (!isset($this->abstract)) {
            static::$describe = static::describe();
        }
    }

    function __call($methodname, $args) {
        
    }

    static function __callstatic($methodname, $args) {
        self::println($args);

        $method_arr = explode("_", $methodname);
        self::println($method_arr);

        $action = $method_arr[0];

        if ($action != "find")
            return;


        $method_arr = self::remove_item_by_value($method_arr, "find");
        $method_arr = self::remove_item_by_value($method_arr, "by");
        $method_arr = self::remove_item_by_value($method_arr, "and");


        $fields = self::describe();

        $criteria = array();

        $i = 0;
        foreach ($method_arr as $field) {
            foreach ($fields as $k => $v) {
                echo $v["Field"] . " AND " . $field . "<br/>";
                if ($v["Field"] == $field) {
                    $criteria[$field] = $args[$i++];
                }
            }
        }
        self::println($criteria);
        return self::find_by($action, $criteria);
    }

    // Remove array item by value
    static function remove_item_by_value($array, $val = '', $preserve_keys = true) {
        if (empty($array) || !is_array($array))
            return false;
        if (!in_array($val, $array))
            return $array;

        foreach ($array as $key => $value) {
            if ($value == $val)
                unset($array[$key]);
        }

        return ($preserve_keys === true) ? $array : array_values($array);
    }

    public static function find_by($method, array $criteria) {

        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $return = array();

        $w = array();
        if (is_array($criteria)) {
            foreach ($criteria as $f => $v) {
                $w[$f] = $f . "=" . ":" . $f;
            }
        }

        $w = implode(" and ", $w);

        //self::println($w);

        $sql = self::getSelectColumns(static::$className);
        $sql .= " where " . $w;

        //echo $sql . "<br/>";

        $statement = $db->prepare($sql);

        foreach ($criteria as $f => $v) {
            $statement->bindParam($f, $v);
        }

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $return[] = self::to_object(static::$className, $row); //new $className($row);
        }

        return $return;
    }

    static function getSelectColumns($class_name) {
        return "SELECT " . strtolower($class_name::$tableName) . ".* FROM " . strtolower($class_name::$tableName);
    }

    private static function getValidator($rule) {
        
        if (is_array($rule)) {
            $ruleName = $rule["rule"];
        }else {
            $ruleName = $rule;
        }
        //echo "Getting validator for rule : " . $ruleName . "<br/>";
        
        //self::println($rule);
        return new self::$validators[$ruleName]();
    }
    
    function processRuleSimple($field, $rule) {
        //echo "Processing simple rule on " . $field. "=>" . $rule. "<br/>";
        $validator = self::getValidator($rule);
        $validator->validate($this, $field, $rule);
    }
 
   function processRule2($field, $rule) {
        /*
          "name" => array (
            "rule" => "required",
            "message" => "name is a required field"
         )
         */
         //echo "Processing Rule 2 for $field : Rule " . $rule["rule"] . "<br/>";
         //echo "Processing simple rule on " . $field. "=>" . $rule. "<br/>";

         $validator = self::getValidator($rule);
         $validator->validate($this, $field, $rule);
    }
      
   function processRule3( $field, $rule) {
        //self::println($rule);
        //echo "Processing Rule 3 for $field <br/>";
        
        foreach($rule as $f => $v) {
            //echo $f . "=" . $v . "<br/>";
            foreach($v as $f1 => $v1) {
                $this->processRule2($field, $v);
            }
        }
    }
    
    
    // VALIDATION
    function validate() {
        if (!$this->_run_validation) {
            return true;
        }
        //self::println("Validating: " . static::$className);
        //self::println($this);
        foreach(static::$rules as $rule=>$child) {
            if (is_array($child)) {
                // Two dimension
                foreach($child as $f => $r) {
                    
                    if (is_array($r)) {
                        //echo "Three dimension <br/>";
                        $this->processRule3($rule, $child);
                        break;
                    }
                    else {
                         //echo "Two dimension <br/>";
                         $this->processRule2($rule,$child);
                         break;
                    }
                }
            }
            else {
                // One dimension array
                $this->processRuleSimple($rule, $child);
                
            }
        }
        
        return $this->errors;
    }

    protected static function describe() {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $sql = "DESCRIBE " . strtolower(static::$tableName);

        //echo $sql . "<br/>";

        $statement = $db->prepare($sql);

        $statement->execute();

        $_result = $statement->fetchAll(PDO::FETCH_ASSOC);


        $describe = array();

        foreach ($_result as $row) {
            $describe[] = $row;
        }

        return $describe;
    }

    public static function create(Array $properties) {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');
        $obj = new static::$className($properties);

        echo "CREATE method: <br/>";
          
        foreach (static::$describe as $k => $v) {
            //static::println($v["Field"]);
            $obj->$v["Field"] = $properties[$v["Field"]];
        }

        $err = $obj->validate($obj);
        
        echo "PRINTING VALIDATION RESULT : <br/>";
        self::println($err);

        if (!empty($err)) {
            return $obj;
        }

        
        $sql = self::get_insert_sql();
        $statement = $db->prepare($sql);

        foreach ($properties as $k => &$v) {
            if ($k != static::$primaryKey) {
                $k1 = ":" . $k;
                //echo $k1 . ":" . $v . "<br/>";
                $statement->bindParam($k, $v);
            }
        }

        if (!$statement->execute()) {
            self::println($statement->errorInfo());
        }
        
        return $obj;
    }

    private static function get_insert_sql() {
        $cols = "";
        $val = "";

        foreach (static::$describe as $k => $v) {
            if ($v["Field"] != static::$primaryKey) {
                $cols.= "`" . $v["Field"] . "`" . ",";
                $val .= ":" . $v["Field"] . ",";
            }
        }
   
        $cols = substr($cols, 0, -1);
        $val = substr($val, 0,  -1);

        
        $sql = "INSERT INTO " . strtolower(static::$tableName) . "(" . $cols . ")";
        $sql .= " VALUES (" . $val . ")";

        return $sql;
    }

    private static function get_update_sql() {
        $cols = "";
        $val = "";

        foreach (static::$describe as $k => $v) {
            if ($v["Field"] != static::$primaryKey) {
                $cols.= "`" . $v["Field"] . "`" . ",";
                $val .= ":" . $v["Field"] . ",";
            }
        }

        $cols = substr($cols, 0,-1);  // exclude the trailing ','
        $val = substr($val, 0,-1);
        
        $update_fields = "";

        foreach (static::$describe as $k => $v) {
            if ($update_fields != "") {
                $update_fields .= ", ";
            }
            if ($v["Field"] != static::$primaryKey) {
                $update_fields .= self::$db_quote_mark . $v["Field"] . self::$db_quote_mark . " = " . ":" . $v["Field"];
            }
        }

        $sql = "update " . static::$tableName . " set $update_fields where " . static::$primaryKey . "=" . ":" . static::$primaryKey;

        return $sql;
    }

    public function save() {

        $err = $this->validate();
        
        echo "PRINTING VALIDATION RESULT : <br/>";

        self::println($this->errors);

        if (!empty($err)) {
            return $err;
        }
        
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        //self::println($this);

        $sql = "";

        echo "IS NEW: " . $this->_is_new_record . "<br/>";

        if ($this->_is_new_record) {
            $sql = self::get_insert_sql();
        } else {
            $sql = self::get_update_sql();
        }

        //self::println($sql);

        $statement = $db->prepare($sql);

        //self::println(static::$describe);

        foreach (static::$describe as $k => $v) {
            //self::println($k . "=" . $v["Field"]);
            //if ($v["Field"] != static::$primaryKey) {
            $statement->bindParam($v["Field"], $this->$v["Field"]);
            //}
        }

        //self::println($statement->debugDumpParams());

        if (!$statement->execute()) {
            self::println($statement->errorInfo());
        }
    }

    public function savexxx() {

        $err = $this->validate();
        
        echo "PRINTING VALIDATION RESULT : <br/>";
        self::println($this->errors);

        if (!empty($err)) {
            return $err;
        }
        
        $sql = "";

        echo "IS NEW: " . $this->_is_new_record . "<br/>";

        if ($this->_is_new_record) {
            $sql = self::get_insert_sql();
        } else {
            $sql = self::get_update_sql();
        }
        
        $db = Db::connect(DSN, USERNAME, PASSWORD);
        
        $rs = $db->insert($sql, $this);
        //self::println($rs);
    }

    
    public static function instance(Array $properties = null) {
        $obj = new static::$className();

        foreach (static::$describe as $k => $v) {
            //static::println("NEW:" . $v["Field"]);
            $obj->$v["Field"] = $k["Field"];
        }

        if ($properties != null) {
            foreach ($properties as $f => $d) {
                $obj->$f = $d;
            }
        }

        if (property_exists($obj, 'belongs_to') && $obj::$belongs_to != null) {
            foreach ($obj::$belongs_to as $o => $row) {
                $class = $obj::$belongs_to[$o]['className'];
                $foreignKey = $obj::$belongs_to[$o]['foreignKey'];
            }
        }

        return $obj;
    }

    public function update(Array $properties) {
        foreach ($properties as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        $this->save();
    }

    /**
     * Update a single property
     *
     * @param string $key   Property name
     * @param mixed  $value Property value
     * 
     * @return void
     */
    public function updateProperty($key, $value) {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
        $this->save();
    }

    /**
     * Delete an object
     *
     * @return void
     */
    public function delete() {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $delete = "DELETE FROM " . strtolower(self::$tableName) . " WHERE `id` = :id";
        $statement = $db->prepare($delete);
        $statement->bindParam(':id', $this->id, PDO::PARAM_INT);

        $statement->execute();
    }

    public static function delete_by_id($id) {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $delete = "DELETE FROM " . strtolower(static::$tableName) . " WHERE `id` = :id";

        self::println($delete);

        $statement = $db->prepare($delete);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Get a single object by id
     *
     * @param integer $id
     * @return Object
     */
    public static function find($id, $className=null) {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        echo $id . "<br/>";

        if ($className == null) {
            $className = static::$className;
        }

        $select = self::getSelectColumns($className) . " WHERE `id` = :id";


        echo 'sql = ' . $select . '<br/>';
        $statement = $db->prepare($select);

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);


        if ($result == null || !isset($result)) {
            return null;
        }

        //$obj = new $className($result[0]);
        $obj = self::to_object($className, $result[0]);

        //self::println($obj);
        if (property_exists($obj, 'belongs_to') && $obj::$belongs_to != null) {
            foreach ($obj::$belongs_to as $o => $row) {
                $class = $obj::$belongs_to[$o]['className'];
                $foreignKey = $obj::$belongs_to[$o]['foreignKey'];
                $obj->$o = static::find($obj->$foreignKey, $class);
            }
        }


        if (property_exists($obj, 'hasMany') && $obj::$hasMany != null) {
            foreach ($obj::$hasMany as $o => $row) {
                $class = $obj::$hasMany[$o]['className'];
                $foreignKey = $obj::$hasMany[$o]['foreignKey'];
                //self::println($o);
                $obj->$o = self::load($foreignKey, $obj->{$className::$primaryKey}, $class);
            }
        }


        return $obj;
    }

    private static function to_object($class, $row = null) {
        if ($row == null)
            return null;

        $obj = new $class();
        $obj->_is_new_record = false;
        foreach ($row as $i => $v) {
            $obj->$i = $v;
        }

        return $obj;
    }

    public static function load($foreignKey, $keyValue = null, $className = null) {
        echo "Loading relations...$className...for $foreignKey" . '<br/>';
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $return = array();

        //self::println($className);

        $sql = self::getSelectColumns($className) . " WHERE `$foreignKey` = :user_id";

        echo $sql . "->$keyValue";

        $statement = $db->prepare($sql);

        $statement->bindParam(':user_id', $keyValue, PDO::PARAM_INT);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $return[] = new $className($row);
        }

        return $return;
    }

    public function find_all($className = null) {
        $db = new PDO('mysql:host=localhost;dbname=clockit', 'root', '');

        $return = array();

        echo("OBJECT: " . static::$className . "<br/>");
        if ($className == null) {
            $className = static::$className;
        }

        $sql = self::getSelectColumns($className);


        echo $sql . "<br/>";

        foreach ($db->query($sql, PDO::FETCH_ASSOC) as $row) {
            $return[] = self::to_object($className, $row); //new $className($row);
        }

        return $return;
    }

    

    static function println($data) {
        if (is_array($data)) { //If the given variable is an array, print using the print_r function.
            print "<pre>-----------------------\n";
            print_r($data);
            print "-----------------------</pre>";
        } elseif (is_object($data)) {
            print "<pre>==========================\n";
            var_dump($data);
            print "===========================</pre>";
        } else {
            print "=========&gt; ";
            var_dump($data);
            print " &lt;=========";
        }
    }

}

?>
