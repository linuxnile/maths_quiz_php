<?php
require '../vendor/autoload.php';
session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $address_line = $_POST['add_line'];
    $city = $_POST['city'];
    $mobile_number = $_POST['mobileNo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $security_question = $_POST['secQts'];
    $security_answer = $_POST['secAns'];
    date_default_timezone_set('Asia/Kolkata');
    $listTimestamp = time();
    $registration_date = date('d-m-Y H:i:s', $listTimestamp);

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->users;

    $insertResult = $collection->insertOne(
        [
            'name' => $name,
            'email' => $email,
            'age' => $age,
            'address_line' => $address_line,
            'city' => $city,
            'mobile_number' => $mobile_number,
            'password' => $password,
            'security_question' => $security_question,
            'security_answer' => $security_answer,
            'registration_date' => $registration_date
        ]
    );

    if ($insertResult->getInsertedCount() > 0) {
        echo "<script>alert('User Registered Successfully!')</script>";
        echo "<script>window.location.href='login.php';</script>";
    } else {
        echo "User registration failed.";
    }
}
?>

<html>

<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="css/register.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="registration-form">
        <h2>User Registration</h2>

        <form action="" method="post">
            <div class="form-part">
                <label>
                    Name:
                    <input type="text" name="name" required placeholder="Enter your name" />
                </label>
                <br />

                <label>
                    Email:
                    <input type="email" name="email" required placeholder="Enter your email" />
                </label>

                <br />
                <label>
                    Age:
                    <input type="number" name="age" required placeholder="Enter your age">
                </label>
                <br />

                <label>
                    Address:
                    <input type="text" name="add_line" required placeholder="Address line..." />
                    <input type="text" name="city" required placeholder="City name" />
                </label>
            </div>

            <div class="form-part">
                <label>
                    Mobile Number:
                    <input type="tel" name="mobileNo" required placeholder="Enter your mobile number" />
                </label>
                <br />

                <label>
                    Password:
                    <input type="password" name="password" required placeholder="Enter password" />
                </label>
                <br />

                <label>
                    Choose question:
                    <select name="secQts" required>
                        <option value="">Select any question</option>
                        <option value="animal">What animal do you like the most?</option>
                        <option value="friend">
                            What is the name of your best friend?
                        </option>
                        <option value="hobby">
                            What is your favorite hobby or activity?
                        </option>
                    </select>
                </label>
                <br />

                <label>
                    Answer here:
                    <input type="text" name="secAns" required placeholder="Enter answer" />
                </label>

                <div class="alrdyacc">
                    Have an account?
                    <a href="login.php">Log in</a>
                </div>
            </div>

            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>