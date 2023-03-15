<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // check if a file was uploaded
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        // check if the uploaded file is an image file
        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $extension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        if (in_array($extension, $allowed_extensions)) {
            // generate a unique file name
            $file_name = uniqid() . '.' . $extension;
            $file_path = 'avatars/' . $file_name;
            // move the uploaded file to the avatars folder
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $file_path)) {
                // update the avatar column in the users table
                $conn = mysqli_connect('localhost', 'root', '', 'new');
                $user_id = $_SESSION['user_id'];
                $sql = "UPDATE users SET avatar = '$file_name' WHERE id = $user_id";
                mysqli_query($conn, $sql);
                mysqli_close($conn);
                // redirect back to the settings page
                header('Location: settings.php');
                exit();
            }
        }
    }
}

// if the script reaches this point, something went wrong with the file upload
echo 'Failed to upload file';
?>
