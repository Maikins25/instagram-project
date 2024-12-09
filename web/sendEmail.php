<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('library.php');
require __DIR__ . '/../vendor/autoload.php';

$conn = get_database_connection();

// Check if userEmail is set
if (isset($userEmail) && !empty($userEmail)) {

    // Query to find the user_id for the given email
    $userSql = <<<SQL
        SELECT user_id
        FROM users
        WHERE user_email = '$userEmail';
    SQL;

    $userResult = mysqli_query($conn, $userSql);

    // Check if the query was successful
    if ($userResult && mysqli_num_rows($userResult) > 0) {
        $randomBytes = random_bytes(32); // Generate 32 random bytes
        $token = bin2hex($randomBytes); // Convert to a hexadecimal token
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 days')); // Token expires in 30 days

        // Fetch the user_id and handle token logic
        while ($row = mysqli_fetch_assoc($userResult)) {
            $userId = $row['user_id'];

            // Delete any existing tokens for the same user and type
            $deleteSql = <<<SQL
                DELETE FROM user_tokens
                WHERE user_id = $userId AND token_type = 'reset';
            SQL;

            if (!mysqli_query($conn, $deleteSql)) {
                header('Location: index.php?content=forgotPassword&status=error');
                exit;
            }

            // Insert the new token into the database
            $insertSql = <<<SQL
                INSERT INTO user_tokens (user_id, token, expires_at, token_type) 
                VALUES ($userId, '$token', '$expiresAt', 'reset');
            SQL;

            if (!mysqli_query($conn, $insertSql)) {
                header('Location: index.php?content=forgotPassword&status=error');
                exit;
            }
        }

        // Send the password reset email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hanoverhighschoolconnect@gmail.com'; // Your Gmail address
            $mail->Password = 'xcli edpx uhti nvin';   // Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('hanoverhighschoolconnect@gmail.com', 'HHS Connect');
            $mail->addAddress($userEmail); // User's email

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Click <a href="http://localhost:8080/instagram-project/web/index.php?content=ResetPassword&token=' . $token . '">here</a> to reset your password.';

            $mail->send();
            header('Location: index.php?content=forgotPassword&status=sent');
            exit;
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Email could not be sent. Error: {$mail->ErrorInfo}"]);
            exit;
        }
    } else {
        // Redirect for bad email if no rows are found
        header('Location: index.php?content=forgotPassword&status=badEmail');
        exit;
    }
} else {
    // Redirect for missing or empty email
    header('Location: index.php?content=forgotPassword&status=badEmail');
    exit;
}
?>
