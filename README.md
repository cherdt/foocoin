# FooCoin - a deliberately insecure web app

FooCoin is for teaching and learning purposes only. It includes a number if vulnerabilities. It should not be exposed to the internet.

Large portions of this are borrowed from the SQLite-PHP tutorial at http://www.sqlitetutorial.net/sqlite-php/

## Running FooCoin

### Docker

If you have Docker installed, this is the easiest way:

    docker build --tag foocoin .
    docker run -it -p 8000:8000 --rm foocoin

Then visit http://localhost:8000 in your favorite web browser.

### Running on Linux (Debian flavors)

In this directory (i.e. the same directory as the README.md file on your locally-cloned repo):
 
Make sure you have the dependencies installed:

    apt install php7.3-sqlite3

Install Composer. I followed the steps at https://getcomposer.org/download/

Set up the project with Composer:

    php composer.phar update
    php composer.phar dump-autoload -o

Run PHP's built-in web server:

    php -S localhost:8000

Visit http://localhost:8000/init.php to initialize the SQLite database.

Then visit http://localhost:8000 in your favorite web browser.
