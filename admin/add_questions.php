<?php
include 'connectmongo.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:admin_login.php');
}
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
<!DOCTYPE html>
<html>

<head>
    <title>Insert Quiz Question</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <?php include 'admin_header.php' ?>
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
    <script src="js/admin_script.js"></script>
</body>

</html>
