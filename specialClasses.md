ADD MVC comes with classes that are for special uses. They are not necessarily used on all projects, or not yet finalized or finished.

## session\_entity ##
This is a class wrapper for significant session variables.

### session\_user ###



---




## add\_ldap ##
A wrapper class for ldap library, supports search.

There is a deprecated class ldap\_member that can be used like model\_auth() when logging in with ldap

## add\_encryptor ##
A class for reversible encryption

## array\_entity ##

A very special class that wraps an array, extended by model\_rwd, session\_entity and alot other classes.

Supports [Encapsulation](http://en.wikipedia.org/wiki/Encapsulation_%28object-oriented_programming%29), [PHP Overloading](http://www.php.net/manual/en/language.oop5.overloading.php) ( `__get()`, `__set()`, `__isset()`, `__unset()`)




---




## add\_curl ##
A wrapper class for curl. Supports caching, proxies and user agents masking.

## dom\_wrapper ##
A wrapper class for DOM classes. Supports CSS selector finding (like JQuery), html() and text().

`dom::factory()` then creates the `dom_document_wrapper`, `dom_element_wrapper` and `node_list_wrapper()`

`dom_wrapper::factory($arg1)`

$arg1 is either object of DOMDocument or DOMElement

### dom\_document\_wrapper ###
Wrapper for [DOMDocument](http://php.net/DOMDocument)

### dom\_element\_wrapper ###
Wrapper for [DOMElement](http://php.net/DOMElement)

### node\_list\_wrapper ###
Wrapper for [DOMNodeList](http://php.net/DOMNodeList)




---




## pagination ##
Pagination class is a very useful for paged controllers.

No smarty view support yet.