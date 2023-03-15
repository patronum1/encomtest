<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $school = $_POST['school'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // connect to the database
    $conn = mysqli_connect("localhost", "root", "", "new");
    
    // check if user exists
    $result = mysqli_query($conn, "SELECT * FROM users WHERE school='$school' AND username='$username'");
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // check if provided password matches the stored hashed password
        if(password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['school'] = $school;
            header("location: dashboard.php");
        } else {
            // check if provided password matches the stored unhashed password
            if($password == $user['password']) {
                $_SESSION['username'] = $username;
                $_SESSION['school'] = $school;
                header("location: dashboard.php");
            } else {
                echo '<script>alert("Invalid username or password");</script>';
            }
        }
    } else {
        echo '<script>alert("Invalid username or password");</script>';
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=0.8">
    <link rel="stylesheet" href="login.css">
  </head>
  <body>
    <div class="container">
      <form method="POST" action="index.php" class="form-container">
        <div class="image-container">
        <img src="https://cdn-icons-png.flaticon.com/512/1903/1903162.png" alt="Login Image">
        </div>
        <div>
        <div class="container-1">
          <h2>Нэвтрэх</h2>
          <label for="school">Сургууль сонгох:</label>
    <select name="school">
    <option disabled selected></option>
    <option value="АШУҮИС /Анагаахын шинжлэх ухааны үндэсний их сургууль/">АШУҮИС /Анагаахын шинжлэх ухааны үндэсний их сургууль/</option>
<option value="Аварга дээд сургууль">Аварга дээд сургууль	</option>
<option value="Ач анагаах ухааны их сургууль	">Ач анагаах ухааны их сургууль</option>
<option value="Боловсрол соёл эрх зүйн дээд сургууль	">Боловсрол соёл эрх зүйн дээд сургууль</option>
<option value="Бурхан шашны дээд сургууль">Бурхан шашны дээд сургууль</option>
<option value="Глобал удирдагч их сургууль">Глобал удирдагч их сургууль</option>
<option value="Г.В Плехановын нэрэмжит Оросын Эдийн засгийн их сургуулийн Улаанбаатр хотын салбар сургууль">Г.В Плехановын нэрэмжит Оросын Эдийн засгийн их сургуулийн Улаанбаатр хотын салбар сургууль</option>
<option value="ДХИС /Дотоод хэргийн их сургууль/">ДХИС /Дотоод хэргийн их сургууль/</option>
<option value="Дархан дээд сургууль">Дархан дээд сургууль</option>
<option value="ИЗОУИС /Их засаг олон улсын их сургууль/	">ИЗОУИС /Их засаг олон улсын их сургууль/</option>
<option value="ИЗОУИС-ийн харьяа Дүрслэх урлаг, дизайн, технологийн дээд сургууль">ИЗОУИС-ийн харьяа Дүрслэх урлаг, дизайн, технологийн дээд сургууль</option>
<option value="Идэр их сургууль	">Идэр их сургууль</option>
<option value="Кино урлагийн дээд сургууль">Кино урлагийн дээд сургууль</option>
<option value="МУБИС /Монгол улсын боловсролын их сургууль/">МУБИС /Монгол улсын боловсролын их сургууль/</option>
<option value="МУИС /Монгол улсын их сургууль/">МУИС /Монгол улсын их сургууль/</option>
<option value="Мандах их сургууль">Мандах их сургууль</option>
<option value="Мон-Алтиус дээд сургууль">Мон-Алтиус дээд сургууль</option>
<option value="Монгол Улсын Эрдмийн их сургууль">Монгол Улсын Эрдмийн их сургууль</option>
<option value="Монгол улсын консерватори">Монгол улсын консерватори</option>
<option value="Монгол улсын консерваторийн харьяа Завхан аймаг дахь хөгжим бүжгийн коллеж">Монгол улсын консерваторийн харьяа Завхан аймаг дахь хөгжим бүжгийн коллеж</option>
<option value="Монгол-Германы хамтарсан Ашигт малтмал, технологийн их сургууль">Монгол-Германы хамтарсан Ашигт малтмал, технологийн их сургууль</option>
<option value="МҮИС /Монголын үндэсний их сургууль/">МҮИС /Монголын үндэсний их сургууль/</option>
<option value="Нийгэм сэтгэл судлалын дээд сургууль">Нийгэм сэтгэл судлалын дээд сургууль</option>
<option value="Олон улс судлалын дээд сургууль">Олон улс судлалын дээд сургууль</option>
<option value="Олон улсын Улаанбаатарын их сургууль">Олон улсын Улаанбаатарын их сургууль</option>
<option value="Олон улсын эдийн засаг, бизнесийн их сургууль">Олон улсын эдийн засаг, бизнесийн их сургууль</option>
<option value="Орхон их сургууль">Орхон их сургууль</option>
<option value="Отгонтэнгэр их сургууль">Отгонтэнгэр их сургууль</option>
<option value="Оточ манрамба их сургууль">Оточ манрамба их сургууль</option>
<option value="Рояаль олон улсын их сургууль">Рояаль олон улсын их сургууль</option>
<option value="СУИС /Соёл урлагийн их сургууль/">СУИС /Соёл урлагийн их сургууль/</option>
<option value="Сан их сургууль">Сан их сургууль</option>
<option value="Санхүү бизнесийн дээд сургууль">Санхүү бизнесийн дээд сургууль</option>
<option value="Санхүү, эдийн засгийн их сургууль/Гурван-Эрдэнэ багшийн дээд сургууль, Тэнгэр дээд сургууль/">Санхүү, эдийн засгийн их сургууль/Гурван-Эрдэнэ багшийн дээд сургууль, Тэнгэр дээд сургууль/</option>
<option value="Сити их сургууль">Сити их сургууль</option>
<option value="Соёл-Эрдэм дээд сургууль">Соёл-Эрдэм дээд сургууль</option>
<option value="Техник, технологийн дээд сургууль">Техник, технологийн дээд сургууль</option>
<option value="Технологийн дээд сургууль">Технологийн дээд сургууль</option>
<option value="Төмөр замын дээд сургууль">Төмөр замын дээд сургууль</option>
<option value="Удирдлагын академи">Удирдлагын академи</option>
<option value="Улаанбаатар эрдэм их сургууль">Улаанбаатар эрдэм их сургууль</option>
<option value="Урлах эрдмийн дээд сургууль">Урлах эрдмийн дээд сургууль</option>
<option value="ХААИС /Хөдөө аж ахуйн их сургууль/">ХААИС /Хөдөө аж ахуйн их сургууль/</option>
<option value="ХНХДС /Хөдөлмөр, нийгмийн харилцааны дээд сургууль/">ХНХДС /Хөдөлмөр, нийгмийн харилцааны дээд сургууль/</option>
<option value="ХУИС /Хүмүүнлэгийн ухааны их сургууль/">ХУИС /Хүмүүнлэгийн ухааны их сургууль/</option>
<option value="Хангай дээд сургууль">Хангай дээд сургууль</option>
<option value="Хятад-Монголын хамтарсан олон улсын дээд сургууль">Хятад-Монголын хамтарсан олон улсын дээд сургууль</option>
<option value="Хүмүүнлэгийн ухааны их сургуулийн харьяа Билиг дээд сургууль">Хүмүүнлэгийн ухааны их сургуулийн харьяа Билиг дээд сургууль</option>
<option value="Хүмүүнлэгийн ухааны их сургуулийн харьяа Хүмүүнлэгийн дээд сургууль">Хүмүүнлэгийн ухааны их сургуулийн харьяа Хүмүүнлэгийн дээд сургууль</option>
<option value="Хүрээ мэдээлэл холбоо, технологийн дээд сургууль">Хүрээ мэдээлэл холбоо, технологийн дээд сургууль</option>
<option value="ШУТИС /Шинжлэх ухаан технологийн их сургууль/">ШУТИС /Шинжлэх ухаан технологийн их сургууль/</option>
<option value="ШУТИС-ийн харьяа /Эрдэнэт цогцолбор/ дээд сургууль">ШУТИС-ийн харьяа /Эрдэнэт цогцолбор/ дээд сургууль</option>
<option value="ШУТИС-ийн харьяа Өмнөговь аймаг дахь /технологийн/ дээд сургууль">ШУТИС-ийн харьяа Өмнөговь аймаг дахь /технологийн/ дээд сургууль</option>
<option value="Шинэ анагаах ухаан их сургууль">Шинэ анагаах ухаан их сургууль</option>
<option value="Шихихутуг их сургууль">Шихихутуг их сургууль</option>
<option value="Эдийн засгийн үндэсний дээд сургууль">Эдийн засгийн үндэсний дээд сургууль</option>
<option value="Эм Ай Ю дээд сургууль">Эм Ай Ю дээд сургууль</option>
<option value="Эм Зүйн Шинжлэх Ухааны Их Сургууль">Эм Зүйн Шинжлэх Ухааны Их Сургууль</option>
<option value="Энэрэл дээд сургууль">Энэрэл дээд сургууль</option>
<option value="Этүгэн их сургууль">Этүгэн их сургууль</option>
<option value="ҮБХИС /Үндэсний батлан хамгаалахын их сургууль/">ҮБХИС /Үндэсний батлан хамгаалахын их сургууль/</option>
<option value="Үндэсний биеийн тамирын дээд сургууль">Үндэсний биеийн тамирын дээд сургууль</option>
<option value="Үндэсний техникийн их сургууль">Үндэсний техникийн их сургууль</option>
<option value="Үндэсний тагнуулын академи">Үндэсний тагнуулын академи</option>

        
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