# Modes And Sub Modes #
## Modes ##
### Introduction ###
ADD MVC has built in support for actions or modes (for consistency, we will only call these "modes" from now on) of pages/resources (for consistency we will only use the term "resources" from now on).

The current mode of the resource depends on the `$_REQUEST['mode']` variable.

### Declaring modes ###
The [mode process method](ModesAndSubModes#Controller's_Mode_Process_Method.md) has to be declared for the mode to make any custom effect.

Controllers can be extended to have any modes, the method should be named: `process_mode_$_REQUEST['mode']`($gpc)

For example, you want a page to have a mode "login"

```
<?php
/**
 * The home page
 */
CLASS ctrl_page_index EXTENDS ctrl_tpl_page {
   /**
    * Login Mode Request Variables (aka GPC)
    */
   protected $mode_gpc_login = array(
         '_POST' => array('username' , 'password')
      );

   /**
    * Login Mode
    *
    * This function is automatically executed if:
    *  $_REQUEST['mode'] == 'login'
    *
    * @param array $gpc this is passed from process_mode() method
    *
    */
   public function process_mode_login($gpc) {
      # $gpc contains: { username: "myUsername", password: "myP@ssword" }
      extract($gpc);
      member::login($username,$password);
   }


}
```


## Sub Modes ##
**Since version 0.9**, sub modes are new way of segregating actions and modes of the request.

This is automatically registered to the mode process method's first argument ($gpc) . To be used on such situation that a mode requires two kinds of action or non-action is to be done.

For example, on a controller named  "pay" and with a mode named "credit\_card" that shows the payment form, instead of checking the $_POST variable to see if the form was submitted, we will just have an input[name=sub\_mode][type=hidden][value="submit"]
```
<?php
/**
 * pay page
 */
CLASS ctrl_page_pay EXTENDS ctrl_tpl_page {
   /**
    * Credit Card GPC
    */
   protected $mode_gpc_login = array(
         '_POST' => array('credit_card' , 'expiration_date')
      );

   /**
    * Credit Card Mode Process Method
    *
    * @param array $gpc this is passed from process_mode() method
    *
    */
   public function process_mode_credit_card($gpc) {
      extract($gpc);
      if ($sub_mode == "submit") {
         # charge_credit_card($credit_card,$expiration_date)
      }
      else {
         # Default value of credit card field
         $this->assign('credit_card','Please input your credit card number here');
      }
   }


}
```_

## Controller's Mode Process Method ##

ADD MVC has a built-in support for actions and modes (for consistency both actions and modes are to be referred to as modes).

Mode process methods are prefixed with `process_mode` (probably to be renamed to `mode_process_` for consistency with `mode_gpc_` prefix)

Mode process method should accept one argument, an array (to be referred from now on as: $gpc).

$gpc will be a dictionary array (ie. associative array) of the gpc field and the value of the request variable. Note that, this value is not sanitized.

Inside the method, it is recommended for it to be extract()'ed, so it can be accessed like a global variable.
```
<?php
/**
 * pay page
 */
CLASS ctrl_page_pay EXTENDS ctrl_tpl_page {
   /**
    * Credit Card GPC
    */
   protected $mode_gpc_login = array(
         '_POST' => array('credit_card' , 'expiration_date')
      );
}
```

## Mode GPC Property ##
GPC stands for get, post and cookie, which is, the request variable of PHP. On ADD MVC it refers to the request variables.

For modes, you will have to declare the mode gpc to be able to securely register a request variable and pass it to the mode's $gpc argument.

mode gpc keys are prefixed with `mode_gpc_` eg. `$mode_gpc_login`

Mode GPC property should be a dictionary (ie. associative array) with first dimension indexes as '_GET','_POST','_COOKIE' or '_REQUEST'. Then the value is a list array (ie. numeric indexes array) with the request variable names to be registered.

**Note:** registered GPCs are automatically assign()`````d on the controller.

### Common GPC ###

Since **version 0.9** there is a new convenient way of declaring GPCs, common GPC controller object property will contain GPC that are common for all modes, therefore making it available on  the $gpc variable.

This property is declared as `$common_gpc`

### GPC Security ###
#### Things to watch out for ####
  * Array inputs
  * XSS and SQL injections