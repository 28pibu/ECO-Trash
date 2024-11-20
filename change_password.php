<?php
include("connect.php");

if (isset($_GET['email']) && isset($_POST['updatePassword'])) {
    $email = $_GET['email'];
    $newPassword = $_POST['newPassword'];
    
    // Check if the new password length is at least 8 characters
    if (strlen($newPassword) < 8) {
        echo "<script>alert('The password length must be at least 8 characters.');</script>";
    } else {
        $newPassword = md5($newPassword); // Hash the password

        // Update the password in the database
        $updateQuery = "UPDATE users SET password='$newPassword' WHERE email='$email'";
        
        if ($conn->query($updateQuery) === TRUE) {
            echo "<script>alert('Password updated successfully.');</script>";
            header("Location: index.php");
        } else {
            echo "<script>alert('Error updating password.');</script>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card p-4">
                    <h1 class="text-center mb-4">Change Password</h1>
                    <form method="post">
                        <div class="mb-3">
                            <input 
                                type="password" 
                                name="newPassword" 
                                class="form-control" 
                                placeholder="Enter new password" 
                                required>
                        </div>
                        <div class="d-grid">
                            <button 
                                type="submit" 
                                name="updatePassword" 
                                class="btn btn-success">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional, for dynamic components like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
