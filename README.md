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

### Caching

Image manipulation library Glide uses caching and after every insert
user is redirected to single page (not used publicly) to create images
in cache, so audience can get their picture faster.
If you need to warm up cache earlier (for example after adding content manually)
you can run:
~~~bash
php warm-up-chache.php
~~~
This will recreate all sizes, for all images not already in cache in jpg, avif, webp.