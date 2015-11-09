# Use Different Filenames #
You can also use your own filenames aside from listed on [gettingStarted](gettingStarted.md) aside from .htaccess of course.

## Renamable files examples ##
  1. Config file (config.php)
  1. Main execution file (add.php)
  1. ADD Configure file (add\_configure.php)
  1. Includes directory
  1. Assets path / directory

### Config file ###
> You can do this by simply renaming the require()d file on _main execution file_ (add.php) or the _ADD Configure file_

example:

```
<?php

# Config file: settings.php
require 'settings.php';

# Require the add mvc framework's init.php
require 'includes/frameworks/add/init.php';

# Execute the automatically detected controller
add::current_controller()->execute();
?>
```

### Main Execution File ###
> You can use different file name for the main execution file by editing .htaccess rewrites, say you want to use "add-execute.php" instead:

.htaccess:
```
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ add-execute.php?add_mvc_path=$1&%{QUERY_STRING} [L]
RewriteRule ^$ add-execute.php?add_mvc_path=$1&%{QUERY_STRING} [L]
```

### ADD Configure file (add\_configure.php) ###
> You can use different filename for the add configure file, by just renaming the filename on your require()s

say you want to use "add\_require.php" instead:

debug\_session.php
```
<?php
require 'add_require.php';

debug::var_dump($_SESSION);

?>
```



### Includes directory ###
> You can also change the entire includes directory path, hence affecting all sub directories ( classes, views etc.)

> You can do this by setting $C->incs\_dir

> Say you want it to be "add-mvc/includes"

config.php:
```
<?php
$C = array(
      'environment_status'  => 'development',
      'incs_dir' => realpath('add-mvc/includes/')
   );

?>
```

realpath() is probably optional


### Assets path / directory ###
> You can set a custom path for the assets directory (filesystem) and path (relative/absolute url), this is also set on the config variable, $C->assets\_dir and $C->assets\_path respectively.

  * ote**: on views that doesn't use add::config()->assets\_path, add::config()->images\_path, add::config()->css\_path, add::config()->js\_path, this configuration doesn't matter.**

> say you want to use "assets-2.0" instead of "assets"

config.php:
```
<?php
$C = array(
      'environment_status'  => 'development',
      'assets_dir' => 'assets-2.0/'
      'assets_path' => '/assets-2.0/'
   );

?>
```

Now if you want to set a custom image path:
config.php:
```
<?php
$C = array(
      'environment_status'  => 'development',
      'images_path'         => '/images/', # /images/ , not /assets/images/
   );

?>
```