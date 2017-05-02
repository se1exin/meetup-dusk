<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SimpleTest extends DuskTestCase
{
    /**
     * Test that an unauthenticated user is given the Login page
     *
     * @return void
     */
    public function testUnauthenticatedSeesLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Login');
        });
    }

    /**
     * Test that an incorrect email/password combination is denied
     *
     * @return void
     */
    public function testUnauthenticatedIncorrectEmailPassword()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                // Fill out the login form
                ->type('email', 'test@test.com')
                ->type('password', 'incorrectpassword')
                // Submit the form
                ->click('input[type=submit]')
                // Wait for login
                ->pause(1000)
                // Did we get the error message due to incorrect password?
                ->assertSee('Incorrect Username/Password!');
        });
    }

    /**
     * Test that an unauthenticated user can login
     * Note: Should FAIL due to incorrect password
     *
     * @return void
     */
    public function testUnauthenticatedCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')

                // Fill out the login form
                ->type('email', 'test@test.com')
                ->type('password', 'incorrectpassword')

                // Submit the form
                ->click('input[type=submit]')

                // Wait for login and redirect to '/dashboard'
                ->pause(1000)

                // Did we actually get to the dashboard?
                ->assertPathIs('/dashboard')

                // We can go even further and check the page rendered correctly
                ->assertSee('You are logged in!!');
        });
    }

    /**
     * Test that an authenticated user is taken to the dashboard
     *
     * @return void
     */
    public function testAuthenticatedRedirectsToDashboard()
    {
        $this->browse(function (Browser $browser) {
            // Note: As we are using a real browser, our logged-in session will
            // have persisted from the last test (if it passed)
            $browser->visit('/')

                // Wait for the redirect to '/dashboard'
                ->pause(1000)

                // Did we actually get to the dashboard?
                ->assertPathIs('/dashboard')

                // We can go even further and check the page rendered correctly
                ->assertSee('You are logged in!!');
        });
    }

    /**
     * Test that an authenticated user can logout
     *
     * @return void
     */
    public function testAuthenticatedCanLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboard')

                // Click the logout link
                ->click('a.logout')

                // Wait for logout and redirect to '/'
                ->pause(1000)

                // Did we actually get to the dashboard?
                ->assertPathIs('/')

                // We can go even further and check the page rendered correctly
                ->assertSee('Login');
        });
    }
}
