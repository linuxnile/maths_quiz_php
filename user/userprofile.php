<?php

session_name("user");
session_start();

if (isset($_SESSION["signedin"]) == true) {
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $database = $mongoClient->mathsquiz;
    $collection = $database->users;
    $user = $collection->findOne([
        "email" => $_SESSION["email"]
    ]);

    if ($user) {
        $userName = $user->name;
        $standard = $user->standard;
        $address_line = $user->address_line;
        $city = $user->city;
        $mobile_number = $user->mobile_number;
        $security_question = $user->security_question;
        $security_answer = $user->security_answer;
    } ?>

    <html>

    <head>
        <title>Profile</title>
        <link rel="stylesheet" href="css/userprofile.css">
    </head>

    <body>
        <?php include('header.php'); ?>

        <div class="profile-form">
            <h2>Update Your Profile</h2>
            <form action="" method="post">
                <div class="form-part">
                    <label>
                        Name:
                        <input type="text" name="name" required value="<?php echo $userName; ?>" />
                    </label>
                    <br />

                    <label>
                        Standard:
                        <select name="std" required>
                            <option value="">Select standard</option>
                            <option value="1" <?php if ($standard == '1') echo 'selected'; ?>>Standard 1</option>
                            <option value="2" <?php if ($standard == '2') echo 'selected'; ?>>Standard 2</option>
                            <option value="3" <?php if ($standard == '3') echo 'selected'; ?>>Standard 3</option>
                            <option value="4" <?php if ($standard == '4') echo 'selected'; ?>>Standard 4</option>
                            <option value="5" <?php if ($standard == '5') echo 'selected'; ?>>Standard 5</option>
                        </select>
                    </label>
                    <br />

                    <label>
                        Address:
                        <input type="text" placeholder="Address line..." name="add_line" required value="<?php echo $address_line; ?>" />
                        <input type="text" placeholder="City name" name="city" required value="<?php echo $city; ?>" />
                    </label>
                </div>

                <div class="form-part">
                    <label>
                        Mobile Number:
                        <input type="tel" name="mobileNo" required value="<?php echo $mobile_number; ?>" />
                    </label>
                    <br />

                    <label>
                        Choose question:
                        <select name="secQts" required>
                            <option value="">Select any question</option>
                            <option value="animal" <?php if ($security_question == 'animal') echo 'selected'; ?>>What animal do you like the most?</option>
                            <option value="friend" <?php if ($security_question == 'friend') echo 'selected'; ?>>
                                What is the name of your best friend?
                            </option>
                            <option value="hobby" <?php if ($security_question == 'hobby') echo 'selected'; ?>>
                                What is your favorite hobby or activity?
                            </option>
                        </select>
                    </label>
                    <br />

                    <label>
                        Answer here:
                        <input type="text" name="secAns" required value="<?php echo $security_answer; ?>" />
                    </label>

                    <div class="chngpwd">
                        Wanna change password?
                        <a href="#">Click here</a>
                    </div>
                </div>

                <button type="submit" name="update">Update</button>
            </form>
        </div>
    </body>

    </html>
<?php
    if (isset($_POST['update'])) {
        $userName = $_POST['name'];
        $standard = $_POST['std'];
        $address_line = $_POST['add_line'];
        $city = $_POST['city'];
        $mobile_number = $_POST['mobileNo'];
        $security_question = $_POST['secQts'];
        $security_answer = $_POST['secAns'];

        $userUpdate = $collection->updateOne(
            ["email" => $_SESSION["email"]],
            [
                '$set' => [
                    "name" => $userName,
                    "standard" => $standard,
                    "address_line" => $address_line,
                    "city" => $city,
                    "mobile_number" => $mobile_number,
                    "security_question" => $security_question,
                    "security_answer" => $security_answer
                ]
            ]
        );
        if ($userUpdate) {
            $_SESSION["userName"] = $userName;

            echo
            '<script>
            alert("Details Updated Successfully!");
            window.location.href = "index.php";
        </script>';
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>