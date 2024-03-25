<?php
session_name("user");
session_start();
?>

<html>

<head>
    <title>Maths Quiz for Kids</title>
    <link rel="stylesheet" href="css/Home.css">
</head>

<body>
    <?php include('header.php'); ?>
    <div class="container">
        <header>
            <h1>Maths is Fun!</h1>
            <p>Test your math skills and have fun learning!</p>
        </header>
        <a href="playquiz.php" class="quiz-button">Start the Quiz!</a>
    </div>
</body>

</html>