Note: page is under construction

# Making a table from query #

## Summary: Making a table from query ##
There is a table of companies is on the database, we need to create an html table out of the first 10 latest rows of it.


## Model: Making a table from query ##
```
<?php
/**
 * includes/classes/models/companies.class.php
 * note: this could also be anywhere under includes/classes directory
 *
 */
CLASS companies EXTENDS model_rwd {
   const TABLE = 'companies';
   #const TABLE_PK = 'id';# This is already the default TABLE_PK value

   /**
    * The database connection 
    */
   public static db() {
     static $db;
     if (!isset($db)) {
        $db = NewADOConnection('mysql');
        $db->Connect('localhost','root');
     }
     return $db;
   }
}
```

## Controller: Making a table from query ##
```
<?php
/**
 * includes/classes/controllers/ctrl_page_companies.class.php
 * note: this could also be anywhere under includes/classes directory
 *
 */
CLASS ctrl_page_companies EXTENDS ctrl_tpl_page {
   /**
    * "Pre mode" process
    *
    * Take note that we didn't used process_data() so we can enable modes in the future
    *
    */
   public function pre_mode_process() {
      $companies = company::get_where_order_page(null, "id DESC",1);
      $company_rows = array();
      foreach ($companies as $company) {
         $company_rows[] = $company->data_array();
      }
   }
}
```

to be continued...