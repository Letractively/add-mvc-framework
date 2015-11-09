ADD MVC uses popular libraries like [ADOdb](http://adodb.sourceforge.net/) and [Smarty](http://www.smarty.net/)


## Smarty ##
### Smarty Customizations ###
#### Directories ####
  * views/
    * pages/ - contains all the controller views
    * layouts/ - contains all the layout
#### Additional Functions ####
  * {add\_layout} - a copy of {extends} , but will automatically look on layouts/ directory and appends .tpl ( file= attribute should not have should not have .tpl )
  * {add\_include} - a copy of {include} , but will automatically look on includes/ directory and appends .tpl ( file= attribute should not have should not have .tpl )

Fore more info go to [Smarty Website](http://smarty.net/)

## ADOdb ##
An ADODB object should be returned on model's db() function, or else it will not work properly.

You can make a wrapper for it or use it directly

**Examples**

```
<?php
/**
 * my_application_model.class.php
 */
ABSTRACT my_application_model EXTENDS model_rwd {
   /**
    * Cache variable
    */
   static $D;

   /**
    * The ADOdb object for class that extends my_application_model class
    * This one doesn't use any wrappers so you'll have to get the error message yourself
    */
   public static function db() {
      if (!isset(static::$D)) {
         static::$D  = ADONewConnection('mysql');
         $static::$D -> Connect('localhost','root');
      }
      return $static::$D;
   }
}
?>

<?php
/**
 * member.class.php
 * member class
 */
CLASS member EXTENDS my_application_model {
   const TABLE = 'members';
}
?>


```