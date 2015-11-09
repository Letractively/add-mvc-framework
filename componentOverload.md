ADD MVC provides overloading for classes (except add.class.php `[for now]` ). With this, you can customize the class when you don't want or can't extend it (or extending the class doesn't meet your need).

To do this, just put the class or view inside your includes/classes or includes/views directory, with the same relative path as the original class or view file.

For example you want to edit most of the ADD MVC class `model_rwd`, you will have to copy it and paste it under `includes/classes/` directory. (eg. includes/classes/models/model\_rwd.class.php) and then you can edit it anyway you want.

But the downside of this is you'll have to check these overriden classes when you upgrade the framework.



**Related**
  * [Component Extension](componentExtension.md)