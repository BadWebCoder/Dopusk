<?php include('connect.php'); // подключаем БД 
      session_start(); // запуск сессии
      $mysqli = 'SELECT * FROM consoles'; // запрос данных консолей
      $query = mysqli_query($link, $mysqli); // выполнение запроса
      $res = mysqli_fetch_all($query, MYSQLI_ASSOC); // занесение результата в массив
      
      $id = $_GET['game']; // id игры
      $sql_game = "SELECT id_game, name_game, dev, publisher, year, 
      (SELECT genre FROM genres WHERE genres.id_genre = games.id_genre) AS genre, cov_art, info FROM `games` WHERE id_game = $id;"; // запрос на данные игры
      $query_game = mysqli_query($link, $sql_game); // выполнение запроса
      $res_game = mysqli_fetch_assoc($query_game); // занесение результата в массив

      $sql_plat = "SELECT (SELECT name_console FROM consoles WHERE consoles.id_console = platforms_for_game.id_platform) AS platforms 
      FROM platforms_for_game WHERE id_game = $id;"; // запрос на консоли для игры
      $query_plat = mysqli_query($link, $sql_plat); // выполнение запроса
      $res_plat = mysqli_fetch_all($query_plat, MYSQLI_ASSOC); // занесение результата в массив

      $sql_sel_scr = mysqli_query($link, "SELECT * FROM gallery WHERE id_game = $id"); // выборка скриншотов
      $scr_res = mysqli_fetch_all($sql_sel_scr, MYSQLI_ASSOC); // занесение результата в массив

      if(isset($_POST['upload'])) // если добавил скриншот
      {
        $scr = $_FILES['image']['name']; // имя скриншота
        $tmp_scr = $_FILES['image']['tmp_name']; // временное хранение картинки
        if($tmp_scr != '') // если скриншот загружен
        {
          $serv = $_SERVER['DOCUMENT_ROOT'] . "/pics/screenshots/"; // путь корневой директории
          $sql_scr = mysqli_query($link, "INSERT INTO `gallery` (`id_pic`, `id_game`, `pic`) VALUES (NULL, '$id', 'pics/screenshots/$scr')"); // добавление картинки в БД
          move_uploaded_file($tmp_scr, $serv . $scr); // загрузка картинки  ?>
          <meta http-equiv="refresh" content="0;URL=page_of_game.php?game=<?php echo $id  // перекидывает на страницу  игры?>">
        <?php  
        }
      }

      if(isset($_POST['del-scr'])) // удаление скриншотов
      {
        $id_del = $_POST['del-scr']; // id скриншота
        $sql_del_scr = mysqli_query($link, "SELECT pic FROM gallery WHERE id_pic = $id_del"); // запрос на выбор изображения
        $del_scr_res = mysqli_fetch_assoc($sql_del_scr); // занесение полученного скиншота в массив
        $track = $_SERVER['DOCUMENT_ROOT'] . "/" . $del_scr_res["pic"]; // путь к скриншоту
        $unlink = unlink($track); // удаление скриншота
        $sql_del = mysqli_query($link, "DELETE FROM gallery WHERE id_pic = $id_del"); // выполнение на удаление скриншота из БД ?>
          <meta http-equiv="refresh" content="0;URL=page_of_game.php?game=<?php echo $id  // перекидывает на страницу  игры?>">
<?php } 
      
      if(isset($_POST['change'])) // редактирование текста
      {
        $txt = trim($_POST['chgtxt']); // текст
        if ($txt != ''){ // если текст не пустой
        mysqli_query($link, "UPDATE `games` SET `info` = '$txt' WHERE `games`.`id_game` = $id;");} // добавляется на страницу ?>
        <meta http-equiv="refresh" content="0;URL=page_of_game.php?game=<?php echo $id  // перекидывает на страницу  игры?>">
<?php }
 mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $res_game['name_game'] ?></title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
    <link rel="stylesheet" href="CSS/modal.css"> <!-- Стили модальных окон -->
    <link rel="stylesheet" href="../scripts/lightbox2-2.11.3/dist/css/lightbox.min.css">
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
            <?php foreach($res as $result){  // список консолей?>
              <li> <a href="games_for_console.php?sel=<?php echo $result['id_console'] ?>"> <?php echo $result['name_console']?>  </a> </li>
            <?php } ?>
            </ul>
         </div>
      </aside>
      <!-- блок с консолями -->

      <main class="main-game">
        <div>
           <h1 class="console_game"> <?php echo $res_game['name_game'] ?> </h1> <hr> 
            
           <!-- Таблица -->
           <form method="POST">
         <div class="prim_info">  
           <div class="table">
              <div class="cover_name"> <h3> <?php echo $res_game['name_game'] ?> </h3> </div>
              <div class="cover_art"> <img src="<?php echo $res_game['cov_art'] ?>"> </div>
              <div class="cover_text">  
                 <div> <h3> Разработчик </h3> <div class="text_name"> <a><?php echo $res_game['dev'] ?></a> </div> </div>
                 <div> <h3> Издатель </h3> <div class="text_name"> <?php echo $res_game['publisher'] ?> </div> </div>
                 <div> <h3> Год выпуска </h3> <div class="text_name"> <?php echo $res_game['year'] ?> </div> </div>
                 <div> <h3> Жанр </h3> <div class="text_name"> <?php echo $res_game['genre'] ?> </div> </div>
                 <div> <h3> Платформа(ы) </h3> <div class="text_name">
                                               <ul>
                                               <?php foreach($res_plat as $platform ){ ?>
                                                 <li> <?php echo $platform['platforms'] ?> </li> 
                                               <?php } ?>
                                               </ul>
                                            </div> 
                  </div>
                  <?php if($_SESSION['login']) { ?>
                   <div> <a id="add-info" href="change_page.php?chng=<?php echo $id ?>"> Редактировать </a> </div>
                  <?php } //добавление кнопки редактирования данных таблицы, если вошел админ ?>
              </div>
           </div>
            <!-- Таблица -->

            <!-- Описание -->
            
            <div id=eDiv2 contentEditable=false>
              <?php echo $res_game['info'] ?>
              <?php if($_SESSION['login']){ ?>
              <h1> Редактирование<img width="32px" height="32px" src="/pics/question.png" title="Теги для текста:
<p> </p> - абзац
<b> </b> - жирный шрифт
<i> </i> - шрифт курсивом"></h1> 
              <textarea name="chgtxt" placeholder="Поле можно растягивать"><?php echo $res_game['info'] ?></textarea>
              <?php } ?>
            </div>
         </div>
             <?php if($_SESSION['login']) echo '<button name="change">Сохранить изменения</button>'; 
             // кнопка сохранения данных, если вошел админ ?>
            </form>
            <!-- Описание -->

             <!-- Галерея -->
            <h2> Галерея </h2>  <hr>
            <?php if($_SESSION['login'])
            echo '<a class="add_screen" href="#add"> Добавить скриншотов </a>';
            // добавление новых скриншотов?>
            <div>
            <form id="gallery" method="POST">
              <?php foreach($scr_res as $screens){ ?>
                <div class="pic-game">
                    <div> <a class="example-image-link" href="<?php echo $screens['pic'] ?>" data-lightbox="example-set" data-title="Нажимайте на правую сторону изображения, чтобы переключится на следующее изображение."><img class="example-image" src="<?php echo $screens['pic'] ?>" alt=""/></a></div>
                   <?php if($_SESSION['login']){ ?> 
                   <button name="del-scr" value="<?php echo $screens['id_pic'] ?>"> Удалить </button> 
                   <?php } // кнопка удаления скриншотов, если вошел админ ?>
                </div>
              <?php } ?>
            </form>
            <!-- Галерея -->
        </div>
      </main>
   </div>

<!-- Модальное окно добавления скриншотов -->
<?php if($_SESSION['login']){ // появляется, если вошел админ ?>
<div class="delete_window" id="add">
  <div class="figure">
    <h1><a class="close1" href="#">×</a></h1>
  <h1 class="question">Добавить скриншот</h1>
    <form class="form1" enctype="multipart/form-data" method="POST">
      <input type="file" name="image">
      <input type="submit" name="upload" value="Добавить">
    </form>
  </div>
</div>
<?php } ?>
<!-- Модальное окно скриншотов -->

<!-- Подвал сайта -->
   <footer>
    <p> Сайт сделан специально для производственной практики. </p>
    <p> Материал брался из интернет-ресурсов </p>
</footer>
<!-- Подвал сайта -->
    </div>
    <script src="../scripts/lightbox2-2.11.3/dist/js/lightbox-plus-jquery.min.js"></script>
</body>
</html>