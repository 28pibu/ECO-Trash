<?php 
include 'connect.php'; 
require 'mailer.php'; 

if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $wifiName = $_POST['wifiName'];
    $wifiPassword = $_POST['wifiPassword'];
    $secretCode = $_POST['secretCode']; 
    
    $expectedSecretCode = "gar@123456"; 
    
    // Check if the secret code is correct
    if ($secretCode !== $expectedSecretCode) {
        echo "<script>alert('Incorrect Secret Key. Please contact the admin. 😞 ');</script>";
        exit(); // Stop execution if the secret code is incorrect
    }

    // Check if password length is less than 8 characters
    if (strlen($password) < 8) {
        echo "<script>alert('The password length must be at least 8 characters.');</script>";
        exit(); // Stop execution if the password is too short
    }
    $password = md5($password); // Hash the password

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email Address Already Exists! ');</script>";
    } else {
        // Create an account activation hash
        $activationHash = md5(uniqid(rand(), true));

        // Insert new user and WiFi details
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password, wifiname, wifipassword, account_activation_hash, email_verified)
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$wifiName', '$wifiPassword', '$activationHash', 0)";

        if ($conn->query($insertQuery) === TRUE) {
            // Prepare verification email
            $subject = "Email Verification";
            $body = "Hello $firstName,<br><br>To verify your email, please click the link below:<br>
                     <a href='http://localhost/login/activate.php?hash=$activationHash'>Verify Email</a><br><br>
                     Thank you!";
            
            // Attempt to send the verification email
            if (Mailer::sendEmail($email, $subject, $body)) {
                echo "Registration successful! Please check your email to verify your account.";
                header("Refresh: 5; URL=index.php"); // Redirect to index page after a few seconds
                exit();
            } else {
                echo "Registration successful, but the verification email could not be sent.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Hash the password

    // Check if user exists with email and password
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the account is activated
        if ($row['email_verified'] == 1) { // Check the email_verified field
            session_start();
            $_SESSION['email'] = $row['email'];

            // Update the WiFi info as the user has to re-enter it
            $wifiName = $_POST['wifiName']; // Get the WiFi name from the form
            $wifiPassword = $_POST['wifiPassword']; // Get the WiFi password from the form

            $updateQuery = "UPDATE users SET wifiname='$wifiName', wifipassword='$wifiPassword' WHERE email='$email'";
            if ($conn->query($updateQuery) === TRUE) {
                header("Location: homepage.php"); // Redirect to garbage details page after successful sign-in
                exit();
            } else {
                echo "Error updating WiFi details: " . $conn->error;
            }
        } else {
            // Display a user-friendly error message for unactivated accounts
            echo "<script>alert('Your account is not activated. Please check your email to activate your account 😞 ');</script>";
        }
    } else {
        // Display a user-friendly error message for incorrect email or password
        echo "<script>alert('You entered an incorrect email or password. 😞 ');</script>";
    }
}
?>
