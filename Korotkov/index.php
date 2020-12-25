<?php session_start(); // запуск сессии
      include('connect.php'); // подключаем БД 
      $mysqli = 'SELECT * FROM consoles';
      $query = mysqli_query($link, $mysqli);
      $res = mysqli_fetch_all($query, MYSQLI_ASSOC);
      mysqli_close($link);
      ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
</head>
<body>
  <div id="page">
   <!-- шапка сайта -->
    <header>
         <nav>
          <div class="logo"> <a href="index.php"> <img src="pics/logo.png"> </a> </div>
          <div> 
            <form action="search_games.php">
              <input class="search" type="text" placeholder="Найти игру">
            <a href="autorisation.php" class="autorisation"> <?php if($_SESSION['login'] or $_COOKIE['login']) echo 'Выйти'; 
                                                                else echo 'Войти'; ?> </a>
            </form>
          </div>    
         </nav>
    </header>
   <!-- шапка сайта -->

    <div class="flexes">
      <main class="menu">
         <!-- Вступление -->
          <div class="info">
          <h1> Добро пожаловать<?php if($_SESSION['login']) echo ", Администратор, "; // если зашел админ
                                  else if(isset($_COOKIE['login'])) echo ", ".$_COOKIE['nick'].", "; // если зашел другой юзер ?> 
                                  в скромный каталог игр. </h1>
          <?php if($_SESSION['login']) echo '<h3> Здесь вы можете редактировать сайт, добавляя новое и удаляя лишнее </h3>';
          else echo '<h3> Здесь вы сможете посмотреть игры на консоли. </h3>' ?>
          <p> Выберите консоль, игры которой вы хотите посмотреть. </p>
          </div>
          <!-- Вступление -->

          <!-- Консоли -->
          <div id="consoles">
            <?php  foreach($res as $result){  // вывод консолей?>
            <div class="console">
             <div class="game-info">
                <div class="image"><a href="games_for_console.php?sel=<?php echo $result['id_console'] ?>"> <img src="pics/consoles/<?php echo $result['pic'] ?>.png"> </a> </div>
                <div class="console-name"><a href="games_for_console.php?sel=<?php echo $result['id_console'] ?>"> <p> <?php echo $result['name_console'] ?> </p> </a></div>
             </div>
            </div>            
            <?php } ?>
          </div>
          <!-- Консоли -->
        
      </main>
    </div>
    <!-- Подвал Сайта -->
    <footer>
        <p> Сайт сделан специально для производственной практики. </p>
        <p> Материал брался из интернет-ресурсов </p>
    </footer>
    <!-- Подвал Сайта -->
    <div id="page">
</body>
</html>