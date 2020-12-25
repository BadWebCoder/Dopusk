<?php session_start();
$i = 0;
if(isset($_POST['reg']))
{
  $i = 1;
  include('connect.php'); // подключаем БД 
  $err = array(); // Хранилище ошибок
  $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/'; // для почты
  if(!preg_match("/^[\w]+$/",$_POST['login'])) $err[] = "Логин может состоять только из букв английского алфавита и цифр.";
  else if(strlen($_POST['login']) < 7 or strlen($_POST['login']) > 50) $err[] = "Логин должен быть не меньше 7 символов и не больше 50.";
  if(!preg_match('/^[\wа-яА-Я]+$/', $_POST['nick'])) {$err[] = "Ник не должен быть пуст, иметь пробелы и спецсимволы.";}
  else if (strlen($_POST['nick']) < 3) $err[] = "Никнейм должен быть не меньше 3 символов";
  if(!preg_match("#^[a-z0-9]+$#i",$_POST['password'])) $err[] = "Пароль должен состоять из латинских букв и цифр";
  else if (strlen($_POST['password']) < 8 or strlen($_POST['password']) > 50) $err[] = "Пароль должен быть не меньше 8 символов и не больше 50.";
  else if($_POST['password'] != $_POST['repassword']) $err[] = "Пароли не совпадают";
  if(!preg_match($regex, $_POST['mail'])) $err[] = "Неправильно написана почта";
  // фильтрация для ввода данных для регистрации

  $log = $_POST['login']; // логин
  $mysqli_sel = "SELECT login FROM users WHERE login='$log'"; // запрос
  $query= mysqli_query($link, $mysqli_sel); // выполнение запроса
  $res = mysqli_fetch_array($query); // внесение результата в массив
  if($res[0]) $err[] = "Введенный логин уже занят"; // проверка на похожий логин в аккаунте

  if(count($err) == 0) // если ошибок нет
  {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // хэширование пароля
    $nick = $_POST['nick']; // никнейм пользователя
    $mysqli_ins = "INSERT INTO users (login, password, nickname, root) VALUES ('$log', '$password', '$nick', 0)"; // запрос на добавление данных
    mysqli_query($link, $mysqli_ins); // выполнение запроса
    ?>  
    <meta http-equiv="refresh" content="0;URL=index.php">
    <?php 
  }
}
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
</head>
<body>
    <div id="registr">
      <div class="reg_content">
        <h1> Регистрация </h1>
        <?php
          if($i == 1){
           if(count($err) != 0) // если есть ошибки при регистрации
           {
            print "<b>При регистрации произошли следующие ошибки:</b><br>";
            print "<ul>";
            foreach($err as $error)
            {
                print "<li class='errors'>" . $error . "</li>"."<br>"; // вывод ошибок
            }
            print "</ul>";
           }
          }
           ?>
        <div>
            <form method="POST">
            <input type='text' name="login" placeholder="Введите логин" required> <br>
            <input type="text" name="nick" placeholder="Введите свой никнейм" required>
            <input type='password' name="password" placeholder="Введите пароль" required> <br>
            <input type='password' name="repassword" placeholder="Подтвердите пароль"> <br>
            <input type="submit" name="reg" value="Зарегистрироваться">    
            </form>  
        </div>
        <p class="reg_aut"> Уже зарегистрированны? <a href="autorisation.php">Тогда просто войдите</a> </p>
      </div>
    </div>
</body>
</html>





