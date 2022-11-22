Web app using Laravel 9 & Vue 3

For feeding: 
php artisan feed:temperature

for cron job

`* * * * * ` php /path/to/artisan schedule:run 1>> /dev/null 2>&1

 OR

`* * * * * ` cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
