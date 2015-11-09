# Introduction #
In ADD Framework, Resources(pages) are created through controllers classes stored in classes directory.

on the main execution file (e.g. add.php) add::current\_controller() fetches the controller for the current page, then it's execute() method is called.

ADD MVC controllers has [Modes and Sub Modes](modesAndSubModes.md) that enables code isolation for different modes and/or actions. And GPC(or global) variable registration system.


# Default Controller Classes #
  * [ctrl\_page\_index](http://mvc.add.ph/docs/classes/ctrl_page_index.html) - default homepage
  * [ctrl\_page\_404](http://mvc.add.ph/docs/classes/ctrl_page_404.html) - default 404 page

# Abstract Controller Classes #
  * [ctrl\_tpl\_page](http://mvc.add.ph/docs/classes/ctrl_tpl_page.html) - for normal html pages
  * [ctrl\_tpl\_ajax](http://mvc.add.ph/docs/classes/ctrl_tpl_ajax.html) - for ajax resources
  * [ctrl\_tpl\_aux](http://mvc.add.ph/docs/classes/ctrl_tpl_aux.html) - for auxiliary controllers


### Controller Methods ###

![https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/add-controller.png](https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/add-controller.png)

The following are few of the methods you will need the most:
  1. **`execute()`** - the root method of the controller. When execute() ( formerly page() ) is called, by default it calls process\_data() ( formerly process() ) and print\_response(). There will only be a few chance that you will need to extend this method. Instead, see the following methods:
    1. **`process_data()`** - this method should contain the data processing of the controller. By default, this calls process\_mode()
      1. **`pre_mode_process()`** (version 0.9) - To be extended to add a process **before** the processing of the `$_REQUEST['mode']`
      1. **`process_mode()`** - Creates an array of registered gpc. Calls the applicable `process_mode_$_REQUEST['mode']`($gpc). For best practice this method should also not be extended
      1. **`post_mode_process()`** (version 0.9) - To be extend to add a process **after** the processing of the `$_REQUEST['mode']`
      1. **`process_mode_$_REQUEST['mode']`** - to be declared to have a custom process for a certain mode. see [Modes and Sub Modes](modesAndSubModes.md)
    1. **`print_response($data)`** - prints the view. For best practice this method should not be extended
  1. **`assign($field,$value)`** - assigns a data to the controller. This will also automatically call `smarty assign()` for the view.

### Modes and Sub Modes ###

ADD MVC has built in support for actions or modes (for consistency, we will call these "modes") of pages/resources (for consistency we will call these "resources").

Modes are further discussed on this page: [Modes and Sub Modes](modesAndSubModes.md)

# Examples #
demos/trunk/simple/includes/classes/ctrl\_page\_login.class.php
```
<?php
/**
 * Login controller demo
 */
CLASS ctrl_page_login EXTENDS ctrl_tpl_page {

   /**
    * Login Request variables - username and password from $_REQUEST
    *
    */
   protected $mode_gpc_login = array( '_REQUEST' => array( 'username', 'password' ));

   /**
    * Login
    *
    * @param array $gpc - contains $gpc['username'] and $gpc['password']
    *
    */
   public function process_mode_login($gpc) {

      # validation on controller
      if (empty($gpc['username'])) {
         throw new e_user_input("Blank username");
      }
      if (empty($gpc['password'])) {
         throw new e_user_input("Blank password");
      }

      # login the session user class
      member::login($gpc['username'],$gpc['password']);
   }



   /**
    * Logout request variables - none
    *
    */
   protected $mode_gpc_logout = array();
   /**
    * Logout mode
    *
    * @param array $gpc - blank array
    *
    */
   public function process_mode_logout($gpc) {
      member::logout();
   }

}
```