@echo off
php -d extension=pdo_sqlite -d extension=sqlite3 -d extension=zip "%~dp0artisan" %*
