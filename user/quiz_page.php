<?php
session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->questions;

    if (!isset($_SESSION['category'])) {
        header('Location: index.php');
        exit();
    }

    $category = $_SESSION['category'];
    $questions = $collection->find(['category' => $category])->toArray();

    shuffle($questions);
    $questions = array_slice($questions, 0, 10);

    if (!isset($_SESSION['current_question'])) {
        $_SESSION['current_question'] = 0;
        $_SESSION['score'] = 0;
        $_SESSION['answers'] = [];
    }

    $totalQuestions = count($questions);

    if ($totalQuestions == 0) {
        echo
        '<script>
            alert("No questions available for this quiz category. Please try again later.");
            window.location.href = "playquiz.php";
        </script>';
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['next'])) {
            if (isset($_POST['answer'])) {
                $_SESSION['answers'][$_SESSION['current_question']] = $_POST['answer'];
            }
            $_SESSION['current_question']++;
        } elseif (isset($_POST['prev'])) {
            $_SESSION['current_question']--;
        } elseif (isset($_POST['submit'])) {
            $_SESSION['answers'][$_SESSION['current_question']] = $_POST['answer'];

            foreach ($_SESSION['answers'] as $index => $answer) {
                if ($questions[$index]['answer'] == $answer) {
                    $_SESSION['score']++;
                }
            }

            date_default_timezone_set('Asia/Kolkata');
            $listTimestamp = time();
            $date = date('d-m-Y H:i:s', $listTimestamp);

            $score = $_SESSION['score'] . '/' . $totalQuestions;
            $_SESSION['totalQuestions'] = $totalQuestions;

            $scoreData = [
                'email' => $_SESSION['email'],
                'category' => $category,
                'score' => $score,
                'date' => $date
            ];

            $collection_score = $database->scores;
            $insertResult = $collection_score->insertOne($scoreData);

            if ($insertResult->getInsertedCount() == 1) {
                $_SESSION['message'] = 'Your score has been successfully saved!';
                header('Location: results_page.php');
            }
            exit();
        } else {
            $_SESSION['message'] = 'There was an error saving your score. Please try again.';
            header('Location: results_page.php');
        }
    }
    $currentQuestion = $questions[$_SESSION['current_question']];
?>

    <html>

    <head>
        <title>Quiz Page</title>
        <link rel="stylesheet" href="css/quiz_page.css">
    </head>

    <body>
        <?php include('header.php'); ?>
        <div class="quiz-container">
            <h1>Quiz: <?php echo ucfirst($category); ?> Category</h1>
            <form action="" method="post">
                <div class="question">
                    <h2><?php echo $currentQuestion['question']; ?></h2>
                    <div class="options">
                        <?php foreach ($currentQuestion['options'] as $key => $value) : ?>
                            <label>
                                <input type="radio" name="answer" value="<?php echo $key; ?>" onclick="highlightOption(this);" <?php echo (isset($_SESSION['answers'][$_SESSION['current_question']]) && $_SESSION['answers'][$_SESSION['current_question']] == $key) ? 'checked' : ''; ?>>
                                <?php echo $key . '. ' . $value; ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if ($_SESSION['current_question'] > 0) : ?>
                    <button type="submit" name="prev" class="btn navigation">Previous</button>
                <?php endif; ?>
                <?php if ($_SESSION['current_question'] < $totalQuestions - 1) : ?>
                    <button type="submit" name="next" class="btn navigation">Next</button>
                <?php else : ?>
                    <button type="submit" name="submit" class="btn submit-quiz">Submit Answers</button>
                <?php endif; ?>
            </form>
        </div>
        <script>
            window.onload = function() {
                var selectedOption = "<?php echo isset($_SESSION['answers'][$_SESSION['current_question']]) ? $_SESSION['answers'][$_SESSION['current_question']] : ''; ?>";
                if (selectedOption !== '') {
                    var optionToHighlight = document.querySelector('input[value="' + selectedOption + '"]');
                    highlightOption(optionToHighlight);
                }
            };

            function highlightOption(option) {
                var options = document.querySelectorAll('.options label');
                options.forEach(function(opt) {
                    opt.style.backgroundColor = '#f9f9f9';
                });

                option.parentElement.style.backgroundColor = 'lightgreen';
            }
        </script>
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