# Introduction #
A MVC Framework from the old "db\_entity" class Albert used on past projects from April 2011 to April 2012.

It has been developed since then and turned into a framework this May 2012

# Features #
  * built in abstract controllers for pages, mailers, ajax and auxiliary scripts,
  * built in abstract model for common kind of tables
  * built in views for index, 404
  * views using smarty template
  * db connection using adodb
  * mailer controller using phpmailer
  * Extra classes:
    * custom exception classes
    * dom wrapper classes
    * debugging classes
    * interfaces

# Models #
Unlike other MVC frameworks, the models on ADD MVC are always associated to a table, and there are already bunch of static functions that will fetch new instance of that model class, that represents a row on the table.

Therefore the model class represents the table(static context), while the instance of that model represents a row of that table (object context)

However these model is not the connection to the database, instead it's everything that deals with the tables. These models connects using adodb that they contain on there ::db() static function

# Views #
views are create through templating library Smarty, default views are under add/views and you can overwrite it by having the same file on your includes/views directory

# Class Autoloading #
Unlike other MVC frameworks, class autoloading on ADD MVC framework is not restricted to very specific directory hierarchy, as long as the directory is under the includes/classes of your application.

# Class Overriding #
When you want to edit a built-in class, view or library or function file, you just need to put a file with the same name under your includes directory. (eg. to override `add/classes/controllers/ctrl_page_404.class.php` you can create a ctrl\_page\_404.class.php under your includes/classes)