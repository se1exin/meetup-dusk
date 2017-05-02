<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdvancedTest extends DuskTestCase
{
    private $demoPause = 0;
    /**
     * Test that the registration page loads
     *
     * @return void
     */
    public function testRegisterPageLoads()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->assertSee('Register Today');
        });
    }

    /**
     * Test that the payment page is not accessible to an unregistered user
     *
     * @return void
     */
    public function testAuthenticatedCannotAccessPayment()
    {
        $this->browse(function ($browser) {
            $browser
                ->visit('/payment')

                // Wait for redirect
                ->pause(500)
                ->assertPathIs('/register')
                // Also check the page rendered correctly
                ->assertSee('Register Today');
        });
    }

    /**
     * Test that the registration page loads
     *
     * @return void
     */
    public function testRegisterClubSucceeds()
    {
        $this->browse(function ($browser) {
            $browser
                ->visit('/register')
                ->pause(2000) // Wait for the AJAX csrf token
                ->value('#first-name', 'Dusk')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#last-name', 'Test')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#address-street', 'Street Address')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#address-city', 'City')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#address-postcode', '123') // <--- TEST SHOULD FAIL

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#address-state', 'NSW')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#email', uniqid() . '@test.com')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#phone', '123456789')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#password', '123456')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->value('#confirm-password', '123456')

                ->pause($this->demoPause) // Pause for demonstration purposes
                ->click('button[type=submit]')

                ->pause(5000) // Wait for the rego to complete
                ->assertPathIs('/payment')

                // Also check the page rendered correctly
                ->assertSee('Payment');
        });
    }


    /**
     * Test that payment with stripe is successful
     *
     * @return void
     */
    public function testStripePaymentSucceeds()
    {
        // Note: As we are using a real browser, our session will
        // have persisted from the last test (if it passed)
        $this->browse(function ($browser) {
            $browser
                ->visit('/payment')
                ->value('#full-name', 'Unit User')
                ->value('#card-number', '4242424242424242')
                ->value('#expiry-date', '12/19')
                ->value('#cvc', '123')
                ->click('#agreement-label')
                ->click('button[type=submit]')
                ->pause(20000) // Wait for stripe to process the payment
                ->assertPathIs('/payment-success')
                // Also check the page rendered correctly
                ->assertSee('Your subscription has been activated.');
        });
    }

    /**
     * Test that the payment page is not accessible to an already paid user
     *  and that they are taken to the confirmation page
     *
     * @return void
     */
    public function testPaidCannotAccessPayment()
    {
        // Note: As we are using a real browser, our session will
        // have persisted from the last test (if it passed)
        $this->browse(function ($browser) {
            $browser
                ->visit('/payment')

                // Wait for redirect
                ->pause(500)
                ->assertPathIs('/payment-success')
                // Also check the page rendered correctly
                ->assertSee('Your subscription has been activated.');
        });
    }

}
