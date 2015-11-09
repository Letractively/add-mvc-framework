# 0.11 #
  * "add\_current\_user" & "current\_user" class that will contain functions for the current user
    * ip\_in\_network()
    * is\_developer()
    * geoip()
    * $track\_pages = false;

# 0.12 #
  * models
    * model->< foreign\_model\_name >() by using call and a static array
    * Auto foreign key detection
    * Columns fetching(meta\_columns()) and validation on valid\_magic\_property

# 0.13 #
  * Debugging
    * new environment status: dynamic\_live\_development
    * add\_debug\_class\_wrapper: dynamic class debugging wrapper
    * Shorten filenames of smarty compiled files when showing them as errors
    * add::exception($preferred\_class, $message, $data)

# 1.0 #
(from trunk, stable versions of 0.11 to 0.13 will also be merged)
  * Standardization and readability
    * ctrl\_resource_`*` instead of ctrl\_page_`*`
    * ctrl\_tpl\_resource as parent of ctrl\_tpl\_page, ctrl\_tpl\_aux, ctrl\_tpl\_ajax
    * ctrl\_abstract_`*` instead of ctrl\_tpl_`*`
  * maximized use of SPL components
  * drop backward compatiblity support for versions below 0.9


# Version x.x #
  * Debugging
    * new environment status: dynamic\_maintenance
  * add class
    * Change add class to add\_application.class.php so developers can extend it with add.class.php
  * Extra Niche classes
    * ldap\_entity - LDAP entity object class (extends array\_entity)
      * parent class of ldap\_cn
      * deprecate ldap\_member
    * block\_rules - model support
    * i\_add\_class interface
  * URLS
    * path canonicalization
    * https requirement and redirect
    * controller config redirect
  * Uncategorized
    * Non error exceptions