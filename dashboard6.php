<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("location: index.php");
    exit();
}

$username = $_SESSION['username'];
$school = $_SESSION['school'];

// connect to the database
$conn = mysqli_connect("localhost", "root", "", "new");

// check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// get search query, if any

// Define the number of question6 per page
$question6_per_page = 12;

// Get the current page number
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the LIMIT clause in the SQL query
$offset = ($current_page - 1) * $question6_per_page;

// Modify the SQL query to include the LIMIT clause
if(isset($_GET['q'])) {
    $search = $_GET['q'];
    $result = mysqli_query($conn, "SELECT question6.id, question6.question, user_answers.answer FROM question6 LEFT JOIN user_answers ON question6.id=user_answers.question_id WHERE question LIKE '%$search%' LIMIT $offset, $question6_per_page");
} else {
    $result = mysqli_query($conn, "SELECT question6.id, question6.question, user_answers.answer FROM question6 LEFT JOIN user_answers ON question6.id=user_answers.question_id LIMIT $offset, $question6_per_page");
}
// Count the total number of question6 in the database
$count_query = mysqli_query($conn, "SELECT COUNT(*) as total_question6 FROM question6");
$count_result = mysqli_fetch_assoc($count_query);
$total_question6 = $count_result['total_question6'];

// Calculate the total number of pages
$total_pages = ceil($total_question6 / $question6_per_page);


if(!$result) {
    die("Error: " . mysqli_error($conn));
}

// get the user's ID from the database
$user_id_query = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
if(!$user_id_query) {
    die("Error: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($user_id_query);
$user_id = $row['id'] ?? null;

// handle form submission
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get the question ID and user's answer from the form data
    $question_id = $_POST['question_id'];
    $answer = $_POST['answer'];

    // check if the user has already answered this question
    $previous_answer_query = mysqli_query($conn, "SELECT id, answer FROM user_answers WHERE user_id='$user_id' AND question_id='$question_id'");
    if(!$previous_answer_query) {
        die("Error: " . mysqli_error($conn));
    }
    $previous_answer_row = mysqli_fetch_assoc($previous_answer_query) ?? null;

    if($previous_answer_row) {
        // update the previous answer in the database
        $previous_answer_id = $previous_answer_row['id'];
        $update_query = mysqli_query($conn, "UPDATE user_answers SET answer='$answer' WHERE id='$previous_answer_id'");
        if(!$update_query) {
            die("Error: " . mysqli_error($conn));
        }
    } else {
        // insert the answer into the database
        $insert_query =
        mysqli_query($conn, "INSERT INTO user_answers (user_id, question_id, answer) VALUES ('$user_id', '$question_id', '$answer')");
        if(!$insert_query) {
        die("Error: " . mysqli_error($conn));
        }
        }// reload the current URL
header("Location: ".$_SERVER['REQUEST_URI']);
exit();
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=0.5">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="https://kit.fontawesome.com/1f6b8b9096.js" crossorigin="anonymous"></script>
    <style>
        /* Add styles for the popup window */
        .pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 20px 0;

}

.pagination a {
  color: #2b4399;
  text-decoration: none;
  margin: 0 4px;
  border-radius: 50%; 
  width: 24px;
  height: 24px; 
  line-height: 24px;
  text-align: center; 
  display: inline-block; 
  transition: background-color 0.3s ease;
}


.pagination a:hover {
  background-color: #40444b;
  color: #fff;
}

.pagination a.active {
  background-color: #2b4399;
  color: #fff;
}
        .popup {
  display: none;
  position: fixed;
  z-index: 9999;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.popup-content {
  background-color: #fff;
  border-radius: 20px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  max-width: 500px;
}

.popup-content p {
  font-size: 20px;
  margin: 0 0 20px 0;
}

.popup-content label {
  display: block;
  font-size: 16px;
  margin-bottom: 10px;
}

.popup-content input[type="number"] {
  border: 2px solid #ddd;
  border-radius: 4px;
  padding: 8px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 20px;
}

.popup-content button {
  background-color: #FFFFFF;
  color: #548EEE; 
  border: none;
  border-radius: 10px;
  padding: 18px 18px;
  font-size: 20px;
  cursor: pointer;;
  margin-bottom: 12px;
}

.popup-content button:hover {
  color: #5479EE;
}

    </style>
    <script>
        // JavaScript function to display the popup window
        function showPopup(id) {
            var popup = document.getElementById(id);
            popup.style.display = "block";
        }
    </script>
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
<h1>Оюутан</h1>
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
<style>
<style>
.answer-icon {
  background-color: #fff;
  color: #007bff;
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  font-size: 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
  transition: background-color 0.3s ease;
}

.answer-icon {
  position: absolute;
  bottom: 5px;
  right: 10px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 30%;
  width: 30px;
  height: 30px;
  font-size: 15px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  margin-right: 10px;
  transition: background-color 0.3s ease;
}

.answer-icon:hover {
  background-color: #0062cc;
  color: #fff;
}

</style>

<div class="question">
  <ul>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
      <li>
        <div class="question-box">
          <?php 
            $question = $row['question'];
            if (strlen($question) > 80) {
              $question = substr($question, 0, 80) . "...";
            }
            echo $question; 
          ?>
          <?php if (isset($row['answer'])): ?>
    <br> <?php echo rtrim(number_format($row['answer'], 2), ".0"); ?>
<?php endif; ?>
          <button class="answer-icon" onclick="showPopup('popup-<?php echo $row['id'] ?>')"><i class="fas fa-pencil-alt"></i></button>
        </div>
        <div id="popup-<?php echo $row['id'] ?>" class="popup">
          <!-- Add the answer form within the popup window -->
          <div class="popup-content">
            <p><?php echo $row['question'] ?></p>
            <form method="post">
              <input type="hidden" name="question_id" value="<?php echo $row['id'] ?>">
              <label for="answer"></label>
              <input type="number" step="any" name="answer" required>
              <button type="submit"><i class="fa-solid fa-floppy-disk"></i></i></button>
              <button type="button" onclick="document.getElementById('popup-<?php echo $row['id'] ?>').style.display='none'"><i class="fa-solid fa-circle-xmark"></i></i></button>
            </form>
          </div>
        </div>
      </li>
    <?php endwhile; ?>
  </ul>
</div>
<div class="pagination">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i ?>" class="<?php echo $i == $current_page ? 'active' : '' ?>"><?php echo $i ?></a>
    <?php endfor; ?>
</div>

          </body>
          </html>
