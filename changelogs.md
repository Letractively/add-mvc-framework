# 0.10 #
  * includes/views/pages/ - directory where all pages will be placed
  * includes/views/layouts/ - directory where all layouts will be placed
  * ctrl\_default\_page - a ctrl for undeclared controllers with corresponding views/pages/

Other
  * includes/views/includes/ - directory where all include tpls will be placed
  * Connected `add::is_developer()`, `add::environment_status()` and `add::handle_shutdown()` so it is dependent and won't be incompatible with each other
  * bug fix: trailing slash on url (eg. /my-controller-name/ results to finding the `my_controller_name__`)

# 0.9 Modes & Sub Modes #
  * sub\_modes
  * common\_gpcs
  * pre\_mode\_process
  * post\_mode\_process


# 0.7 #
  * environment status
    * add::is\_development() - a function that returns boolean true or false if the environment\_status is "development"
    * add::is\_live() - a function that returns boolean true or false weather if the environment status is "live"
    * add::is\_debugging() - a function that returns boolean true or false weather the environment status is "debugging"
  * exceptions
    * email configuration improvements
      * Do not send email if on **development mode**
  * config
    * new required property: environment\_status
    * default configuration file


# 0.8 #
  * controllers
    * hierachy system
  * class autoloading
    * class directory variable
    * iterate through class directory variable for autoloading
    * :: add\_loaded() pseudo-magic function
  * add-usability.js
  * model_`*`::meta\_columns()
  * bug fixes
    * E\_USER\_ERROR layout fix
    * mime\_type - sensitive error/data/debug printing_

**0.7.1**
  * exceptions
    * assert() first parameter detection and printing
  * errors
    * printing the line codes
    * color coded errors
**0.7.2**
  * views
    * view when not found: default\_tpl.tpl - shows all the smarty template variables in html table form
  * error\_reporting change when live or development
  * execution time printing when development

**0.7.3 ( < 2012 08 07 )**
  * developers\_ip on config
  * add::is\_developer()
  * use add::is\_developer() on debug::current\_user\_allowed()
  * use add::is\_developer() to automatically switch to "debugging" environment status
  * trigger\_error on deprecated common functions
  * include network.functions.php on common functions
**0.7.4 ( < 2012 08 14 )**
  * Environment Status on the bottom when not live

# 0.6 #
New Classes
  * add\_encryptor
  * session\_entity
  * session\_user

Updated classes
  * ctrl\_tpl\_page
  * ctrl\_tpl\_ajax
  * ctrl\_tpl\_mailer
  * model\_rwd

New resource controller system:
  * execute() in replacing page()
  * process\_data() in replace of process()
  * print\_response() in replace of display\_view()
  * new function: assign()
  * new function: process\_response()

New way of setting adodb variable:
  * extending model