<?php

require '../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->mathsquiz->questions;

function addQuestion($question, $options, $answer, $category) {
    global $collection;
    $result = $collection->insertOne([
        'question' => $question,
        'options' => $options,
        'answer' => $answer,
        'category' => $category
    ]);
    return $result->getInsertedId();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $option1 = $_POST['option1'];
    $option2 = $_POST['option2'];
    $option3 = $_POST['option3'];
    $option4 = $_POST['option4'];
    $options = array($option1, $option2, $option3, $option4);
    $answer = $_POST['answer'];
    $category = $_POST['category'];

    $insertedId = addQuestion($question, $options, $answer, $category);
    if ($insertedId) {
       echo "<script>alert('Question added successfully with ID: " . $insertedId . "')</script>";
       echo "<script>window.location.href='add_questions.php';</script>";
    } else {
        echo "Error adding question.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
</head>
<body>
    <h2>Add Question</h2>
    <form method="post" action="">
        <label>Question:</label><br>
        <input type="text" name="question" required><br><br>

        <label>Option 1:</label><br>
        <input type="text" name="option1" required><br><br>

        <label>Option 2:</label><br>
        <input type="text" name="option2" required><br><br>

        <label>Option 3:</label><br>
        <input type="text" name="option3" required><br><br>

        <label>Option 4:</label><br>
        <input type="text" name="option4" required><br><br>

        <label>Answer:</label><br>
        <input type="text" name="answer" required><br><br>

        <label>Category:</label><br>
        <select name="category">
            <option value="1">Class 1</option>
            <option value="2">Class 2</option>
            <option value="3">Class 3</option>
            <option value="4">Class 4</option>
            <option value="5">Class 5</option>
        </select><br><br>

        <input type="submit" value="Add Question">
    </form>
</body>
</html>
