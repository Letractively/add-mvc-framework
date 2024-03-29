<?php
/**
 * For debugging purposes only
 * Not intended to appear permanently on any code
 *
 * @author albertdiones@gmail.com
 *
 * @package ADD MVC\Debuggers
 * @since ADD MVC 0.0
 * @version 0.1
 */
ABSTRACT CLASS add_debug {
  /**
   * echo only if IP matched
   *
   * @param string $arg the string to echo
   *
   * @author albertdiones@gmail.com
   * @since ADD MVC 0.0
   */
   static function restricted_echo($arg) {

      if (static::current_user_allowed()) {
         echo $arg;
      }

   }

   /**
    * Declare this on extensions to set the allowed IPs or allowed users to see the debug prints
    * @return boolean true if allowed false if not
    * @since ADD MVC 0.0
    */
   static function current_user_allowed() {
      return add::is_developer();
   }




  /**
   * Prints request variables and sessions variables
   * @since ADD MVC 0.0
   */
   static function print_request() {

      $request = array(
            "url" => self::current_url(),
            "get" => $_GET,
            "post" => $_POST,
            "cookie" => $_COOKIE,
            "request" => $_REQUEST,
            "session" => $_SESSION
         );

      self::html_print($request,"Request");
   }

   /**
    * Returns the current url
    *
    * @since ADD MVC 0.0
    */
   static function current_url() {
      return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
   }

   /**
    * Prints/Returns location backtrace
    *
    * @param boolean $return true to return instead of echo
    *
    * @since ADD MVC 0.0
    */
   static function lines_backtrace($return=false) {
      $traces = debug_backtrace();
      $file_lines = array();

      foreach ($traces as $trace) {
         $file_line = array(
               'file' => $trace['file'],
               'line' => $trace['line']
            );
         $file_lines[]  = $file_line;
         if (count(array_keys($file_lines,$file_line))>20) {
            die("Possible infinite loop detected");
         }
      }
      if ($return)
         return $file_lines;
      else {
         foreach ($file_lines as &$file_line) {
            $file_line = implode(":",$file_line);
         }
         self::html_print($file_lines,"Location");
      }
   }

  /**
   * Returns the file and line number of the caller of the function
   * @since ADD MVC 0.0
   */
   static function caller_file_line() {
      $backtrace = static::caller_backtrace();

      if (!$backtrace) {
         return "Unknown Location";
      }

      $file_line = $backtrace['file'].':'.$backtrace['line'];

      $file_line            = preg_replace('/^'.preg_quote(add::config()->root_dir,'/').'\//','',$file_line);

      return $file_line;

   }

  /**
   * Returns the debug info of the caller
   * @since ADD MVC 0.7
   */
   static function caller_backtrace() {
      $backtraces = debug_backtrace();

      foreach ($backtraces as $backtrace) {
         $is_trace_class_debug = isset($backtrace['class']) && ($backtrace['class'] == __CLASS__ || is_subclass_of($backtrace['class'],__CLASS__));
         if (empty($backtrace['class']) || !$is_trace_class_debug) {
            break;
         }
         $caller_backtrace = $backtrace;
      }

      return $caller_backtrace;

   }

   /**
    * XMP Var Dump
    * var_dump with <xmp>
    * @author albertdiones@gmail.com
    * @since ADD MVC 0.0
    */
   static function var_dump() {
      $args = func_get_args();
      if (!$args) {
         $args[0] = static::get_declared_globals();
      }
      $var = call_user_func_array('self::return_var_dump',$args);
      if (add::content_type() == 'text/plain') {
         $output="\r\nFile Line:".self::caller_file_line()."\r\n".$var."\r\n";
      }
      else {
         $output="<div style='clear:both'><b>".self::caller_file_line()."</b><xmp>".$var."</xmp></div>";
      }
      self::restricted_echo($output);
      return $args[0];
   }

   /**
    * return_var_dump()
    * get var dump function
    * @param mixed $args
    * @since ADD MVC 0.0
    */
   public static function return_var_dump($args) {
      ob_start();
      call_user_func_array('var_dump',func_get_args());
      $var = ob_get_clean();
      return $var;
   }

   /**
    * return pretty var dump
    * get var dump function
    * @param mixed $arg
    * @since ADD MVC 0.0
    */
   public static function return_pretty_var_dump() {
      static $indentation = 0;
      static $indentation_length = 8;
      static $type_value_indentation = 1;
      static $key_indentation = 0;
      static $indentation_char = "\t";
      $dump = "";

      foreach (func_get_args() as $arg) {
         # array
         if (is_array($arg)) {
            if ($arg) {
               $dump .= "{";
               $indentation++;
               $max_key_length = max(array_map("strlen",array_keys($arg)));
               $pre_index_string = "* ";
               $key_indentation = ceil(($max_key_length-strlen($pre_index_string))/$indentation_length);
               foreach ($arg as $index => $value) {

                  $index_string = $pre_index_string.$index;
                  $index_value_indentation = $key_indentation - floor(strlen($index_string)/$indentation_length);
                  $dump .= "\r\n".str_repeat("$indentation_char",$indentation).$index_string;
                  $dump .= str_repeat("$indentation_char",$index_value_indentation);
                  /**
                   * add_debug::pretty_var_dump() causes infinite loop on self referrences
                   * @see https://code.google.com/p/add-mvc-framework/issues/detail?id=51
                   */
                  if (self::return_var_dump($value) == self::return_var_dump($arg)) {
                     $dump .= "*RECURSION*";
                  }
                  else {
                     $dump .= static::return_pretty_var_dump($value);
                  }
                  $index_value_indentation = 0;
               }
               $key_indentation = 0;
               $dump .= "\r\n";
               $indentation--;
               $dump .= str_repeat("$indentation_char",$indentation)."}\r\n";
            }
            else {
               $dump .= "{}\r\n";
            }
         }
         # String
         else if (is_string($arg)) {
            $type_string = "str(".strlen($arg).")";
            $dump .= $type_string;
            if (strlen($arg) > 70) {
               $indentation_string = str_repeat("$indentation_char",
                     $indentation
                     + $key_indentation
                  );
               $dump .= " (word-wrapped)\r\n";
               $dump .= $indentation_string.wordwrap($arg,70,"\r\n".$indentation_string)."\r\n";
            }
            else {
               $indentation_string = str_repeat("$indentation_char",$type_value_indentation - floor(strlen($type_string) / $indentation_length) + 1 );
               $dump .= "$indentation_string\"".$arg."\"";
            }
         }
         else if (is_int($arg) || is_float($arg) || is_bool($arg)) {
            $type_string = gettype($arg);
            $dump .= $type_string ;
            $dump .= str_repeat("$indentation_char",$type_value_indentation - floor(strlen($type_string)/$indentation_length) + 1 );
            if (is_bool($arg)) {
               $dump .= $arg ? "true" : "false";
            }
            else {
               $dump .= $arg;
            }
         }
         else if (is_object($arg)) {
            $type_string = get_class($arg);
            $dump .= $type_string ;
            $dump .= str_repeat("$indentation_char",$type_value_indentation - floor(strlen($type_string)/$indentation_length) + 1 );
            $dump .= static::return_pretty_var_dump(get_object_vars($arg));
         }
         else {
            ob_start();
            call_user_func_array('var_dump',func_get_args());
            $dump = trim(ob_get_clean());
         }
         $dump .= "\r\n";
      }

      return $dump;
   }


  /**
   * make a list out of $arg
   *
   * @param mixed $arg the data to print
   * @param string $name the title of this list
   *
   * @since ADD MVC 0.0
   */
   static function html_print($arg,$name) {
      ob_start();
      if (is_array($arg) || is_object($arg)) {
         echo("<ul class='html_print_ul html_print'><li>
             <b onclick='$(this).parents(\"li:eq(0)\").find(\"ul\").slideToggle()' style='cursor:pointer;text-decoration:underline;'>$name</b> <small>(".gettype($arg)."{".count($arg)."})</small>");

         foreach ($arg as $i=>$value) {
            self::html_print($value,$i);
            unset($value);
         }

      }
      else {
         echo("
           <ul class='html_print_one_item html_print'><li>
           <b>$name</b> <small>(".gettype($arg).")</small>");
         echo(": ");

         if (filter_var($arg,FILTER_VALIDATE_URL)) {
            echo("<a href='".htmlspecialchars($arg)."' target='_blank' >");
            if (preg_match('/(?i)\.(jpg|gif|png)/',$arg))
               echo("<img src='".htmlspecialchars($arg)."' border=0 onmouseover='$(this).css(\"height\",\"\")' onmouseout='$(this).css(\"height\",20)' style='height:20px;color:#888;'/>");
            else
               echo("$arg");
            echo("</a>");
         }
         else
            echo("$arg");
      }
      echo("</li></ul>");
      $output = ob_get_clean();
      self::restricted_echo($output);
   }

  /**
   * evaluates $var and prints $var and the value it returns
   *
   * @param string $var the command to eval
   *
   * @since ADD MVC 0.0
   */
  static function print_eval($var) {
      $var=preg_replace('/\$(\w+)/','$GLOBALS[$1]',$var);
      echo "<b>".htmlspecialchars($var)."</b> ";

      if (strpos($var,"return ")===false)
         $var = eval("return $var;");
      else
         $var = eval($var);

      if (is_string($var)) {
         echo $var."<br />";
      }
      else {
         echo "<xmp>".self::return_var_dump(array($var))."</xmp><br />";
      }

   }

   /**
    * Prints array into a HTML table
    *
    * @param array $array the array to convert
    *
    * @since ADD MVC 0.0
    */
   static function print_array_table($array) {
      if ($array) {
         $fields = array_keys($array[0]);
         echo "<table style='min-width:100%;border:1px solid #ccc;background:#e8e8e8' cellspacing=0 cellpadding=5 >";
         echo "<tr>";
         foreach ($fields as $field) {
            echo "<td style='font-weight:bold;background:e0e0e0;'>$field</td>";
         }
         echo "</tr>";
         $count = 0;
         foreach ($array as $item) {
            if ($count % 2 == 0) {
               $background = "#e0e0e0";
            }
            else {
               $background = "#d8d8d8";
            }
            echo "<tr>";
            foreach ($fields as $field) {
               echo "<td style='border:1px solid #e0e0e0;background:$background'>".$item[$field]."</td>";
            }
            echo "</tr>";
            $count++;
         }
         echo "</table>";
      }
   }

   /**
    * deprecated_file() function
    * Call this on deprecated files
    * @since ADD MVC 0.0
    */
   public static function deprecated_file() {
      $locations = self::location();
      $var_dump = self::return_var_dump($locations);
      mail(self::EMAIL_ADDRESS,"DEPRECATED FILE STILL IN USE ".self::caller_file_line(),$var_dump);
   }

   /**
    * Returns an array of declared globals
    * @since ADD MVC 0.0
    */
   public function get_declared_globals() {
      return array_diff_key(
            $GLOBALS,
            array_flip(
                  array(
                        '_GET',
                        '_POST',
                        '_COOKIE',
                        '_REQUEST',
                        '_SERVER',
                        '_FILES',
                        '_ENV',
                        'php_errormsg',
                        'HTTP_RAW_POST_DATA',
                        'http_response_header',
                        'argc',
                        'argv',
                        'GLOBALS',
                     )
               )
         );
   }


   /**
    * Prints the config value
    *
    * @since ADD MVC 0.7.4
    */
   public static function print_config($field, $boolean = false) {
      $value = isset(add::config()->$field) ? add::config()->$field : null;

      $label = "config - $field";

      if ($boolean) {
         $value = (bool)$value;
         $label .= " declared";
      }

      static::print_data($label,$value);
   }

   /**
    * Prints a data with label
    *
    * @param mixed $label
    * @param mixed $value
    *
    * @since ADD MVC 0.7.4
    */
   public static function print_data($label,$value) {
      static::restricted_echo( static::return_print_data($label, $value) );
   }

   /**
    * Returns the printable data
    *
    * @param mixed $label
    * @param mixed $value
    *
    * @since ADD MVC 0.10.4
    */
   public static function return_print_data($label,$value) {
      $smarty = new add_smarty();
      $smarty -> assign('label',$label);
      $smarty -> assign('value',$value);
      $smarty -> assign('indentations',0);
      return $smarty->fetch('debug/print_data.tpl');
   }
}