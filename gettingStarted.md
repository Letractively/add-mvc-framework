Note: at any point you can [ask question here](https://code.google.com/p/add-mvc-framework/issues/entry?template=Ask%20a%20Question)

# Skill Requirements #

The required skills to use this framework
  * Object Oriented PHP
  * Smarty PHP Templating

Additional skills that will help:
  * ADOdb PHP database abstraction
  * MVC Framework experience
# System Requirements #
  * PHP Version >= 5.3.8
  * MySQL >= 5
  * Other:
    * [Smarty system requirements](http://www.smarty.net/docs/en/installation.tpl#installation.requirements)
    * [AdoDB system requirements](http://adodb.sourceforge.net/#docs)

---

# Basic Files #
![https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/basic-files.png](https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/basic-files.png)

> It is required that you have **.htaccess** and main execution file (**add.php**) on your application root directory. And ideally you will also have **config.php** and the include directory (**/includes**) and the assets directory (**/assets**)

> Ideally, the structure of assets and includes directory is:

  * /includes
    * /includes/classes
    * /includes/views
    * /includes/libs
    * /includes/functions
  * /assets
    * /assets/images
    * /assets/js
    * /assets/css


## Config ##

Ideally you will have config variable:
```
<?php
$C = (object) array(
      # Relative path(with leading and trailing slashes) from the domain index. optional, but strongly recommended
      'path' => '/my-app/', # e.g. http://add.ph/my-app/
      /**
       * Set environment status to development.
       * for security reasons, this is set to "live" environment status by default
       */
      'environment_status' => 'development',
   );
```


Either you put it on a separate file (eg. config.php) or on the main  execution file (eg. add.php)


for more information go to [config variables page](configVariables.md)


## .htaccess Rewrite ##
create an htaccess rewrite

**.htaccess**
```
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ add.php?add_mvc_path=$1&%{QUERY_STRING} [L]
RewriteRule ^$ add.php?add_mvc_path=$1&%{QUERY_STRING} [L]
```

Notice above that "add.php" is used, depending on the name of your _main execution file_

AS you may have noticed it will only rewrite to the main execution file when the original file is not existing. This enables developers to have there own non-framework file to run. This will also enable smooth transistion from another (non-rewriting?) framework to another.

### Alternative home page ###
You can also have alternative home page by redirecting or rewriting before the _main execution file_ rewrite:

```
RewriteEngine On

RewriteRule ^$ my-page [L,R=302]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ add.php?add_mvc_path=$1&%{QUERY_STRING} [L]
RewriteRule ^$ add.php?add_mvc_path=$1&%{QUERY_STRING} [L]
```

## Main Execution File ##

Main execution file will act as a gateway, that will be running on all our ADD MVC resources

eg. **add.php**:
```
<?php
/**
 * Sample Main Execution File
 *
 */
# Require the config file
require '../config.php';

# Require the add mvc framework's init.php
require 'includes/frameworks/add/init.php';

# Execute the automatically detected controller
add::current_controller()->execute();

```

Graphically that is:

![https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/add-mvc-main-execution-file.png](https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/add-mvc-main-execution-file.png)

add::current\_controller() returns the current controller according to the current path, and execute() is the execution function, as the name implies.

Before execute() you can add your own processes that you want to run on all add mvc resources(pages) like setting your timezone, requiring logged in, restricting IPs etc.

You can also replace it with your own code, for example you just want to use [ADD framework as library](useAsLibrary.md)



And that completes the ADD MVC installation, we can now create our controllers.



---


# Making Pages/Resources #

## Controllers ##
To make pages/resources, a controller class and a Smarty view file (or one of them) with the same basename.

e.g. for page http://add.ph/login you will create ctrl\_page\_login.class.php class file with ctrl\_page\_login class declared inside it.

To overwrite the default index page (i.e. the home page), you should make <ctrl\_page\_index.class.php> file under your includes/classes directory.

note: there is a default index page and it should be replaced

For more info go to [Controllers wiki](controllers.md)


## Views ##
ADD MVC uses smarty templating engine on the View, the view names are the same as the controller's basename.


For more information go to [Libraries: Smarty chapter](popularLibraries#Smarty.md)

### Controllers/Views Example ###
#### Your First Controller ####
`includes/classes/controllers/ctrl_page_index.class.php`
```
<?php
/**
 * ctrl_page_index default index page (home page)
 * A sample index page controller
 *
 */
CLASS ctrl_page_index EXTENDS ctrl_tpl_page {

   /**
    * The pre-view process
    *
    */
   public function process_data() {
      $this->assign('current_controller',add::current_controller_class());
      $this->assign('current_view',$this->view_filepath());
      $this->assign('timestamp',time());

   }

}
```

#### Your First View ####

`includes/views/pages/index.tpl`
```
{*SMARTY*}
{extends file='common_layout.tpl'}
{block name=main}
   <h1>Simple Example</h1>
   <p>Hi! This is a very simple implementation of ADD MVC Framework.</p>

   <p>Just edit <b>{add::config()->views_dir|replace:'\\':'/'}/{$current_view}</b> to change the view</p>

   <p>You can also edit the controller: <b>{$current_controller}.class.php</b></p>

   <p>current UTC time: <b>{"Y-m-d h:i:s"|date:$timestamp}</b></p>

{/block}
```

#### Result ####

![https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/simple-index.png](https://add-mvc-framework.googlecode.com/svn/wiki/assets/images/simple-index.png)


With controllers and views alone you can already create pages. But if you want to use the full power of ADD MVC, you will also use models, which is on the next chapter [Accessing the database](gettingStarted#Accessing_the_Database.md).

Note: making a page view without controller also works (it'll use `ctrl_default_page` class)



---




# Accessing the Database #

Accessing database in ADD MVC is done by models; models, in ADD MVC framework represent a table from the database. For example we have a table named "companies"

It is recommended that these models uses ADODB returned by there db() method.

## Your ADODB connection ##
before models could work, you will need to get the ADODB connection:
```
CLASS my_adodb_mysql EXTENDS add_adodb_mysql {
   /**
    * Connect
    *
    */
   public function Connect() {

      $this->adodb->Connect(
            # Variables declared on config file
            add::config()->mysql_host,
            add::config()->mysql_username,
            add::config()->mysql_password,
            add::config()->mysql_db_name
         );

      return $this;
   }
}
```

Note that `add_adodb_mysql` and it's parent class is a wrapper for the real adodb object. This was done so the errors are automatically thrown as [e\_database](addExceptions#Exception_Classes.md).

For more information, see the [Libraries ADOdb Chapter](popularLibraries#ADOdb.md)

## Your First Model ##
```
/**
 * A model representing `members` table
 */
CLASS member EXTENDS model_auth {
   /**
    * The table of this model
    */
   const TABLE = 'members';
   /**
    * The primary key of this model
    */
   const TABLE_PK = 'id';
   /**
    * The db abstraction layer
    */
   public static function db() {
      return my_adodb_mysql::singleton();
   }
}
```

note that it extends a built-in extra model model\_auth, but the very basic abstract model you can extend is model\_rwd which contains loads of functions for manipulating data from the database.

```
/**
 * model of company table
 */
CLASS company EXTENDS model_rwd {
   /**
    * the table of this model
    */
   const TABLE = 'companies';

   /**
    * the primary key of this model
    */
   const TABLE_PK = 'company_id';

   /**
    * The db abstraction layer
    */
   public static function db() {
      return my_adodb_mssql::singleton();
   }
}
```

You can also extend model\_r (read only) and other extra models like model\_image\_rwd

note that, all the fields of the table (e.g. companies table) are being fetched. This might be adjustable in the future versions, but that's the way it is as of now.



### Using models ###

```
/**
 * A homepage of a membership website, getting the current logged in user and a featured member
 *
 *
 * @uses member model
 */
CLASS ctrl_page_index EXTENDS ctrl_tpl_page {
   /**
    * The pre-response process
    */
   public function process_data() {

      # Getting the current logged in
      $this->assign('current_member',member::current_logged_in());

      # Getting member with id = 1
      $this->assign('featured_member',member::get_instance(1));
   }

}
```

Another Example:
getting all the rows from the database (or SELECT `*` )
```

$companies = company::get_all();

foreach ($companies as $company) {
   echo "$company->company_name"; # print the company_name field
}

```

For more information about models, go to [Models Page](models.md)

## Other Classes ##
  * [Debugging classes (debug, add\_debug, add\_debug\_timer, add\_debug\_mail)](debugging.md)
  * Mailer class ([ctrl\_abstract\_mailer](http://mvc.add.ph/docs/classes/ctrl_mailer_abstract.html))
  * DOM and curl ([dom\_wrapper](http://mvc.add.ph/docs/classes/dom_wrapper.html), [add\_curl](http://mvc.add.ph/docs/classes/add_curl.html))
  * [Exceptions (e\_add)](addExceptions.md)
  * Interfaces ( [i\_auth\_entity](http://mvc.add.ph/docs/classes/i_auth_entity.html), [i\_ctrl](http://mvc.add.ph/docs/classes/i_ctrl.html), [i\_ctrl\_with\_view](http://mvc.add.ph/docs/classes/i_ctrl_with_view.html), [i\_non\_overwriteable](http://mvc.add.ph/docs/classes/i_non_overwritable.html), [i\_singleton](http://mvc.add.ph/docs/classes/i_singleton.html), [i\_with\_view](http://mvc.add.ph/docs/classes/i_with_view.html))
  * LDAP classes ([add\_ldap](http://mvc.add.ph/docs/classes/add_ldap.html))
  * session variable based classes ([session\_entity](http://mvc.add.ph/docs/classes/session_entity.html), [session\_user](http://mvc.add.ph/docs/classes/session_user.html))