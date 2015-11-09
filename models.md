# Introduction #
> on ADD MVC, model classes represents table of the database.

> for each table on the database you want to manipulate, you will have to create a model for it.

> ADD Framework's models uses adodb abstraction layer, or you can also wrap it first, as long as the adodb methods are callable (e.g. `GetArray()`, `SelectLimit()` etc.)


## Model Names ##

> the class names of models is not restricted, but as a good practice, use the singular form of the table names (eg. member for ```members``` table)


## Basic Code ##

```
CLASS company EXTENDS model_rwd {
   /**
    * The table
    */
   const TABLE = 'company';
   /**
    * The table's primary key
    */
   const TABLE_PK = 'company_id';
   /**
    * The ADODB object
    *
    */
   public function db() {
     return my_application_adodb::singleton();
   }
}
```

Where: const TABLE is the table of the company and TABLE\_PK is the primary key field and db() is the adodb object

## Basic Functions ##
  * insertion example:
    * `company::add_new(array $row)` - inserts a new row and returns the new instance
```
<?php
   #...
   $company = company::add_new(
         array(
               'name' => 'ADD Systems',
               'address' => '1234 Foo St. Philippines',
               'category_id' => 12,
               'insert_time' => time(),
               'update_time' => time()
            )
      );
   # echos company name
   echo "Inserted: ".$company->name;
   #...
```
  * selection example:
    * `company::get_instance(mixed $id)` - gets the row with primary key $id
```
<?php
   #...
   # Gets the company with id 1234
   $company = company::get_instance(1234);

   echo <<<EOT
Company Name: $company->name
Address: $company->address
EOT;

   #...
```
    * `company::get_where_order_page(mixed $where, string $order_by, int $page, int $per_page)` - returns array of instances of the model according to the parameters given
```
<?php
   #...
   # Gets companies with category_id = 12, newest first
   $companies = company::get_where_order_page( array( 'category_id' => 12 ) 'ORDER BY insert_time DESC');
   debug::var_dump($companies
   #...
```
    * `company::instances_from_sql($sql_format)` - will return an array of model object instances from a sql format - This function will enable custom queries specially for joins
```
<?php
   #...
   # Gets companies with category "Petroleum"
   $companies = company::instances_from_sql(
          "
          SELECT %s 
          FROM %s INNER JOIN categories ON category_id = categories.id
          WHERE categories.name = 'Petroleum'
          "
      );
   #...
```
> The sql will end up as something like:
```
          SELECT companies.*
          FROM companies INNER JOIN categories ON category_id = categories.id
          WHERE categories.name = 'Petroleum'
```

  * updates example:
    * `$company->name="New Company Name" `
> > assign a new value on the object property and it will updated on script shutdown
```
<?php
   #...
   # Gets the company with id 1234
   $company = company::get_instance(1234);

   # update fields
   $company->name = 'ADD Technologies';
   $company->address = '1234 Baz City Philippines';
   $company->update_time = time();

   # ^ $company row will be automatically updated on script shutdown

   # OR

   $company2 = company::get_instance(2345);

   # update fields
   $company2->address = '55634 Foo City US';
   $company2->update_time = time();


   # Force update immediately for $company2
   $company2->update_db_row();
   

   

   #...
```
  * delete example:
    * `$company->delete()`
```
<?php
   #...
   # Gets the company with id 1234
   $company = company::get_instance(1234);

   # Delete this company row
   $company->delete();

   # note: the object variable will still be useable for reading

   #...
```

## Abstract Model Classes ##
  * [model\_rwd](http://mvc.add.ph/docs/classes/model_rwd.html) - Read Write Delete Model
  * [model\_r](http://mvc.add.ph/docs/classes/model_r.html) - Read Only Model
  * [model\_auth](http://mvc.add.ph/docs/classes/model_auth.html) - For model that are meant for tables of users that logs in. or any entity that is authenticated
    * Note: Check the constants before using this class.
  * [model\_image\_rwd ](http://mvc.add.ph/docs/classes/model_image_rwd.html) For having a filesystem image with 1:1 related database row

### model\_auth example ###
```
<?php

/**
 * admin model
 *
 */
CLASS admin EXTENDS model_auth {
   const TABLE = 'view_admins';

   const USERNAME_FIELD = 'email';

   const SESSION_KEY = 'add.ph_admin';

   const LOGIN_PAGE = 'admin/login';

   /**
    * The ADODB Object
    *
    */
   public static function db() {
      return adodb_addph::singleton();
   }

}
```

## Tips ##
  * Table related methods should be static context while row related functions are object.
  * Model names should be singular, (e.g. member::get\_instance())
  * Methods that will return array of instances should be plural ( e.g. $member->transactions() )
  * Methods that will get foreign instances should have the same name (plural form) as it's model (e.g. $member->vehicles() // Where vehicle is a model related to member)


## Function List ##
  * Maybe it's better to look at the phpdoc included in the framework **> ### model\_rwd::db() ###
> > returns the adodb object. To set this, extend this inside the concrete model class so you can return your own value. (There is no default)

> ### $model\_rwd->update\_db\_row() ###
> > updates the updated fields of the row (instead of waiting for script shutdown)

> ### model\_rwd::instances\_from\_sql() ###
> > gets all the instances from the select sql**

**Parameters**
  * $sql\_format (required) - must contain 2 %s, the first is for to be replaced with "`*`" and the table name of the model class.
  * $page - page number to fetch ($per\_page required)
  * $per\_page - number of rows per page
```
   $company = company::instances_from_sql("SELECT %s FROM %s WHERE category='1'");
```
note: you have to use %% for % when using this function (eg. `LIKE '%%foo%%'`)

> ### model\_rwd::get\_where\_order\_page() ###
> > Centralized select query
**Parameters**
  * mixed $conditions array or string of conditions
  * string $order\_by string to use as order by (default: none)
  * int $page for limit clause (default: gets all)
  * int $per\_page number of items per page for limit clause (default: 10 per page)
```
# gets the page 2 (20 per page) of all row instances where category is equal to 1
$companies = company::get_where_order_page(array('category' => '1'),2,20);
```


> ### model\_rwd::get\_count() ###
> > get the count of rows
**Parameters**
  * mixed $conditions - conditions (where)


> ### model\_rwd::get\_page\_instances() ###
> > get all instance from static::TABLE matching ALL $conditions , with pagination of page 1, 10 rows/page

  * int $page to fetch
  * order by clause
  * mixed $conditions the where clause conditions
  * int $per\_page instance count per page