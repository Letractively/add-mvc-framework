ADD MVC enables developers to extend existing classes and views. This applies both to built in classes or views (i.e. smarty templates) or the controllers, models and other classes you made.

## Class Extension ##
If you know [PHP object oriented programming](http://www.php.net/manual/en/language.oop5.inheritance.php), then you will be familliar with this.

For example you want to require login before controller execution:
```
/**
 * class for admin pages
 *
 */
ABSTRACT CLASS ctrl_abstract_admin EXTENDS ctrl_tpl_page {

   /**
    * Login requirement before execution
    *
    */
   public function execute() {
      admin::require_logged_in();
      parent::execute();
   }
}
```

Just make sure you call the parent::method() because you will have infinite loop if you happen to use the self::method()

[more info/tips on controller methods](controllers#Controller_Methods.md)

## View Extension ##

[Smarty Template Inheritance](http://www.smarty.net/docs/en/advanced.features.template.inheritance.tpl)





**Related**
  * [Component Overload](componentOverload.md)