<?php
session_name("user");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['quiz_level'] = $_POST['level'];
    header('Location: quiz_page.php');
    exit();
}
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
        <form action="" method="post">
            <div class="button-container">
                <button type="submit" name="level" value="easy" class="btn level-easy">Easy</button>
                <button type="submit" name="level" value="normal" class="btn level-normal">Normal</button>
                <button type="submit" name="level" value="hard" class="btn level-hard">Hard</button>
                <button type="submit" name="level" value="expert" class="btn level-expert">Expert</button>
            </div>
        </form>
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