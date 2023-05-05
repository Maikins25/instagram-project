<?php

/*************************************************************************************************
 * library.php
 *
 * Common environment settings and functions used througout the Hanover DPW Park Permitting
 * application.
 *************************************************************************************************/
session_start();
$user =  $_SESSION['userId'];
extract($_REQUEST);


/*
 * Returns the content to be included based on the 'content' request parameter, if present.
 */
function get_content()
{
    global $content;

    if (!isset($content))
    {
        $content = 'list';
    }

    $content = 'insta' . ucfirst(strtolower($content));

    return $content;
}

/*
 * Returns a connection to the underlying MySQL database.
 */
function get_database_connection()
{
    $servername = 'localhost';
    // TODO: Don't use 'root', make a separate user for this database
    $username = 'root';
    $password = 'Password1234';
    $dbname = 'instagraham_database';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error)
    {
        die('Connection failed: ' . $conn->connect_error);
    }

    return $conn;
}







function send_verification_code($email)
{
    global $dbh;

    $to = $email; // Save original, unescaped email address
    $email = mysqli_real_escape_string($dbh, $email);

    // Generate a random 32-character verification hash code
    $verificationHash = hash('md5', uniqid($to, true));

    $url = get_server_name() . get_script_root() . 'index.php?content=verifyEmail&hash=' . $verificationHash;

    $sql = <<<SQL
    UPDATE user
       SET verification_hash = '{$verificationHash}',
           verification_expiration = DATE_ADD(NOW(), INTERVAL 1 HOUR)
     WHERE email = '{$email}'
SQL;

    // Update the user's record in the database
    if (mysqli_query($dbh, $sql))
    {
        // Now send the email with the link
        $subject = 'Pi Day Challenge Email Verification';
        $message = 'Thank you for participating in the Pi Day Challenge!<br />' .
                   'Click this link to verify your email address:<br />' .
                   '<a href="' . $url . '">' . $url . '</a><br />' .
                   'The link expires in one hour.';
        send_email($to, $subject, $message);
    }
}





function send_email($recipient, $subject, $message)
{
    global $config;

    $mail = new PHPMailer();

    try
    {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->isSMTP();

        // $mail->SMTPDebug = 0;
        // $mail->Debugoutput = 'html';

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->AuthType = 'XOAUTH2';

        $email = $config['google']['email'];
        $name = $config['google']['name'];
        $clientId = $config['google']['client_id'];
        $clientSecret = $config['google']['client_secret'];
        $refreshToken = $config['google']['refresh_token'];

        $provider = new Google(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
            ]
        );

        $mail->setOAuth(
            new OAuth(
                [
                    'provider' => $provider,
                    'clientId' => $clientId,
                    'clientSecret' => $clientSecret,
                    'refreshToken' => $refreshToken,
                    'userName' => $email,
                ]
            )
        );

        $mail->setFrom($email, $name);
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->CharSet = PHPMailer::CHARSET_UTF8;
        $mail->msgHTML($message);

        $mail->send();
    }
    catch (Exception $e)
    {
        // Ignore the error, the recipient's email address is likely invalid
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    catch (\Exception $e)
    {
        // For development debugging
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}



/*
 * Returns the absolute path for the given relative path.
 */
function get_absolute_path($relativePath)
{
    return substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/')) . '/' . $relativePath;
}