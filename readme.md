# usage
1. git clone https://github.com/sh-ogawa/ec2-getClientIpIssue.git
2. cd "clone directory"
3. composer install
4. php artisan key:generate
5. php artisan serve

# issue code
written in "app/Providers/AppServiceProvider.php"

# execution issue code
you access localhost:8000 on web browser.

# output execution logs
storage/logs/laravel.log

# Notes
this issue don't reproduce on local pc.
(Even if TCP tunneling is done using ngrok, it will not be reproduced.)

running this application on ec2 and cloud front.