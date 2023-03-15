<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$username = $_SESSION['username'];
$school = $_SESSION['school'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $avatar = $_FILES['avatar'];
    $previous_password = $_POST['previous_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $errors = array();

    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "new");

    // Check if the previous password is correct
    $result = mysqli_query($conn, "SELECT password FROM users WHERE username='$username'");
    $row = mysqli_fetch_assoc($result);
    $current_password = $row['password'];

    if ($previous_password !== $current_password) {
        $errors[] = "Previous password is incorrect.";
    } else {
        // update avatar if it's not empty
        if (!empty($avatar['name'])) {
            // check if file type is valid
            $allowed_types = array('jpg', 'jpeg', 'png');
            $file_extension = pathinfo($avatar['name'], PATHINFO_EXTENSION);
            if (!in_array($file_extension, $allowed_types)) {
                $errors[] = "Invalid file type. Only JPG, JPEG, and PNG files are allowed.";
            } else {
                // create avatars folder if it doesn't exist
                if (!file_exists('avatars')) {
                    mkdir('avatars');
                }

                // generate unique filename for avatar
                $filename = uniqid() . '.' . $file_extension;

                // save avatar file to avatars folder
                move_uploaded_file($avatar['tmp_name'], 'avatars/' . $filename);

                // update avatar filename in database
                mysqli_query($conn, "UPDATE users SET avatar='$filename' WHERE username='$username'");
            }
        }

        // update password if both new and confirm passwords match
        if (!empty($new_password) && $new_password == $confirm_password) {
            mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE username='$username'");
        } elseif (!empty($new_password) && $new_password != $confirm_password) {
            $errors[] = "Нууц үг таарахгүй байна";
        }
    }

    mysqli_close($conn);

    // redirect to settings page with success or error message
    if (count($errors) == 0) {
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

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Settings</title>
    <script src="https://kit.fontawesome.com/1f6b8b9096.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<div class="wrapper">
    <div class="menu">
        <h2><br><br><?php echo $school ?><br><br><?php echo $username ?><br></h2>
        <br><br><br>
        <ul>
            <li><a href="dashboard.php"><i class="fa-solid fa-graduation-cap"></i><span>Оюутан</span></a></li>
            <li><a href="dashboard2.php"><i class="fa-solid fa-chart-pie"></i><span>Хүний нөөц</span></a></li>
            <li><a href="dashboard3.php"><i class="fa-solid fa-book"></i><span>Эрдэм шинжилгээ</span></a></li>
            <li><a href="dashboard4.php"><i class="fa-solid fa-earth-americas"></i><span>Гадаад харилцаа</span></a></li>
            <li><a href="dashboard5.php"><i class="fa-solid fa-user"></i><span>ДБСБ-ын нэр хүнд</span></a></li>
            <li><a href="dashboard6.php"><i class="fa-sharp fa-solid fa-book-atlas"></i><span>Сургалт</span></a></li>
            <li><a href="dashboard7.php"><i class="fa-solid fa-bars"></i><span>Бусад</span></a></li>
<hr><br>
<li><a href="settings.php"><i class="fa-solid fa-gear"></i><span>Тохиргоо</span></a></li>
<li class="bottom-of-list"><a href="signout
.php"><i class="fa-solid fa-sign-out-alt"></i><span>Гарах</span></a></li>
</ul>
</div>
<div class="dashboard-container">
<div class="container">
<h1>Тохиргоо</h1>
<form method="get" action="">
<input type="text" name="q" placeholder="Хайх" value="<?php if(isset($_GET['q'])) echo $_GET['q'] ?>">
<style>
    .print-button {
      background: none;
      border: none;
      cursor: pointer;
      font-size: 20px;
      color: #0C46A6;
      display: flex;
      align-items: center;
    }
    
    .print-button i {
      margin-right: 5px;
    }
  </style>
</form>
</div>
    <?php
        // check for success or error message in URL query string
        if(isset($_GET['success'])) {
            echo "<p style='color: green'>Нууц үг амжилттай өөрчлөгдсөн</p>";
        } elseif(isset($_GET['error'])) {
            echo "<p style='color: red'>" . $_GET['error'] . "</p>";
        }
    ?>
    <div class="main">
    <form method="POST" action="update_settings.php" enctype="multipart/form-data" class="settings-form">
        
        <label for="new_password">Нууц үг солих</label>
        <input type="password" name="new_password">
        <label for="confirm_password">Нууц үг давтах</label>
        <input type="password" name="confirm_password">
        <input type="submit" value="Хадгалах">
    </form>
    </div>
    <?php
        // display user's current avatar if available
        $conn = mysqli_connect("localhost", "root", "", "new");
        $result = mysqli_query($conn, "SELECT avatar, school FROM users WHERE username='$username'");
        $row = mysqli_fetch_assoc($result);
        if($row['avatar']) {
            $avatar_path = "avatars/" . $row['avatar'];
            echo "<img src='$avatar_path' alt='User Avatar' width='100' height='100'>";
        }
        mysqli_close($conn);
    ?>
</body>
</html>