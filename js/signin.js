$(document).ready(
    () => {
        $('#signin-form').on('submit', (event) => {
            //we want to cancel to not refresh the page
            event.preventDefault();
            //create a spinner image
            //const spinner = `<img class="spinner" src="images/spinner.gif">`;
            //$('button[name="btn-signin"]').append(spinner);
            //get the data from the form
            //email field
            let eml = $('#email').val();
            //password field
            let pwd = $('#password').val();
            //create a data object
            let signindata = { email: eml, password: pwd };
            //send the data via ajax request to handle: /ajax/signin.ajax.php
            $.ajax({
                url: '/ajax/signin.ajax.php',
                method: 'POST',
                dataType: 'json',
                data: signindata
            }).done((response) => {
                //$('.spinner').remove();
                $('div[name="alert"]').remove();
                $('button[name="alert"]').remove();

                if (response.success == true) {
                    //signin is sucessful 
                    console.log('signin success');
                    window.location.href = '/index.php';
                }
                else {
                    const warningMessage = `<div name="alert" class=\"alert alert-warning alert-dismissable fade show\">` +
                        response.error +
                        `<button name="alert" class=\" close\" type=\"button\" data-dismiss=\"alert\">
                                                    &times;
                                                </button>
                                            </div>`;
                    $('#signin-form').append(warningMessage);
                    //signin failed
                    console.log('signin failed');
                }

            });
        });
    }
);
