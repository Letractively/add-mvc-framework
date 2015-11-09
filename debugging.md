# Debugging Classes and Functions #

ADD MVC has built in debugging classes.

  * add\_debug & debug
  * add\_debug\_mailer
  * add\_debug\_timer
  * e\_add::assert() (?)


## debug::var\_dump() ##
> The most common method will be: debug::var\_dump($var) which prints the var\_dump nicely instead of it being non-html. It will also print the file path name and line number.

> This is to replace the browser unfriendly built in var\_dump(), additionally it'll be easier to track which is which with the file path name and line number

## debug::print\_request() ##
Prints in html the get, post, cookie, request, session variables of the current request.

## debug::print\_eval() ##
Evaluates the argument and print the code and the result