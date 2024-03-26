<?php
session_name("user");
session_start();

// Check if the user has taken a quiz
if (!isset($_SESSION['score'])) {
    // Redirect to the main page if no quiz has been taken
    header('Location: index.php');
    exit();
}

// Retrieve the score and message
$score = $_SESSION['score'];
$message = $_SESSION['message'];

// Clear the session data for a new quiz
unset($_SESSION['current_question']);
unset($_SESSION['score']);
unset($_SESSION['answers']);
unset($_SESSION['quiz_level']);
?>

<html>

<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="css/playquiz.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="quiz-container">
        <h1>Your Quiz Results</h1>
        <p><?php echo $message; ?></p>
        <div class="results-info">
            <h2>Your Score:</h2>
            <p><?php echo $score; ?></p>
        </div>
        <div class="button-container">
            <a href="playquiz.php" class="btn">Start New Quiz</a>
            <a href="index.php" class="btn">Exit</a>
        </div>
    </div>
</body>

</html>