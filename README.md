Positive
========

System for really minimalistic photo sharing.

## Installation

### Setup password
~~~bash
php -r "echo password_hash('[YOUR_PASSWORD_HERE]', PASSWORD_DEFAULT);"
~~~

## Notes

### Pagination

* If you change pagination size, it will change URLs in feeds.
* Posts are paginated like in a book: page 1 is older than 2.