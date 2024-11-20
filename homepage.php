<?php
session_start();
include("connect.php");

// Fetch the latest entry from the live_update table
$query = "SELECT * FROM live_update ORDER BY last_cleaned_date DESC LIMIT 1";
$result = $conn->query($query);
$liveUpdate = $result->fetch_assoc();

// Fetch the user's email
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(45deg, #2193b0, #6dd5ed);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            overflow-x: hidden;
        }

        .container {
            background: #fff;
            color: #333;
            border-radius: 20px;
            box-shadow: 0px 12px 80px rgba(0, 0, 0, 0.2);
            width: 85%;
            max-width: 1300px;
            animation: fadeIn 1.2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Greeting Section */
        .greeting {
            background: linear-gradient(120deg, #ff6a00, #ee0979);
            color: #fff;
            text-align: center;
            padding: 4rem 2rem;
            border-bottom: 5px solid #fff;
            transition: all 0.4s ease;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .greeting:hover {
            transform: scale(1.05);
            box-shadow: 0px 15px 60px rgba(255, 105, 180, 0.4);
        }

        .greeting h1 {
            font-size: 3.2rem;
            font-weight: 700;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .greeting img {
            margin-top: 1rem;
            width: 70%;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Live Update Section */
        .live-update {
            padding: 3.5rem 2rem;
            text-align: center;
            background: linear-gradient(120deg, #3b9e9b, #6dd5ed);
            color: #fff;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            box-shadow: 0px -5px 40px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .live-update h2 {
            font-size: 2.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 2rem;
        }

        .live-update .bin-image {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
            background-image: url('closed-bin-icon.png');
            background-size: cover;
            transition: background-image 0.3s ease;
        }

        .live-update:hover .bin-image {
            background-image: url('open-bin-icon.png');
        }

        .update-details {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.2);
            margin-bottom: 2.5rem;
            font-size: 1.1rem;
            backdrop-filter: blur(10px);
        }

        .live-update p:hover {
            color: #ffd700;
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        .star-rating {
            font-size: 2rem;
            color: gold;
        }

        /* Button Styling */
        .logout-btn {
            background: linear-gradient(45deg, #ff6a00, #ee0979);
            color: #fff;
            padding: 1rem 3rem;
            font-size: 1.6rem;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0px 5px 25px rgba(255, 105, 180, 0.3);
        }

        .logout-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0px 12px 70px rgba(255, 105, 180, 0.6);
            background: linear-gradient(45deg, #ee0979, #ff6a00);
        }

        /* Footer Styling */
        footer {
            background: #ff6a00;
            color: #fff;
            padding: 2.5rem;
            text-align: center;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        footer p {
            font-size: 1.4rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        footer img {
            width: 90px;
            border-radius: 50%;
            margin-top: 1rem;
            transition: all 0.4s ease;
        }

        footer img:hover {
            transform: scale(1.1);
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            .greeting h1 {
                font-size: 2.5rem;
            }

            .live-update h2 {
                font-size: 1.8rem;
            }

            .logout-btn {
                font-size: 1.3rem;
                padding: 0.8rem 2.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Greeting Section -->
        <div class="greeting">
            <h1>Welcome Back, Superstar! <i class="fas fa-star"></i></h1>
            <img src="welcome-back-black-handwritten-letters-260nw-2410328775.jpg" alt="Welcome Image">
        </div>

        <!-- Live Update Section -->
        <div class="live-update">
            <h2>Latest Garbage Update <i class="fas fa-trash-alt"></i></h2>
            
            <?php if ($liveUpdate): ?>
                <div class="update-details">
                    <p><strong>📍 Location:</strong> <span class="hover-text"><?php echo $liveUpdate['location']; ?></span></p>
                    <hr>
                    <p><strong>📊 Garbage Level:</strong> <span class="hover-text"><?php echo $liveUpdate['garbage_level']; ?>%</span></p>
                    <hr>
                    <p><strong>🗓 Last Cleaned Date:</strong> <span class="hover-text"><?php echo $liveUpdate['last_cleaned_date']; ?></span></p>
                    <hr>
                </div>
                <div class="star-rating">
                    <?php
                    $garbageLevel = $liveUpdate['garbage_level'];
                    $stars = round($garbageLevel / 20);
                    ?>
                    <p><strong>⭐ Rating: </strong>
                        <?php for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $stars) ? "<span style='color: gold;'>★</span>" : "<span style='color: gray;'>☆</span>";
                        } ?>
                    </p>
                </div>
            <?php else: ?>
                <p class="text-muted">No live update available.</p>
                <img src="No Update Available.webp" alt="No Data" class="img-fluid rounded my-3 mx-auto d-block" style="width: 50%; opacity: 0.7;">
            <?php endif; ?>
        </div>

        <!-- Logout Button -->
        <div class="text-center my-4">
            <a href="logout.php" class="btn logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>Powered by Group_01 Smart Garbage Management System</p>
        <img src="image3.jpg" alt="Logo">
    </footer>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>

</html>








