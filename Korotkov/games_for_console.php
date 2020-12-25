<?php include('connect.php'); // подключаем БД 
      session_start(); // запуск сессии 
      $mysqli = 'SELECT * FROM consoles';
      $query = mysqli_query($link, $mysqli);
      $res = mysqli_fetch_all($query, MYSQLI_ASSOC);
      
      $sel = $_GET['sel']; // хранится id консоли
      $cat = mysqli_query($link, "SELECT id_console, name_console FROM `consoles` WHERE id_console = $sel"); 
      $cat_res = mysqli_fetch_assoc($cat);
      if(isset($_GET['sel']))
      {
         $id = $_GET['sel']; // id выбранной консоли
         $games = "SELECT id_game, (SELECT name_game FROM games WHERE games.id_game = platforms_for_game.id_game) AS name_game,
         (SELECT name_console FROM consoles WHERE consoles.id_console = platforms_for_game.id_platform) AS platform,
         (SELECT cov_art FROM games WHERE games.id_game = platforms_for_game.id_game) AS pic FROM platforms_for_game WHERE id_platform = $id ORDER BY name_game";
         // запрос на выбор игр для консоли в алфавитном порядке
         $query_games = mysqli_query($link, $games); // выполнение запроса на выбранные игры
         $res_games = mysqli_fetch_all($query_games, MYSQLI_ASSOC); // занесение выбранных игр в массив
         $not_symbols = ["/", " "];
      }

      if(isset($_POST['del'])) // удаление игры
      {
         $id_del = $_POST['del']; // id игры
         $query_cov = mysqli_query($link, "SELECT `cov_art` FROM `games` WHERE `id_game` = $id_del"); // получение обложки игры
         $res_cov = mysqli_fetch_assoc($query_cov); // занесение обложки в массив
         $track = $_SERVER['DOCUMENT_ROOT'] . "/" . $res_cov["cov_art"]; // путь к обложке
         if($res_cov['cov_art'] != "pics/coverarts/nocover.png") unlink($track); // удаление обложки
         $query_screens = mysqli_query($link, "SELECT id_pic, pic FROM gallery WHERE id_game = $id_del"); // выбор всех скриншотов игры
         $res_screens = mysqli_fetch_all($query_screens, MYSQLI_ASSOC); // занесение их в массив
         foreach($res_screens as $screens)  // удаление всех скриншотов из сервера через цикл
         {
            $track2 = $_SERVER['DOCUMENT_ROOT'] . "/" . $screens["pic"]; // путь к скриншоту
            $id_scr = $screens['id_pic'];
            unlink($track2);
            mysqli_query($link, "DELETE FROM gallery WHERE id_pic = $id_scr");
         }
         mysqli_query($link, "DELETE FROM `games` WHERE `games`.`id_game` =  $id_del"); // выполнение запроса на удаление игры ?>

         <meta http-equiv="refresh" content="0;URL=games_for_console.php?sel=<?php echo $sel ?>">
         <?php
      }
      mysqli_close($link);
       ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игра</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
    <link rel="stylesheet" href="CSS/modal.css"> <!-- Стили модальных окон -->
</head>
<body>
    <div id="page">
    <!-- шапка сайта -->
    <header>
        <nav>
         <div class="logo"> <a href="index.php"> <img src="pics/logo.png"> </a> </div>
         <div> 
          <form method="POST" action="search_games.php">
            <input class="search" name="srch" type="search" placeholder="Найти игру">
            <a href="autorisation.php" class="autorisation"> <?php if($_SESSION['login'] or $_COOKIE['login']) echo 'Выйти'; 
                                                                   else echo 'Войти'; ?> </a>
          </form>
         </div>    
        </nav>
   </header>
   <!-- шапка сайта -->

   <div class="flexes">
      <!-- блок с консолями -->
      <aside>
         <div class="consoles-block">
            <h2> Консоли </h2>
            <ul>
            <?php foreach($res as $result){ // список консолей ?>
               <li> <a href="games_for_console.php?sel=<?php echo $result['id_console'] ?>"> <?php echo $result['name_console']?>  </a> </li>
            <?php } ?>
            </ul>
         </div>
      </aside>
      <!-- блок с консолями -->

      <!-- Блок с играми -->
      <main class="main-games">
        <h1> Список игр <?php echo $cat_res['name_console']?></h1>
        <?php if($_SESSION['login']) echo '<p> <form action="create_page.php?kat="> <button> Добавить игру </button> </form> </p>'; 
          // добавляет кнопку добавления игр если вошел админ ?>
        <div id="games">
          <?php foreach($res_games as $game){ ?>
            <div class="game">
              <div class="game-info">
                <div class="image-game"><a href="page_of_game.php?game=<?php echo $game['id_game'] ?>"> <img class="<?php echo str_replace($not_symbols, "-", strtolower($game['platform'])) ?>" src="<?php echo $game['pic'] ?>"> </a> </div>
                <div class="game-name"><a href="page_of_game.php?game=<?php echo $game['id_game'] ?>"> <p> <?php echo $game['name_game'] ?> </p> </a></div>
             </div>
             <?php if($_SESSION['login']){ ?>
             <div class="delete-game"><a href="#delete<?php echo $game['id_game'] ?>"> <p> Удалить </p> </a></div>
             <?php }// добавляет кнопку удаления игры, если вошел админ ?>
             </div>  
          <?php } ?>
        </div>
      </main>
      <!-- Блок с играми -->
   </div>

<!-- Подвал сайта -->
   <footer>
    <p> Сайт сделан специально для производственной практики. </p>
    <p> Материал брался из интернет-ресурсов </p>
   </footer>
<!-- Подвал сайта -->

    </div>
    <!-- Модальное окно -->
<?php if($_SESSION['login']) { ?>
   <?php foreach($res_games as $game){ ?>
    <div class="delete_window" id="delete<?php echo $game['id_game'] ?>">
      <div class="figure">
      <h1>Хотите удалить игру?</h1>
        <form class="formm" action="" method="POST">
          <button class="delete" name="del" value="<?php echo $game['id_game'] ?>"> Да </button>
          <a class="closed" href=""> Нет </a>
        </form>
      </div>
    </div> <?php } }?>
    <!-- Модальное окно -->
</body>
</html>