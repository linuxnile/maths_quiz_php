<?php
session_name("user");
session_start();
?>

<html>

<head>
    <title>Quiz Start</title>
    <link rel="stylesheet" href="css/playquiz.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="quiz-container">
        <h1>Welcome to the Quiz</h1>
        <p>Test your knowledge by selecting a quiz level below:</p>
        <div class="button-container">
            <button class="btn level-easy">Easy</button>
            <button class="btn level-medium">Medium</button>
            <button class="btn level-hard">Hard</button>
            <button class="btn level-expert">Expert</button>
        </div>
        <p>Choose your challenge wisely and enjoy!</p>
        <div class="quiz-info">
            <h2>How to Play:</h2>
            <ul>
                <li>Choose your desired quiz level by clicking on one of the buttons above.</li>
                <li>Once you select a level, you'll be presented with a series of questions.</li>
                <li>Answer each question to the best of your ability.</li>
                <li>After answering all questions, submit your answers and see how well you did!</li>
            </ul>
        </div>
    </div>
</body>

</html>