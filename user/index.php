<?php

session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) { ?>
    <html>

    <head>
        <link rel="shortcut icon" href="assets/maths quiz.jpg" type="image/x-icon">
        <link rel="stylesheet" href="css/index.css">
    </head>

    <body>
        <div class="heading">
            <a href="index.php">
                <img src="assets/maths quiz.jpg" alt="Logo" class="logo">
                <h1>Welcome to Maths Quiz for Kids</h1>
                <img src="assets/maths quiz.jpg" alt="Logo" class="logo">
            </a>
        </div>

        <div class="nav">
            <a href="index.php">Home</a>
            <a href="index.php?contact">Contact Us</a>
            <a href="index.php?userprofile">Welcome <?php echo $_SESSION['userName']; ?></a>
            <a href="logout.php">Logout</a>
        </div>
    </body>

    </html>
<?php
    if (isset($_GET['contact'])) {
        include("contact.php");
    }

    if (isset($_GET['custprofile'])) {
        include("custprofile.php");
    }

    if (isset($_GET['userpasswd'])) {
        include("userpasswd.php");
    }

    if (isset($_GET['userprofile'])) {
        include("userprofile.php");
    }

    if (!isset($_GET['contact'])) {
        if (!isset($_GET['custprofile'])) {
            if (!isset($_GET['custpasswd'])) {
                if (!isset($_GET['userprofile'])) {
                    include('home.php');
                }
            }
        }
    }
} else {
    header("Location: login.php");
}
?>