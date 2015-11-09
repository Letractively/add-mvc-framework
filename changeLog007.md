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