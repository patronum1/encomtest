<?php
// connect to the database
$conn = mysqli_connect("localhost", "root", "", "new");

// check connection
if (!$conn) {
    die("Aldaa! " . mysqli_connect_error());
}
?>
