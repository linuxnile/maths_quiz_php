<?php
// Check if a session is not already started before calling session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->mathsquiz->questions;

// Function to get a random question from a specific category
function getQuestion($collection, $category) {
    $questions = $collection->find(['category' => $category])->toArray();
    if (count($questions) > 0) {
        return $questions[array_rand($questions)];
    }
    return null;
}

// Check if the quiz has started
if (!isset($_SESSION['started'])) {
    $_SESSION['started'] = true;
    $_SESSION['score'] = 0;
    $_SESSION['questionIndex'] = 0;
    // Fetch a random question from the category 'Standard 1'
    $_SESSION['currentQuestion'] = getQuestion($collection, 'Standard 1');
}

// Handle the answer submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['answer'])) {
    $selectedOption = (int)$_POST['answer'];
    $currentQuestion = $_SESSION['currentQuestion'];

    // Check if the answer is correct
    if ($selectedOption === $currentQuestion['correctOptionIndex']) {
        $_SESSION['score']++;
    }

    // Fetch the next question from the same category
    $_SESSION['currentQuestion'] = getQuestion($collection, 'Standard 1');
    $_SESSION['questionIndex']++;
}

// Check if the quiz is over
if ($_SESSION['questionIndex'] >= 10) { // Example question limit
    echo "Quiz over! Your score: " . $_SESSION['score'];
    // Redirect to a new page to display the score
    header('Location: quiz_over.php');
    exit;
}

// Before displaying the question and options, check if $currentQuestion is not null
if (isset($_SESSION['currentQuestion']) && $_SESSION['currentQuestion'] !== null) {
    $currentQuestion = $_SESSION['currentQuestion'];
    // HTML and PHP code to display the question and options
    // Make sure to also include the check for $currentQuestion['options'] being an array
} else {
    echo "No questions available in the selected category.";
    // Handle the case when there are no questions or an error occurred
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Play Quiz</title>
    <script>
        // Timer function
        var timeLeft = 10; // Timer set for 10 seconds
        var timerId = setInterval(countdown, 1000);

        function countdown() {
            if (timeLeft == 0) {
                clearTimeout(timerId);
                submitAnswer(); // Submit the answer when the timer runs out
            } else {
                document.getElementById("timer").innerHTML = timeLeft + ' seconds remaining';
                timeLeft--;
            }
        }

        // Function to submit the answer
        function submitAnswer() {
            document.getElementById("quizForm").submit();
        }
    </script>
</head>
<body>
    <h2>Play Quiz</h2>
    <div id="timer">10 seconds remaining</div>
    <?php if (isset($currentQuestion) && $currentQuestion !== null): ?>
        <form id="quizForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <p><?php echo $currentQuestion['question']; ?></p>
            <?php if (is_array($currentQuestion['options'])): ?>
                <?php foreach ($currentQuestion['options'] as $index => $option): ?>
                    <input type="radio" name="answer" value="<?php echo $index; ?>" required> <?php echo $option; ?><br>
                <?php endforeach; ?>
            <?php endif; ?>
            <button type="submit">Submit Answer</button>
        </form>
    <?php else: ?>
        <p>No question available to display.</p>
    <?php endif; ?>
</body>
</html>