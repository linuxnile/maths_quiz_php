<?php

require '../vendor/autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->mathsquiz->questions;


function addQuestion(string $question, array $options, int $correctOptionIndex, string $category): string {
    global $collection;
    $result = $collection->insertOne([
        'question' => $question,
        'options' => $options,
        'correctOptionIndex' => $correctOptionIndex,
        'category' => $category,
        'createdAt' => new MongoDB\BSON\UTCDateTime(),
    ]);
    return (string)$result->getInsertedId();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST['question'];
    $options = [
        $_POST['option1'],
        $_POST['option2'],
        $_POST['option3'],
        $_POST['option4']
    ];
    $correctOptionIndex = (int)$_POST['correctOptionIndex'];
    $category = $_POST['category'];

    $insertedId = addQuestion($question, $options, $correctOptionIndex, $category);
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
    <link rel="stylesheet" href="css/question.css">
</head>
<body>
    <h2>Add Question</h2>
    <form method="post" action="">
        <label>Question:</label><br>
        <input type="text" name="question" placeholder="Enter the question" required><br><br>

        <label>Options:</label><br>
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <input type="text" name="option<?php echo $i; ?>" placeholder="Enter option <?php echo $i; ?>" required><br>
        <?php endfor; ?><br>

        <label>Correct Option:</label><br>
        <select name="correctOptionIndex">
            <?php for ($i = 0; $i < 4; $i++) : ?>
                <option value="<?php echo $i; ?>"><?php echo $i + 1; ?></option>
            <?php endfor; ?>
        </select><br><br>

        <label>Category:</label><br>
        <select name="category">
            <option value="Class 1">Class 1</option>
            <option value="Class 2">Class 2</option>
            <option value="Class 3">Class 3</option>
            <option value="Class 4">Class 4</option>
            <option value="Class 5">Class 5</option>
        </select><br><br>

        <input type="submit" value="Add Question">
    </form>
</body>
</html>