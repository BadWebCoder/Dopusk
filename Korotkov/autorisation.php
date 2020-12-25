<?php session_start(); // запуск сессии

if($_SESSION['login']) // если выходит админ
{
    unset($_SESSION['login']);
    unset($_SESSION['nick']);
    session_destroy();    // стирает сессии
}
else if($_COOKIE['login']) // если вышел пользователь
{
 setcookie("login","", time()-(3600*24));
 setcookie("nick","", time()-(3600*24));
} 

   if(isset($_POST['aut']))
   {
    $i = 1;
    include('connect.php'); // подключаем БД 
    $log = $_POST['login']; // логин
    $pass = $_POST['password']; // пароль
    $sql = "SELECT * FROM users WHERE login = '$log';"; // запрос на данные пользователя
    $res = mysqli_query($link, $sql); // выполнение запроса
    $res_tab = mysqli_fetch_assoc($res); // заносение данных в массив

    if (password_verify($pass, $res_tab['password'])) // Если данные существуют
    { 
      if($res_tab['root'] == 1) // если заходит админ
      {
        $_SESSION['nick'] = $res_tab['nickname'];
        $_SESSION['login'] = $log; // его данные хранятся в сессии
      }
      else // иначе если пользователь
      { // его данные заносятся в куки
      setcookie("nick", $res_tab['nickname'], time()+(3600*24)); // куки ника
      setcookie("login", $log, time()+(3600*24)); // куки пароля 
      } ?>
      <meta http-equiv="refresh" content="0;URL=index.php"> <?php // переход на главную
    }
    else $err = "Введён неправильный логин или пароль"; // иначе данные неверные
   }
   mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
</head>
<body>
    <div id="autoris">
      <div class="aut_content">
        <h1> Авторизация </h1>
        <?php
          if($i == 1){
           if($err) // если есть ошибки при авторизации
           {
            print "<ul>";
                print "<li>" . $err . "</li>"."<br>"; // вывод ошибок
            print "</ul>";
           }
          }
           ?>
        <div>
            <form method="POST">
            <input type='text' name="login" placeholder="Введите логин"> <br>
            <input type='password' name="password" placeholder="Введите пароль"> <br>
            <input type="submit" name="aut" value="Войти">    
            </form>  
        </div>
        <p> Еще не зарегестрированы? <a href="registration.php">Исправьте это!</a> </p>
        <p> <a href="index.php"> Вернутся на сайт </a> </p>
      </div>
    </div>
</body>
</html>