# Use ADD framework as library #

You can also use ADD framework as library by including just the init.php and not executing the current controller ( add::current\_controller()->execute() see [gettingStarted#Main\_Execution\_File](gettingStarted#Main_Execution_File.md))

You can create a file like this:
```

<?php
/**
 * Sample ADD Configure file
 *
 */
# Require the config file
require 'config.php';

# Require the add mvc framework's init.php, replace "includes/frameworks/add" with your own add mvc framework path. (look for init.php)
require 'includes/frameworks/add/init.php';

```

We will call such file, as "add configure" files so we can name it "add\_configure.php".

You can also use inline configs

```

<?php
/**
 * Sample ADD Configure file : add_configure.php
 *
 */
$C = (object) array(
      'path' => '/my-app/', 
      'environment_status' => 'development',
   );

# Require the add mvc framework's init.php, replace "includes/frameworks/add" with your own add mvc framework path. (look for init.php)
require 'includes/frameworks/add/init.php';

```


so if we want to use debug::var\_dump, on a test file or another framework, you will do:

```
<?php
require 'add_configure.php';

debug::var_dump($_SESSION);

?>
```