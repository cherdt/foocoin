# FooCoin - a deliberately insecure web app

FooCoin is for teaching and learning purposes only. It includes a number if vulnerabilities. It should not be exposed to the internet.

Large portions of this are borrowed from the SQLite-PHP tutorial at http://www.sqlitetutorial.net/sqlite-php/

## Running FooCoin

First, make sure you have the dependencies installed:

TODO: determine dependencies
??? php sqlite3 what all else???

composer update
composer dump-autoload -o

In this directory, run PHP's built-in web server:

    php -S localhost:8000

Then visit http://localhost:8000 in your favorite web browser. 
