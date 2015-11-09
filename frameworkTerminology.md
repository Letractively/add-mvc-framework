**Warning** Terms definitions are used only for framework use.

### Framework ###
the ADD MVC Framework or the ADD MVC framework directory

### Config ###
Can refer to both config variable or the config file

#### Config Variable ####
the framework configuration php variable, usually accessed through add::config() or $C

#### Config File ####
> The file containing or declaring the Config Variable

### Main Execution File ###
> The PHP file executing the framework according to the current request. (eg. add.php). File name is configured on the ADD Framework .htaccess rewrite rule.

### ADD Framework .htaccess rewrite rule ###
> The .htaccess write rule that rewrites non-existing filepath and the directory index to the Main Execution File.

### Controllers ###
> PHP Classes that contains the execution process. Processes the request of the user and and use it to manipulate both view and models.
### Models ###
> PHP Classes represent and manipulate database tables. It is used to get model instances.

#### Model Instances ####
> Represents and manipulates row from the table

### View Files ###
> The presentation file. (eg. the HTML)

### Mode ###
#### Request Mode Variable ####
> (of controllers) A variable determining which mode of the controller will execute
#### Mode Process ####
> (of controllers) A separate method automatically executing if the request mode variable matches.

### Sub Mode ###
> (of controllers) A variable

### href ###
any URL, or path

#### path ####
> URL path, excluding the domain

#### url ####
> the url path, with http/s and the domain

### filename ###
> eg. example.php

### basename ###
the filename without extension

### dir ###
> filesystem path to a directory

### file path name ###
the file system path including the file name eg. /path/to/dir/example.php

### overload ###
> used when overriding (instead of overriding) methods and properties on child classes