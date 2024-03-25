<?php

session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {

    require '../vendor/autoload.php';

    $client = new MongoDB\Client("mongodb://localhost:27017");
    $quizDB = $client->selectDatabase('mathsquiz');
    $questionsCollection = $quizDB->selectCollection('questions');

    $questions = $questionsCollection->find()->toArray();

    if (!isset($_SESSION['current_question'])) {
        $_SESSION['current_question'] = 0;
        $_SESSION['score'] = 0;
    }

    if (isset($_POST['submit'])) {
        $currentQuestion = $questions[$_SESSION['current_question']];
        if ($_POST['answer'] === $currentQuestion['answer']) {
            $_SESSION['score']++;
        }
        $_SESSION['current_question']++;
    }

    $currentQuestion = $questions[$_SESSION['current_question']] ?? null;

    if ($_SESSION['current_question'] >= count($questions)) {
        echo "Quiz completed! Your score: " . $_SESSION['score'];
        session_destroy();
        exit();
    }
?>

    <html>

    <head>
        <title>Play the Quiz</title>
    </head>

    <body>
        <?php include('header.php'); ?>

        <?php if ($currentQuestion) : ?>
            <form method="post">
                <p><?php echo $currentQuestion['question']; ?></p>
                <?php foreach ($currentQuestion['options'] as $key => $value) : ?>
                    <label>
                        <input type="radio" name="answer" required value="<?php echo $key; ?>">
                        <?php echo $key . ': ' . $value; ?>
                    </label><br>
                <?php endforeach; ?>
                <input type="submit" name="submit" value="Submit Answer">
            </form>
        <?php endif; ?>
    </body>

    </html>

<?php } else {
    echo
    '<script>
    alert("Please login to Start the Quiz!");
    window.location.href = "login.php";
</script>';
}
?>