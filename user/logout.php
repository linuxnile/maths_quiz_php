<?php
session_name("user");
session_start();
session_unset();
session_destroy();
?>

<html>

<head>
    <title>Logged Out</title>
</head>

<body>
    echo "<script>
        alert('You have been logged out!');
    </script>";
    echo "<script>
        window.location.href = 'index.php';
    </script>";
</body>

</html>