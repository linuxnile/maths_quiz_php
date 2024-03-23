<?php

if (isset($_SESSION["signedin"]) == true) {

    require '../vendor/autoload.php'; // Include Composer's autoloader

    // Connect to MongoDB
    $client = new MongoDB\Client("mongodb://localhost:27017");
    $quizDB = $client->selectDatabase('mathsquiz');
    $questionsCollection = $quizDB->selectCollection('questions');

    // Retrieve all questions
    $questions = $questionsCollection->find()->toArray();

    // Initialize quiz session variables
    if (!isset($_SESSION['current_question'])) {
        $_SESSION['current_question'] = 0;
        $_SESSION['score'] = 0;
    }

    // Check if 'submit' button was pressed
    if (isset($_POST['submit'])) {
        // Check answer
        $currentQuestion = $questions[$_SESSION['current_question']];
        if ($_POST['answer'] === $currentQuestion['answer']) {
            $_SESSION['score']++;
        }
        $_SESSION['current_question']++;
    }

    // Get the current question
    $currentQuestion = $questions[$_SESSION['current_question']] ?? null;

    // Check if we reached the last question
    if ($_SESSION['current_question'] >= count($questions)) {
        echo "Quiz completed! Your score: " . $_SESSION['score'];
        session_destroy(); // End the session
        exit();
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Math Quiz</title>
    </head>

    <body>
        <?php if ($currentQuestion) : ?>
            <form method="post">
                <p><?php echo $currentQuestion['question']; ?></p>
                <?php foreach ($currentQuestion['options'] as $key => $value) : ?>
                    <label>
                        <input type="radio" name="answer" value="<?php echo $key; ?>">
                        <?php echo $key . ': ' . $value; ?>
                    </label><br>
                <?php endforeach; ?>
                <input type="submit" name="submit" value="Submit Answer">
            </form>
        <?php endif; ?>
    </body>

    </html>

<?php } else {
    header("Location: index.php");
    exit();
}
?>