ADD MVC has several built in custom exception that can be throw()n or catch()ed.

They can be found under includes/classes/exceptions
## Exception Classes ##
  * `e_add`
    * `e_system` - A system error
      * `e_developer` - An error probably caused by a mistake of the developer
        * `e_syntax` - not used yet
    * `e_unknown` - An error with unknown or unsure cause can be both caused by user or the developer's mistake or the system's error
      * `e_database` - An error from the database
    * `e_user` - An error done by the user
      * `e_user_input` - An error on the input(s) or request of the customer
      * `e_user_malicious` - An error with suspected malicious intent
        * `e_hack` - A suspected hack attempt error done by the user
        * `e_spam` - A suspected spam done by the user

## Sensitive Exceptions ##
> All these exceptions except e\_user that is not under `e_user_malicious` are considered sensitive exceptions that are not shown to the user but instead be sent to the `e_add::$email_addresses`

## User Exceptions ##
> User exceptions are recorded under {`$error_messages`} array indexed by mode while the latest exception is at {`$error_message`}.
**Examples**
  * latest error message: {`$error_message`}
  * error message from mode "register": {`$error_message.user_register`}
```
{*SMARTY*}
{add_layout file='common_layout'}
{block name='main'}
   <form method="post">
      {$error_message} {* OR {$error_messages.user_register} *}
      <input name="email" type="text" />
      <input name="password" type="password" />
      <input name="name" type="text" />
      <input name="mode" value="register" type="hidden" />
      <button type="submit">Register</button>
   </form>
{/block}
```

## Assertions ##
> Assertion can be used to prevent or detect unusual situations or user errors.
**Examples**<?php
ctrl_page_register EXTENDS ctrl_tpl_page {
   /**
    * Register Mode GPCs
    */
   protected $mode_gpc_register = array(
         '_POST' => array( 'email' , 'password' , 'name' ),
      );
   /**
    * Register Mode
    */
   public function process_mode_register($gpc) {

      # First parameter is the condition that is required to be true, the second parameter is the message and the third parameter is the message
      e_user_input::assert( filter_var($email, FILTER_VALIDATE_EMAIL) , "Invalid email format, please check your email" );

      member::add_new($gpc);

   }
}```