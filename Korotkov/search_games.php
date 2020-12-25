<?php include('connect.php'); // подключаем БД 
      session_start(); // запуск сессии 
      $mysqli = 'SELECT * FROM consoles';
      $query = mysqli_query($link, $mysqli);
      $res = mysqli_fetch_all($query, MYSQLI_ASSOC);
      
      $sel = $_POST['srch']; // хранится поиск
      if(isset($_POST['srch']))
      {
         $id = trim($_POST['srch']); // поиск
         if (strlen($id) > 0) // если поисковой запрос не пустой
         {
           $games = "SELECT id_game, name_game, cov_art, 
           (SELECT (SELECT name_console FROM consoles WHERE consoles.id_console = platforms_for_game.id_platform) 
           FROM platforms_for_game WHERE platforms_for_game.id_game = games.id_game LIMIT 1) AS platform 
           FROM `games` WHERE name_game LIKE '%$id%' ORDER BY name_game"; // запрос поиска
           $query_games = mysqli_query($link, $games);  // выполнение поиска
           $res_games = mysqli_fetch_all($query_games, MYSQLI_ASSOC); // занесение результата поиска в массив
           $err = "'$id'"; 
           if(count($res_games) < 1) $err = "'$id' ничего не "; // если ничего не нашло, выведет что ничего не нашло
         }
         else $err = " ничего не "; // иначе выведет что ничего не нашло
      }
mysqli_close($link);
       ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск</title>
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
        <h1> По запросу <?php echo $err ?> найдено </h1>
        <div id="games">
          <?php if (strlen($id) > 0) foreach($res_games as $game){ ?>
            <div class="game">
              <div class="game-info">
                <div class="image-game"><a href="page_of_game.php?game=<?php echo $game['id_game'] ?>"> <img class="search-res" src="<?php echo $game['cov_art'] ?>"> </a> </div>
                <div class="game-name"><a href="page_of_game.php?game=<?php echo $game['id_game'] ?>"> <p> <?php echo $game['name_game'] ?> </p> </a></div>
             </div>
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
</body>
</html>