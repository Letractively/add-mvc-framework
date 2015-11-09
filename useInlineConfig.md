You can use inline config variable instead of declaring it on a separate file:

add.php:
```
$C = array(
      'path'               => '/app/v4/',
      'environment_status' => 'development'
   );

require 'add-mvc/init.php';

add::current_controller()->execute();
```