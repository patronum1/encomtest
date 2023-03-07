<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $school = $_POST['school'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "new");
    
    // check if user exists
    $result = mysqli_query($conn, "SELECT * FROM users WHERE school='$school' AND email='$email' AND phone='$phone' AND username='$username'");
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['school'] = $school;
            header("location: dashboard.php");
        } else {
            echo '<script>alert("Invalid username or password");</script>';
        }
    } else {
        echo '<script>alert("Invalid username or password");</script>';
    }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <div class="container">
      <form method="POST" action="login.php" class="form-container">
        <div class="image-container">
        <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" alt="Login Image">
        </div>
        <div>
        <div class="container-1">
          <h2>Нэвтрэх</h2>
          <label for="school">Сургууль сонгох:</label>
    <select name="school">
        <option value="Шутис">Шутис</option>
        <option value="Муис">Муис</option>
        <option value="Ашиус">Ашиус</option>
    </select>
      <br>
      <label for="username">Нэвтрэх нэр:</label>
      <input type="text" name="username">
      <br>
      <label for="password">Нууц үг:</label>
      <input type="password" name="password">
      <br>
      <input type="submit" value="Нэвтрэх">
    </div>
    </div>
  </form>
</div>

