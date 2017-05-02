// RETRIEVE THE CSRF TOKEN - Used by scripts with forms
var csrfToken = ''; // This will be updated via AJAX once the page has loaded
var csrfRequest = new XMLHttpRequest();
csrfRequest.addEventListener("load", function() {
    var result = JSON.parse(this.responseText);
    csrfToken = result._;
});
csrfRequest.open("GET", "/token");
csrfRequest.send();


// Validate a required field
function validateRequiredField(field) {
    var parent = field.parentElement;
    var message = '';
    if(field.value.trim() == '') {
        message = 'This field is required';
    } else if(field.getAttribute('type') == 'email' && !validateEmail(field.value)) {
        message = 'Email address not in valid format'
    }
    if(message != '') {
        parent.classList.add('error');
        parent.querySelector('.helper').innerText = message;
    } else {
        parent.classList.remove('error');
    }
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// See http://stackoverflow.com/questions/17733076/smooth-scroll-anchor-links-without-jquery
function scrollTo(element, to, duration) {
    if (duration <= 0) return;
    var difference = to - element.scrollTop;
    var perTick = difference / duration * 10;

    setTimeout(function() {
        element.scrollTop = element.scrollTop + perTick;
        if (element.scrollTop === to) return;
        scrollTo(element, to, duration - 10);
    }, 10);
}


// AJAX Form Handling
(function() {
    var acceptedCards = ['visa', 'mastercard', 'amex'];
    var form = document.getElementById("payment-form");
    var agreement = form.querySelector('#agreement');
    var agreementSvg = form.querySelector('#agreementSvg');
    var submit = form.querySelector('.form-submit');
    var inactiveText = submit.querySelector('.text.inactive');
    var activeText = submit.querySelector('.text.active');
    var loading = submit.querySelector('.loading');

    var stripeIdField = form.querySelector('#stripe_id');
    var cardBrandField = form.querySelector('#card_brand');
    var cardLastFourField = form.querySelector('#card_last_four');

    var errorMsg = form.querySelector('.error-message');
    form.addEventListener("submit", formSubmit);

    var cardNumberField = form.querySelector('#card-number');
    var expiryField = form.querySelector('#expiry-date');
    var cvcField = form.querySelector('#cvc');
    cardNumberField.addEventListener('blur', function(){validateCreditCardNumber(this)});
    cardNumberField.addEventListener('keyup', function(){validateCreditCardNumber(this)});
    expiryField.addEventListener('blur', function(){validateExpiryDate(this)});
    expiryField.addEventListener('keyup', function(){validateExpiryDate(this)});
    cvcField.addEventListener('blur', function(){validateCVC(this)});
    cvcField.addEventListener('keyup', function(){validateCVC(this)});

    // Setup Payform bindings
    payform.cardNumberInput(cardNumberField);
    payform.expiryInput(expiryField);
    payform.cvcInput(cvcField);

    // Agreement checkbox handler
    agreement.addEventListener('change', function(){
        if(this.checked) {
            submit.disabled = false
        } else {
            submit.disabled = true
        }
    });

    // Agreement SVG checkbox handler
    agreementSvg.addEventListener('click', function(){
        if(agreement.checked) {
            submit.disabled = true;
            agreement.checked = false;
        } else {
            submit.disabled = false;
            agreement.checked = true;
        }
    });

    // Make note of the origin button text strings - they might change in the submit handlers
    var inactiveTextDefault = inactiveText.innerHTML;
    var activeTextDefault = activeText.innerHTML;

    function formSubmit(e) {
        if(e !== undefined) e.preventDefault();

        if(!agreement.checked) {
            // The user must manually agree to the terms
            return false;
        }

        // If there was an error showing, hide it because the form has been resubmitted
        if (errorMsg.innerHTML != '') {
            errorMsg.innerHTML = '';
            errorMsg.classList.remove('show');
        }

        // First validate all inputs
        var formRequiredInputs = form.querySelectorAll('input.required, textarea.required');
        errorMsg.classList.remove('show');

        // First validate required fields
        for(var i=0; i<formRequiredInputs.length; i++) {
            validateRequiredField(formRequiredInputs[i]);
        }

        if(!form.querySelectorAll('.error').length) { // All Fields are Valid
            submit.classList.add('sending');
            loading.classList.add('show');

            submit.disabled = true;
            // Next check that a Card has successfully been submitted to stripe
            if(!stripeIdField.value) { // No card token received, we need to send the added card data to Stripe
                var expiryParsed = payform.parseCardExpiry(expiryField.value)
                Stripe.card.createToken({
                    number: cardNumberField.value,
                    cvc: cvcField.value,
                    exp_month: expiryParsed.month,
                    exp_year: expiryParsed.year
                }, stripeResponseHandler);
            } else { // We have a card token, send it all to the frontend for further validation
                var data = {
                    'stripe_id': stripeIdField.value,
                    'card_brand': cardBrandField.value,
                    'card_last_four': cardLastFourField.value,
                    '_token': csrfToken,
                    'ajax': true
                };

                var request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        if (request.status == 200) {
                            var response = JSON.parse(request.response);
                            if (response.success) {
                                activeText.innerHTML = "Success!";
                                loading.classList.remove('show');
                                window.location = "payment-success";
                            } else if (!response.success && !response.generic) {
                                if (response.error == "cvc_check" || response.error == "incorrect_cvc" || response.error == "incorrect_cvc") {
                                    cvcField.parentElement.classList.add('error');
                                    cvcField.parentElement.querySelector('.helper').innerText = response.message;
                                    loading.classList.remove('show');
                                    submit.disabled = false;
                                    submit.classList.remove('sending');

                                    var data = {
                                        'stripe_id': '',
                                        'card_brand': '',
                                        'card_last_four': '',
                                        '_token': '',
                                        'ajax': true
                                    };

                                    stripeIdField.value = '';
                                    cardBrandField.value = '';
                                    cardLastFourField.value = '';
                                    csrfToken.value = '';
                                } else if (response.error == "expired_card") {
                                    expiryField.parentElement.classList.add('error');
                                    expiryField.parentElement.querySelector('.helper').innerText = response.message;
                                    loading.classList.remove('show');
                                    submit.disabled = false;
                                    submit.classList.remove('sending');

                                    var data = {
                                        'stripe_id': '',
                                        'card_brand': '',
                                        'card_last_four': '',
                                        '_token': '',
                                        'ajax': true
                                    };

                                    stripeIdField.value = '';
                                    cardBrandField.value = '';
                                    cardLastFourField.value = '';
                                    csrfToken.value = '';
                                } else if (response.error == "card_declined" || response.error == "processing_error") {
                                    // Display a more prominent error to the user
                                    inactiveText.innerHTML = "Whoops!";
                                    loading.classList.remove('show');
                                    submit.disabled = false;
                                    submit.classList.remove('sending');
                                    submit.classList.remove('disabled');

                                    errorMsg.innerHTML = response.message;
                                    errorMsg.classList.add('show');

                                    var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
                                    scrollTo(document.querySelector('html'), offset, 300);
                                    scrollTo(document.body, offset, 300);

                                    var data = {
                                        'stripe_id': '',
                                        'card_brand': '',
                                        'card_last_four': '',
                                        '_token': '',
                                        'ajax': true
                                    };

                                    stripeIdField.value = '';
                                    cardBrandField.value = '';
                                    cardLastFourField.value = '';
                                    csrfToken.value = '';
                                }
                            } else {
                                // Failed for some reason
                                inactiveText.innerHTML = "Whoops!";
                                loading.classList.remove('show');
                                submit.disabled = false;
                                submit.classList.remove('sending');
                                submit.classList.remove('disabled');

                                errorMsg.innerHTML = response.error;
                                errorMsg.classList.add('show');

                                var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
                                scrollTo(document.querySelector('html'), offset, 300);
                                scrollTo(document.body, offset, 300);

                                var data = {
                                    'stripe_id': '',
                                    'card_brand': '',
                                    'card_last_four': '',
                                    '_token': '',
                                    'ajax': true
                                };

                                stripeIdField.value = '';
                                cardBrandField.value = '';
                                cardLastFourField.value = '';
                                csrfToken.value = '';
                            }
                        } else if (request.status !== 200) {
                            inactiveText.innerHTML = "Whoops!";
                            loading.classList.remove('show');
                            submit.disabled = false;
                            submit.classList.remove('sending');;

                            errorMsg.innerHTML = 'Whoops! Something went wrong! The mix up has been automatically reported, please refresh the page and try again.';
                            errorMsg.classList.add('show');

                            var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
                            scrollTo(document.querySelector('html'), offset, 300);
                            scrollTo(document.body, offset, 300);
                        }
                    }
                }
                var value = JSON.stringify(data);
                request.open('POST', '/payment', true);
                request.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
                request.send(value);
            }
        }

        return false;
    }

    function stripeResponseHandler(status, response) {
        if (response.error) { // Problem!
            // Handle specific error types
            if (response.error.code == 'incorrect_number') {
                cardNumberField.parentElement.classList.add('error');
                cardNumberField.parentElement.querySelector('.helper').innerText = response.error.message;
            } else {
                // Unknown/generic error
                errorMsg.innerHTML = response.error.message;
                errorMsg.classList.add('show');
            }

            loading.classList.remove('show');
            submit.disabled = false;
            submit.classList.remove('sending');
            submit.classList.remove('disabled');

            var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
            scrollTo(document.querySelector('html'), offset, 300);
            scrollTo(document.body, offset, 300);
        } else { // Token was created!
            stripeIdField.value = response.id;
            cardBrandField.value = response.card.brand;
            cardLastFourField.value = response.card.last4;

            // Retry the form submission function
            formSubmit();
        }
    }

    function validateCreditCardNumber() {
        var parent = cardNumberField.parentElement;
        for(var i in acceptedCards) {
            // Wipe the cards, we be re-added if still valid
            parent.classList.remove(acceptedCards[i]);
        }
        if(cardNumberField.value.trim() !== '') {
            // Test the card type is accepted
            var cardType = payform.parseCardType(cardNumberField.value);

            if(cardType == null) { // Card completely invalid
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Credit Card number not valid';
            } else if(acceptedCards.indexOf(cardType) == -1) {
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Sorry, only accept VISA, MasterCard, and American Express are accepted';
            } else {
                parent.classList.add(cardType);
                parent.classList.remove('error');
            }
        }
    }

    function validateExpiryDate() {
        var parent = expiryField.parentElement;

        // Get the month and year values from the input
        var expiryParsed = payform.parseCardExpiry(expiryField.value)

        parent.classList.remove('error');
        // Validate the expiry, if invalid figure out why
        if(!payform.validateCardExpiry(expiryParsed.month, expiryParsed.year)) {
            // Hmm, not valid, find out why
            if(!isNaN(expiryParsed.month) || !isNaN(expiryParsed.year)) {
                // If both the month and expiry are valid number, but payform stil thinks it's
                // invalid, then the date provide must be in the past
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Invalid expiry date';
            }
        }
    }
    function validateCVC() {
        var parent = cvcField.parentElement;

        parent.classList.remove('error');

        // Validate the expiry, if invalid figure out why
        if(cvcField.value.trim() !== '' && !payform.validateCardCVC(cvcField.value)) {
            parent.classList.add('error');
            parent.querySelector('.helper').innerText = 'Security Code Invalid';
        }
    }
})();
