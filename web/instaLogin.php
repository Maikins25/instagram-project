<?php

/*************************************************************************************************
 * login.php
 *
 * Copyright 2017-2022
 *
 * Login page content. This page is intended to be included in index.php.
 *************************************************************************************************/

?>

<div class="jumbotron col-md-8 col-md-offset-2">
    <h2>Welcome to Instagraham</h2>

    <p>
      Login to instagraham to see what your friends are up to!
    </p>

<?php

/*
    <div style="text-align: center;">
        <h1 style="font-family: Courier;" id="countdown"></h1>
    </div>

    <script>
	// This countdown script was taken from https://www.w3schools.com/howto/howto_js_countdown.asp

	// Set the date we're counting down to (need to adjust for Eastern time)
	var countDownDate = new Date("Mar 14, 2022 6:00:00").getTime();

	// Update the count down every 1 second
	var x = setInterval(function() {

	  // Get today's date and time
	  var now = new Date().getTime();

	  // Find the distance between now an the count down date
	  var distance = countDownDate - now;

	  // Time calculations for days, hours, minutes and seconds
	  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	  // Display the result in the element with id="demo"
	  $("#countdown").text(("00" + days).slice (-2) + ":" +
	                       ("00" + hours).slice (-2) + ":" +
						   ("00" + minutes).slice (-2) + ":" +
						   ("00" + seconds).slice (-2));

	  // If the count down is finished, write some text
	  if (distance < 0) {
	    clearInterval(x);
	    $("#countdown").text("It's here!");
	  }
  	}, 500);
	</script>
*/

?>

    <form class="form-horizontal" action="authenticate.php">
        <div class="col-xs-12" style="height:20px;"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="email">&nbsp;</label>
            <div class="col-sm-9 text-center">
                <div class="g-signin2" data-theme="dark" data-width="300" data-longtitle="true" data-onsuccess="loginGoogleSso">
            </div>
        </div>


        <div class="col-xs-12" style="height:20px;"></div>
        <div class="form-group">
            <label class="col-sm-3 control-label" for="email">Email:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="email" name="email" placeholder="Email" autofocus />
            </div>
        </div>


        <div class="form-group">
            <label class="col-sm-3 control-label" for="password">Password:</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
            </div>
        </div>


        <div class="container col-md-6 col-md-offset-3">
            <input type="submit" id="loginButton" class="btn btn-primary btn-block" value="Log In" onclick="login()" />
            <!-- <a class="btn btn-link btn-block" href="index.php?content=passwordRecovery">Forgot your password?</a> -->
        </div>


        <div class="col-xs-12" style="height:10px;"></div>
        <div class="container col-md-6 col-md-offset-3">
            Don't have an account? <a class="btn btn-link" href="index.php?content=register" role="button">Sign Up</a>
        </div>

        <div class="col-xs-12" style="height:10px;"></div>
        <div class="container col-md-9 col-md-offset-5">
            <a class="btn btn-link" href="privacy-policy.pdf" role="button">Privacy Policy</a>
        </div>

    </form>
</div>

<script>









// function login() {
//     if ($('#email').val() == '') {
//         showAlert('danger', 'Email Required!', 'Enter your email address and try again.');
//     } else if ($('#password').val() == '') {
//         showAlert('danger', 'Password Required!', 'Enter your password and try again.');
//     } else {
//         var settings = {
//             'async': true,
//             'url': 'api/authenticate.php?email=' + $('#email').val() + '&password=' + $('#password').val(),
//             'method': 'POST',
//             'headers': {
//                 'Cache-Control': 'no-cache'
//             }
//         };

//         $('#loginButton').prop('disabled', true);

//         $.ajax(settings).done(function(response) {
//             window.location.replace('index.php?content=menu');
//         }).fail(function() {
//             showAlert('danger', 'Invalid Login!', 'Check your email address and password and try again.');
//         }).always(function() {
//             $('#loginButton').prop('disabled', false);
//         });
//     }
// }



</script>