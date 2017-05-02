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
    var form = document.getElementById("register-form");
    var submit = form.querySelector('.form-submit');
    var text = submit.querySelector('.text');
    var loading = submit.querySelector('.loading');

    var errorMsg = form.querySelector('.error-message');
    form.addEventListener("submit", formSubmit);

    // Custom field validators
    var addressPostcodeField = form.querySelector('#address-postcode'),
        passwordField = form.querySelector('#password'),
        passwordConfirmField = form.querySelector('#confirm-password');

    addressPostcodeField.addEventListener('blur', function(){validatePostcode(this)});
    passwordField.addEventListener('blur', function(){validatePassword(this)});
    passwordConfirmField.addEventListener('blur', function(){validatePasswordConfirm(this)});
    passwordConfirmField.addEventListener('keyup', function(){validatePasswordConfirm(this)});

    function formSubmit(e) {
        if(e !== undefined) e.preventDefault();
        
        var firstNameField = form.querySelector('#first-name');
        var lastNameField = form.querySelector('#last-name');
        var addressStreetField = form.querySelector('#address-street');
        var addressCityField = form.querySelector('#address-city');
        var addressStateField = form.querySelector('#address-state');
        var emailField = form.querySelector('#email');
        var phoneField = form.querySelector('#phone');

        // First validate all inputs
        var formRequiredInputs = form.querySelectorAll('input.required, textarea.required');
        errorMsg.classList.remove('show');

        // First validate required fields
        for(var i=0; i<formRequiredInputs.length; i++) {
            validateRequiredField(formRequiredInputs[i]);
        }

        // Validate custom fields
        validatePostcode();
        validatePassword();
        validatePasswordConfirm();

        if(!form.querySelectorAll('.error').length) { // All Fields are Valid
            text.innerHTML = "Registering...";
            submit.classList.add('sending');
            loading.classList.add('show');
            submit.disabled = true;

            var data = {
                'first_name': firstNameField.value,
                'last_name': lastNameField.value,
                'address_street': addressStreetField.value,
                'address_city': addressCityField.value,
                'address_postcode': addressPostcodeField.value,
                'address_state': addressStateField.value,
                'email': emailField.value,
                'phone': phoneField.value,
                'password': passwordField.value,
                'confirm_password': passwordConfirmField.value,
                '_token': csrfToken,
                'ajax': true
            };

            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == XMLHttpRequest.DONE) {
                    if (request.status == 200) {
                        var response = JSON.parse(request.response);
                        if(response.success) {
                            text.innerHTML = "Success...";
                            loading.classList.remove('show');
                            // Redirect the user to the payment page
                            window.location = '/payment';
                        } else {
                            // Failed for some reason
                            text.innerHTML = "Whoops!";
                            loading.classList.remove('show');
                            submit.disabled = false;
                            submit.classList.remove('sending');
                            submit.classList.remove('disabled');

                            errorMsg.innerHTML = response.error;
                            errorMsg.classList.add('show');

                            // Check for field specific errors
                            if(response.first_name_error !== '') {
                                firstNameField.parentElement.classList.add('error');
                                firstNameField.parentElement.querySelector('.helper').innerHTML = response.first_name_error;
                            }
                            if(response.last_name_error !== '') {
                                lastNameField.parentElement.classList.add('error');
                                lastNameField.parentElement.querySelector('.helper').innerHTML = response.last_name_error;
                            }
                            if(response.address_street !== '') {
                                addressStreetField.parentElement.classList.add('error');
                                addressStreetField.parentElement.querySelector('.helper').innerHTML = response.address_street;
                            }
                            if(response.address_city_error !== '') {
                                addressCityField.parentElement.classList.add('error');
                                addressCityField.parentElement.querySelector('.helper').innerHTML = response.address_city_error;
                            }
                            if(response.address_postcode_error !== '') {
                                addressPostcodeField.parentElement.classList.add('error');
                                addressPostcodeField.parentElement.querySelector('.helper').innerHTML = response.address_postcode_error;
                            }
                            if(response.address_state_error !== '') {
                                addressStateField.parentElement.classList.add('error');
                                addressStateField.parentElement.querySelector('.helper').innerHTML = response.address_state_error;
                            }
                            if(response.email_error !== '') {
                                emailField.parentElement.classList.add('error');
                                emailField.parentElement.querySelector('.helper').innerHTML = response.email_error;
                            }
                            if(response.phone_error !== '') {
                                phoneField.parentElement.classList.add('error');
                                phoneField.parentElement.querySelector('.helper').innerHTML = response.phone_error;
                            }
                            if(response.password_error !== '') {
                                passwordField.parentElement.classList.add('error');
                                passwordField.parentElement.querySelector('.helper').innerHTML = response.password_error;
                            }
                            if(response.confirm_password_error !== '') {
                                passwordConfirmField.parentElement.classList.add('error');
                                passwordConfirmField.parentElement.querySelector('.helper').innerHTML = response.confirm_password_error;
                            }

                            setTimeout(function() {
                                text.innerHTML = "Register";
                            }, 3000);

                            var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
                            scrollTo(document.querySelector('html'), offset, 300);
                            scrollTo(document.body, offset, 300);
                        }
                    } else if (request.status !== 200) {
                        text.innerHTML = "Whoops!";
                        loading.classList.remove('show');
                        submit.disabled = false;
                        submit.classList.remove('sending');;

                        errorMsg.innerHTML = 'Whoops! Something went wrong! The mix up has been automatically reported, please refresh the page and try again.';
                        errorMsg.classList.add('show');

                        setTimeout(function() {
                            text.innerHTML = "Register";
                        }, 3000);

                        var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
                        scrollTo(document.querySelector('html'), offset, 300);
                        scrollTo(document.body, offset, 300);
                    }
                }
            }
            var value = JSON.stringify(data);
            request.open('POST', '/register', true);
            request.setRequestHeader('Content-Type', 'application/json; charset=utf-8');
            request.send(value);

        } else {
            // Validation failed. Move back to top of form, show message about fixing errors
            errorMsg.classList.add('show');
            errorMsg.innerHTML = '<span class="txt-blue">Whoops! We had trouble saving some of your information. <br>Please update the fields indicated below to finish registering.</span>';
            var offset = form.offsetTop - document.getElementById('banner').getBoundingClientRect().height;
            scrollTo(document.querySelector('html'), offset, 300);
            scrollTo(document.body, offset, 300);
        }

        return false;
    }

    function validatePostcode() {
        var parent = addressPostcodeField.parentElement;
        if(addressPostcodeField.value.trim() !== '') {
            if(addressPostcodeField.value.length !== 4 || isNaN(addressPostcodeField.value)) {
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Postcode is not a 4 digit number';
            } else {
                parent.classList.remove('error');
            }
        }
    }

    function validatePassword() {
        var parent = passwordField.parentElement;
        if(passwordField.value !== '') { // Intentionally not trimming password.
            if(passwordField.value.length < 6) {
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Password must contain at least 6 characters';
            } else {
                parent.classList.remove('error');
            }
        }
    }

    function validatePasswordConfirm() {
        var parent = passwordConfirmField.parentElement;
        if(passwordConfirmField.value !== '') { // Intentionally not trimming password.
            if(passwordField.value !== passwordConfirmField.value) {
                parent.classList.add('error');
                parent.querySelector('.helper').innerText = 'Password Confirmation does not match';
            } else {
                parent.classList.remove('error');
            }
        }
    }
})();