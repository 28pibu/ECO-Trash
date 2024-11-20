<?php
include 'connect.php'; // Include your database connection

if (isset($_GET['hash'])) {
    $activationHash = $_GET['hash'];

    // Update the user's account as activated
    $updateQuery = "UPDATE users SET account_activation_hash=NULL, email_verified=1 WHERE account_activation_hash='$activationHash'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Your account has been activated! You can now log in.";
    } else {
        echo "Error activating account: " . $conn->error;
    }
} else {
    echo "Invalid activation link.";
}
?>
