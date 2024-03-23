<!DOCTYPE html>
<html>

<head>
    <title>Insert Quiz Question</title>
</head>

<body>
    <h2>Insert a new MCQ Question</h2>
    <form action="" method="post">
        <label for="question">Question:</label><br>
        <input type="text" id="question" name="question" required><br>

        <label for="optionA">Option A:</label><br>
        <input type="text" id="optionA" name="optionA" required><br>

        <label for="optionB">Option B:</label><br>
        <input type="text" id="optionB" name="optionB" required><br>

        <label for="optionC">Option C:</label><br>
        <input type="text" id="optionC" name="optionC" required><br>

        <label for="optionD">Option D:</label><br>
        <input type="text" id="optionD" name="optionD" required><br>

        <label for="answer">Correct Answer:</label><br>
        <select id="answer" name="answer" required>
            <option value="A">Option A</option>
            <option value="B">Option B</option>
            <option value="C">Option C</option>
            <option value="D">Option D</option>
        </select><br><br>

        <input type="submit" value="Insert Question">
    </form>
</body>

</html>

<?php
require '../vendor/autoload.php'; // Include Composer's autoloader

// Connect to MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");
$quizDB = $client->selectDatabase('mathsquiz');
$questionsCollection = $quizDB->selectCollection('questions');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $questionText = $_POST['question'];
    $options = [
        'A' => $_POST['optionA'],
        'B' => $_POST['optionB'],
        'C' => $_POST['optionC'],
        'D' => $_POST['optionD']
    ];
    $answer = $_POST['answer'];

    // Insert the new question
    $insertResult = $questionsCollection->insertOne([
        'question' => $questionText,
        'options' => $options,
        'answer' => $answer
    ]);

    if ($insertResult->getInsertedCount() == 1) {
        echo "Question inserted successfully";
    } else {
        echo "Error inserting question";
    }
}
?>