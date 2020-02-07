<?php

class View
{
   /**
    * displays error msg if we have an error
    * @param bool $error
	 * @param string $msg
    * @return string
    */
    function error_msg($error, $msg)
    {
      if($error) { return $msg; }
		return '';
    } 

	
    /**
     * returns the correct value for our form element
     * @param bool $error
     * @param string $row
     * @param string $param
     * @return string
     */
    function element_value($error, $row, $param)
    {
        if ($error){ return ''; }
        if ($row) {  return $row;  }
        if ($param) { return $param; }
        return '';
    }


    /**
     * check user session if logged in returns true
     * or else it returns false
     * @return bool
     */
    function logged_in()
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']))
        {
                return true;
        }
        else
        {
          return false;
        }
    }

    /**
     * returns user field
     * @param string $field;
     * @return string
     */
    function current_user($field)
    {
      return $_SESSION['user'][$field];
    }


    /**
     * format date
     * @param mysql timestamp $mysql_timestamp
     * @return string
     */
     static function format_date($mysql_timestamp, $format=null)
     {
       $dt = strtotime($mysql_timestamp);

       if (!$format)
       {
           $dt = strtotime($mysql_timestamp);
           return date('M  j Y', $dt);

       }
       else
       {
           $dt = Date($format, $dt);
           return $dt;
       }
    
     }

     static function render_partial($request)
     {
        $controller = $request['controller'].'controller';
        $action = $request['action'];

        include_once (APP_FOLDER."/controllers/$controller".".php");
        $route = array('controller'=>$request['controller'], 'action'=>$action);
        $cont = new $controller($route);
        $cont->$action();
     }
     
     
     
     static function editor($model)
     {
         if ($model == null) return;
         
         $html = "<form method='post'>";
         foreach($model as $key => $val){
             if ($key == "errors") {
                 continue;
             }
             if (StringFunctions::startsWith($key, "_")){
                 continue;
             }
             if ($val instanceof ActiveRecord){
                 //ActiveRecord::println($val);
                 
                 if (property_exists($model, 'belongs_to') && $model::$belongs_to != null) {
                    foreach ($model::$belongs_to as $o => $row) {
                        $class = $model::$belongs_to[$o]['className'];
                        $foreignKey = $model::$belongs_to[$o]['foreignKey'];
                    }
                }
                 
                 continue;
             }
             $html.= "<div>";
             $html.= "<label for='$key'>" . $key . "</label><br/>";
             $html.= "<input type='text' id='$key' name='$key' value='$val'/>" ;

             $html.= "</div><br/>\n";
         }
         
         $html.= "<br/>";
         $html.= "<input type='submit' value='submit'/>";
         $html.= "</form>";
         
         echo $html;
     }
     

     /*
      * displays a read-only screen based on model
      */
     static function display($model=null)
     {
         if ($model == null) return;
        
         $html = "";
             
         foreach($model as $key => $val){
             if ($key == "errors") {
                 continue;
             }
             if (StringFunctions::startsWith($key, "_")){
                 continue;
             }
             if ($val instanceof ActiveRecord){
                 continue;
             }
             $html.= "<div>";
             $html.= "<label for='$key'>" . $key . "</label><br/>";
             $html.= "<span type='text' id='$key' name='$key'>$val</span>" ;
             $html.= "</div><br/>";
         }
         $html.= "<br/>";
         
         echo $html;
     }
     
     static function grid($model=null)
     {
         if ($model == null) return;
        
         $html = "";
         $header = "";
         
         $in = true;
         foreach($model as $obj){
             $html .= "<tr>";
             foreach($obj as $k => $v) {
                if ($k == "errors") {
                    continue;
                }
                if (StringFunctions::startsWith($k, "_")) {
                    continue;
                }
                if ($in){
                    $header .= "<th>$k</th>";
                }
                $html .= "<td>$v</td>";
             }
            if ($in) {
              //$html = "<tr>".$header . "</tr>" . $html;
            }
            
            $html .= "<td><a href='edit/$obj->id'>edit</a></td>";
            $html .= "<td><a href='delete/$obj->id'>delete</a></td>";
            $html .= "</tr>";

            $in = false;
            
        }
         
        $h = "<table class='grid'>". "<thead><tr>".$header."</tr></thead><tbody>" . $html . "</body></table>";
        
         
         echo $h;
     }
}
?>
