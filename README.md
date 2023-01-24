Positive
========

System for really minimalistic photo sharing.
It does not strive to be universal, configurable or usable in any way.

## Installation

* clone
* run `composer install`
* serve as you are used, there is `Caddyfile.example` included

### Setup

There is `conf/site.defaults.json5` file with commented default setting.
Create new file `conf/site.json5` with content you want to change (password is mandatory).
Both files are loaded, you do not need to copy all, just overwrite needed.

#### Password 

User password is stored hashed, prepare hash like this:
~~~bash
php -r "echo password_hash('[YOUR_PASSWORD_HERE]', PASSWORD_DEFAULT);"
~~~

## Notes

### Pagination

* If you change pagination size, it will change URLs in feeds.
* Posts are paginated like in a book: page 1 is older than 2.