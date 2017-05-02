 # Laravel Dusk Demonstration
 ## PHP Laravel Framework Sydney Meetup 2/5/17

[![CircleCI branch](https://img.shields.io/circleci/project/github/se1exin/meetup-dusk/passing.svg)]()

 ### Note: The `master` branch contains tests that are **intentionally failing**. Switch to the `passing` branch to see the fixed tests.

 ## Install
 Create a database and setup your `.env` with the connection details
 ```bash
 $ composer install
 $ npm install
 $ npm run prod
 $ mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
 $ cp .env.example .env
 $ php artisan key:generate
 $ php artisan storage:link
 $ php artisan migrate
 $ php artisan db:seed --class=UsersTableSeeder
 ```

To run the advanced test you require a Stripe account (its free) in at least test mode. You will also need to create a 'Plan' in stripe (under subscriptions) with the ID 'meetup_dusk'.

Add your Stripe test API keys in the `.env` variables `STRIPE_KEY` and `STRIPE_SECRET`


## Tests

To get Dusk working in Homestead run `bash homestead-dusk-install.sh` to install everything

Keep in mind that Dusk uses the `.env` variable `APP_URL` to find your website. Make sure you update it to match the base URL to your development website.

Run `php artisan dusk` to execute the tests


## References

* Laravel Dusk Documentation: https://laravel.com/docs/5.4/dusk
* Dusk Assertions: https://laravel.com/docs/5.4/dusk#available-assertions
* Laravel Cashier: https://laravel.com/docs/5.4/billing