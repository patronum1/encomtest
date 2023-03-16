<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("location: login.php");
}

$username = $_SESSION['username'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $avatar = $_POST['avatar'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = array();

    // connect to the database
    require_once 'connection.php';

    // update avatar if it's not empty
    if(!empty($avatar)) {
        mysqli_query($conn, "UPDATE users SET avatar='$avatar' WHERE username='$username'");
    }

    // update password if both new and confirm passwords match
    if(!empty($new_password) && $new_password == $confirm_password) {
        // remove password length check
        $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$password_hash' WHERE username='$username'");
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
?>
