URL-Shortener Application
================

Phalcon PHP is a web framework delivered as a C extension providing high
performance and lower resource consumption.

Here to instructions: https://github.com/phalcon/cphalcon

Please write us if you have any feedback.

Thanks.

To-Do
----
See CHANGELOG.md

Changelog
----
See CHANGELOG.md


NOTE
----

Required version: >= 1.0.0

Get Started
-----------

#### Requirements

To run this application on your machine, you need at least:

* >= PHP 5.3.9
* NGINX or Apache Web Server with mod rewrite enabled
* Phalcon framework (>= 1.3.0 or >= 2.0)

Then you'll need to create the database and initialize schema:

    echo 'CREATE DATABASE link' | mysql -u root
    cat Schema/link.sql | mysql -u root link
