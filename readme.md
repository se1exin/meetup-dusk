 # Laravel Dusk Demonstration
 ## PHP Laravel Framework Sydney Meetup 2/5/17

 ### Note: The `master` branch contains tests that are **intentionally failing**. Switch to the `passing` branch to see the fixed tests.

 ## Install
 Create a database and setup your `.env` with the connection details
 ```bash
 $ composer install
 $ npm install
 $ npm run prod
 $ mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
 $ php artisan key:generate
 $ php artisan storage:link
 $ php artisan migrate
 $ php artisan db:seed --class=UsersTableSeeder
 ```

## Tests

To Dusk working in Homestead run `bash homestead-dusk-install.sh` to install everything

Keep in mind that Dusk uses the `.env` variable `APP_URL` to find your website. Make sure you update it to match the base URL to your development website.

Run `php artisan dusk` to execute the tests


## References

* Laravel Dusk Documentation: https://laravel.com/docs/5.4/dusk
* Dusk Assertions: https://laravel.com/docs/5.4/dusk#available-assertions