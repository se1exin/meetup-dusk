<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class RegisterController extends Controller
{

    /**
     * Function register() - Handles both GET and POST requests to /register.
     *  - GET will simply return the register view
     *  - POST will attempt to create a new User, and redirect to Payment if successful
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function register(Request $request)
    {
        // Bag of all user form input values. Will always be passed to the template
        $input_bag = [
            'first_name' => '',
            'last_name' => '',
            'address_street' => '',
            'address_city' => '',
            'address_postcode' => '',
            'address_state' => '',
            'email' => '',
            'phone' => '',
            'password' => '',
            'confirm_password' => '',
        ];

        // Bag of all error messages. Will always be passed to the template
        $error_bag = [
            'success' => true,
            'error' => '<span class="txt-blue">Whoops! We had trouble saving some of your information. <br>Please update the fields indicated below to finish registering.</span>', // Generic Error Message. Will be shown if 'success' is false
            'first_name_error' => '',
            'last_name_error' => '',
            'address_street' => '',
            'address_city_error' => '',
            'address_postcode_error' => '',
            'address_state_error' => '',
            'email_error' => '',
            'phone_error' => '',
            'password_error' => '',
            'confirm_password_error' => '',
        ];

        // User is attempting to Register
        if ($request->isMethod('post')) {
            try {
                $input_bag['first_name'] = trim($request->input('first_name'));
                $input_bag['last_name'] = trim($request->input('last_name'));
                $input_bag['address_street'] = trim($request->input('address_street'));
                $input_bag['address_city'] = trim($request->input('address_city'));
                $input_bag['address_postcode'] = trim($request->input('address_postcode'));
                $input_bag['address_state'] = trim($request->input('address_state'));
                $input_bag['email'] = strtolower(trim($request->input('email')));
                $input_bag['phone'] = trim($request->input('phone'));
                // Intentionally not trimming passwords. Spaces are a legit character
                $input_bag['password'] = $request->input('password');
                $input_bag['confirm_password'] = $request->input('confirm_password');

                // Validate Inputs
                if ($input_bag['first_name'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['first_name_error'] = 'First Name is required';
                }
                if ($input_bag['last_name'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['last_name_error'] = 'Last Name is required';
                }
                if ($input_bag['address_street'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['address_street'] = 'Street Address is required';
                }
                if ($input_bag['address_city'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['address_city_error'] = 'City is required';
                }
                if ($input_bag['address_postcode'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['address_postcode_error'] = 'Postcode is required';
                } elseif (strlen($input_bag['address_postcode']) !== 4 ||
                    !is_numeric($input_bag['address_postcode'])) {
                    // Postcodes MUST for 4 digits (Australian postcodes)
                    $error_bag['success'] = false;
                    $error_bag['address_postcode_error'] = 'Postcode is not a 4 digit number';
                }
                if ($input_bag['address_state'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['address_state_error'] = 'State is required';
                }
                if ($input_bag['email'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['email_error'] = 'Email is required';
                } elseif (!filter_var($input_bag['email'], FILTER_VALIDATE_EMAIL)) {
                    // Email needs to be in valid format
                    $error_bag['success'] = false;
                    $error_bag['email_error'] = 'Email address is not in a valid format';
                } elseif (User::where('email', $input_bag['email'])->count() !== 0) {
                    // Email address must be unique
                    $error_bag['success'] = false;
                    $error_bag['email_error'] = 'This Email address is already registered. '
                        .'Do you want to <a class="txt-blue" href="/login">Login instead?</a>';
                }
                if ($input_bag['phone'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['phone_error'] = 'Contact Phone is required';
                }
                if ($input_bag['password'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['password_error'] = 'Password is required';
                } elseif (strlen($input_bag['password']) < 6) {
                    // Password must be min 6 chars
                    $error_bag['success'] = false;
                    $error_bag['password_error'] = 'Password must contain at least 6 characters';
                }
                if ($input_bag['confirm_password'] === '') {
                    $error_bag['success'] = false;
                    $error_bag['confirm_password_error'] = 'Password Confirmation is required';
                } elseif ($input_bag['password'] !== $input_bag['confirm_password']) {
                    // Passwords must match
                    // Note: The password confirmation value will NOT be passed back to client
                    $error_bag['success'] = false;
                    $error_bag['password_error'] = 'Password confirmation failed';
                    $error_bag['confirm_password_error'] = 'Please confirm your password again';
                }

                if ($error_bag['success']) {
                    // We successfully passed validation. Create the user, log them in, and take them to payment

                    /* @TODO: Implement User Creation, Auto Authentication, and Payment Redirect */
                    $user = new User();
                    $user->first_name = $input_bag['first_name'];
                    $user->last_name = $input_bag['last_name'];
                    $user->phone = $input_bag['phone'];
                    $user->email = $input_bag['email'];
                    $user->password = bcrypt($input_bag['password']);

                    $user->address_street = $input_bag['address_street'];
                    $user->address_city = $input_bag['address_city'];
                    $user->address_postcode = $input_bag['address_postcode'];
                    $user->address_state = $input_bag['address_state'];

                    $user->save();

                    // User Created! Now make them automatically logged in.
                    Auth::login($user);

                    if ($request->input('ajax')) { // The client will handle the redirect
                        return response()->json($error_bag);
                    } else {
                        return redirect('/payment');
                    }
                }
            } catch (Exception $ex) {
                // Server error handing
                $error_bag['success'] = false;
                $error_bag['error'] = 'Whoops! Something went wrong. <br>The mix up has been automatically reported, '
                    . 'please refresh the page and try again.';
            }

            if ($request->input('ajax')) {
                // AJAX Submissions are handled by the client, just give them the results
                return response()->json($error_bag);
            }
        }

        return view('advanced.register', compact('input_bag', 'error_bag'));
    }

    /**
     * function payment() - Handles both GET and POST requests to /payment.
     *  - GET will simply return the payment view if the user is pending payment.
     *    Otherwise they will be redirected to /register
     *  - POST will attempt to charge the provided Stripe card and finish the User's registration if successful
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payment(Request $request)
    {
        // Check if the user is an authenticated user
        // @TODO: Check if they have already paid.. dont want to double charge the poor sucker
        $user = Auth::user();

        // Bag of all user form input values. Will always be passed to the template
        $input_bag = [];

        // Bag of all error messages. Will always be passed to the template
        $error_bag = [
            'success' => true,
        ];

        if (!$user) { // User can't pay yet, send them to register
            return redirect('/register');
        }

        // User is attempting to Pay
        if ($request->isMethod('post')) {
            // The request MUST be via ajax as the client must complete the entire registration
            // in one page load, otherwise they will loose their CC info etc.
            if (!$request->input('ajax')) {
                $error_bag = [
                    'success' => false,
                    'error' => 'You must enable JavaScript to complete payment.<br><br>See '
                        .'<a href="http://enable-javascript.com/" target="_blank">http://enable-javascript.com/</a> '
                        . 'for more info.',
                ];
            } else {
                // @TODO: Validate stripe_id input - a normal user cant even get this far without it though..
                $input_bag['stripe_id'] = trim($request->input('stripe_id'));
                $input_bag['card_brand'] = trim($request->input('card_brand'));
                $input_bag['card_last_four'] = trim($request->input('card_last_four'));

                // Attempt to sign the user up to the subscription. If an error occurs, handle it accordingly.
                try {
                    // Try to subscribe the user.
                    $user->newSubscription('main', 'meetup_dusk')->create($input_bag['stripe_id']);
                } catch (Error\Card $ex) {
                    // Error with the card...
                    // Get the error and return it to payment.js for
                    // client side error processing.
                    $error_bag['success'] = false;
                    $error_bag['error'] = $ex->stripeCode;
                    $error_bag['message'] = $ex->jsonBody['error']['message'];
                    $error_bag['generic'] = false;
                } catch (Error $ex) {
                    // Generic stripe error. Give generic error message
                    $error_bag['success'] = false;
                    $error_bag['generic'] = true;
                }
                return response()->json($error_bag);
            }
        }

        if ($user->subscription) {
            // User has already paid, redirect them to payment success screen
            return redirect('/payment-success');
        }

        return view('advanced.payment', compact('input_bag', 'error_bag'));
    }

    public function paymentSuccess()
    {
        $user = Auth::user();

        // User can't pay yet, redirect to register
        if (!$user) {
            return redirect('/register');
        } elseif (!$user->subscription) {
            // User hasn't successfully paid with Stripe yet, redirect to payment
            return redirect('/payment');
        }

        return view('advanced.payment-success', compact('user'));
    }

    /**
     * function csrfToken()
     *  - Generates and returns the user's CSRF token. This is to allow all the HTML to be heavily cached
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function csrfToken()
    {
        return response()->json(array('_' => csrf_token()));
    }

}
