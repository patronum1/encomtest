<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("location: login.php");
}

$username = $_SESSION['username'];
$school = $_SESSION['school'];
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = array();

    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "new");



    // update password if both new and confirm passwords match
    if(!empty($new_password) && $new_password == $confirm_password) {
        mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE username='$username'");
    } elseif(!empty($new_password) && $new_password != $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    mysqli_close($conn);

    // redirect to settings page with success or error message
    if(count($errors) == 0) {
        header("location: settings.php?success=1");
    } else {
        header("location: settings.php?error=" . urlencode(implode("<br>", $errors)));
    }
}

// get user's avatar filename from database
$conn = mysqli_connect("localhost", "root", "", "new");
$result = mysqli_query($conn, "SELECT avatar FROM users WHERE username='$username'");
if($result === false) {
    die("Error executing query: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$avatar_filename = $row['avatar'];
mysqli_close($conn);
?>
<!DOCTYPE html>
<head>
    <title>Settings</title>
    <style>
        body {
            background-color: #f1f8ff;
            color: #333;
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
        }

        h1 {
            color: #0071c5;
            font-size: 2.5em;
            margin-bottom: 0.5em;
        }

        form {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
            width: 50%;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 0.5em;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"] {
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
            margin-bottom: 1em;
            padding: 0.5em;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #0071c5;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 1.2em;
            padding: 0.5em;
        }

        input[type="submit"]:hover {
            background-color: #005d9c;
        }

        p {
            margin-bottom: 0.5em;
        }

        a {
            color: #0071c5;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    
    <?php
        // check for success or error message in URL query string
        if(isset($_GET['success'])) {
            echo "<p style='color: green'>Settings saved successfully</p>";
        } elseif(isset($_GET['error'])) {
            echo "<p style='color: red'>" . $_GET['error'] . "</p>";
        }
    ?>
    <form method="POST" action="update_settings.php" enctype="multipart/form-data">
    <h1>Тохиргоо</h1>
        <?php
            // display user's current avatar if available
            $conn = mysqli_connect("localhost", "root", "", "new");
            $result = mysqli_query($conn, "SELECT avatar, school FROM users WHERE username='$username'");
            $row = mysqli_fetch_assoc($result);
            if($row['school']) {
                echo "<p>Сургууль: " . $row['school'] . "</p>";
            }
            mysqli_close($conn);
        ?>
        <p>Хэрэглэгчийн нэр: <?php echo $username; ?></p>
        <br>
        <label for="new_password">Шинэ нууц үг:</label>
        <input type="password" name="new_password">
        <br>
        <label for="confirm_password">Нууц үг давтах:</label>
        <input type="password" name="confirm_password">
        <br>
        <input type="submit" value="Хадгалах">    <a href="dashboard.php">Буцах</a>
    </form>
</body>
</html>
