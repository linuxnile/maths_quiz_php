<?php

session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->scores;
    $scores = $collection->find(['email' => $_SESSION["email"]]);
?>
    <html>

    <head>
        <title>Maths Quiz Scores</title>
        <link rel="stylesheet" href="css/scores.css">
    </head>

    <body>
        <?php include('header.php'); ?>
        <div class="container">
            <h2>Maths Quiz Scores</h2>
            <table>
                <tr>
                    <th>_id</th>
                    <th>Category</th>
                    <th>Score</th>
                    <th>Date</th>
                </tr>
                <?php

                foreach ($scores as $document) {
                    echo "<tr>";
                    echo "<td>" . $document['_id'] . "</td>";
                    echo "<td>" . $document['category'] . "</td>";
                    echo "<td>" . $document['score'] . "</td>";
                    echo "<td>" . $document['date'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </body>

    </html>
<?php
} else {
    header("Location: index.php");
    exit();
}
