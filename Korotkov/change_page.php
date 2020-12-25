<?php session_start(); // запуск сессии
   if(empty($_SESSION['login'])) header('Location: Index.php'); // если не авторизован как админ, не пускает сюда
   
   else // в другом случае пускает
   {
    include('connect.php'); // подключаем БД 
    $id = $_GET['chng'];
    $sql_game = "SELECT id_game, name_game, dev, publisher, year, 
    (SELECT genre FROM genres WHERE genres.id_genre = games.id_genre) AS genre, id_genre, cov_art, info FROM `games` WHERE id_game = $id;";
    $query_game = mysqli_query($link, $sql_game);
    $res_game = mysqli_fetch_assoc($query_game);

    $mysqli_genres = "SELECT * FROM genres"; // запрос жанров
    $query_gen = mysqli_query($link, $mysqli_genres); // выполнение запроса жанров
    $res_gen = mysqli_fetch_all($query_gen, MYSQLI_ASSOC); // занесение полученных жанров в массив
    $sel1 = $res_game['id_genre'];

    $sql_plat = "SELECT (SELECT name_console FROM consoles WHERE consoles.id_console = platforms_for_game.id_platform) AS platforms, 
    id_platform FROM platforms_for_game WHERE id_game = $id;"; // запрос на консоли для игры
    $query_plat = mysqli_query($link, $sql_plat); // выполнение запроса
    $res_plat = mysqli_fetch_all($query_plat, MYSQLI_ASSOC); // занесение результата в массив

    if(isset($_POST['result']))
    {
      $gameName = $_POST['game']; // название игры
      $dev = $_POST['dev']; // имя разработчика
      $pub = $_POST['pub']; // имя издателя
      $year = $_POST['year']; // год выхода
      $genre = $_POST['genre']; // жанр
      $plat = $_POST['platform']; // платформы, на которые игра выходила
      $pic = $_FILES['image']['name']; // название картинки
      $tmp_pic = $_FILES['image']['tmp_name']; // временное хранение картинки
      $nochg = $_POST['nochg']; // нынешняя обложка
      $serv = $_SERVER['DOCUMENT_ROOT'] . "/"; // путь корневой директории
      if(!$pic and $nochg) {$pic = $nochg;} // если новую пикчу не загрузили, то остается старая
      else $pic = "pics/coverarts/" . $_FILES['image']['name']; // иначе готовится к загрузке новая

      $sql_chg = "UPDATE `games` SET `name_game` = '$gameName', `dev` = '$dev',
      `publisher` = '$pub', `year` = '$year', `id_genre` = '$genre', `cov_art` = '$pic' WHERE `games`.`id_game` = $id;"; // запрос на изменение данных
       mysqli_query($link, "DELETE FROM `platforms_for_game` WHERE id_game = $id"); // удаление консолей из игры
       foreach ($plat as $index => $platforms)
       {
        mysqli_query($link, "INSERT INTO `platforms_for_game` VALUES ($id, $platforms)"); // добавление новых, заменяя старые
       }
      
      $query_chg = mysqli_query($link, $sql_chg); // выполнение запроса
      if($tmp_pic !='') move_uploaded_file($tmp_pic, $serv . $pic); // загрузка картинки ?>
         <meta http-equiv="refresh" content="0;URL=page_of_game.php?game=<?php echo $id  // перекидывает на страницу игры?>">
      <?php
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Изменить страницу</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
</head>
<body>
    <div id="registr">
      <div class="reg_content">
        <h1> Изменение страницы с игрой </h1>
        <div>
         <form method="POST" enctype="multipart/form-data">
          <p class="game_page"> Игра </p> <input type="text" name="game" value="<?php echo $res_game['name_game'] ?>" required> 
          <p> Разработчик </p> <input type='text' name="dev" value="<?php echo $res_game['dev'] ?>" required>
          <p> Издатель </p> <input type='text' name="pub" value="<?php echo $res_game['publisher'] ?>" required> 
          <p> Год выхода </p>
             <select id="year" name="year" required>
                <option value="<?php echo $res_game['year'] ?>"> <?php echo $res_game['year'] ?> </option>
             </select>     
         
             <p> Жанр </p>
                <select name="genre" required>
                  <option type="hidden" disabled selected ></option>
                  <?php foreach($res_gen as $genres){ ?>
                    <option value="<?php echo $genres['id_genre'] ?>" <?php if($sel1 == $genres['id_genre']){echo "selected";} ?>> <?php echo $genres['genre'] ?> </option>
                  <?php }?>
                </select>
          
          <p>Платформа </p>
          <a href="#" id="add" onclick="add()"> +Добавить список </a>
          <a href="#" id="del" onclick="del()"> -Удалить список </a>
          <div id="crt">
            <?php foreach ($res_plat as $platform){ 
              $query_cons = mysqli_query($link, 'SELECT id_console, name_console FROM consoles'); // выполнение запроса консолей
              $res_cons = mysqli_fetch_all($query_cons, MYSQLI_ASSOC); // занесение полученных консолей в массив ?>
            <select name="platform[]" class="selec" required>
                <option value="<?php echo $platform['id_platform'] ?>"> <?php echo $platform['platforms'] ?> </option>
                <?php foreach($res_cons as $console){ ?>
                  <option value="<?php echo $console['id_console'] ?>"> <?php echo $console['name_console'] ?> </option>
                <?php } ?>
             </select>
            <?php } ?>
          </div>           
          <p>Обложка игры</p> <a href="#" id="chgButton" onclick=coverAdd()> + Добавить обложку </a> <div id="addCov"> </div> <br>
           <input type="hidden" name="nochg" value="<?php echo $res_game['cov_art'] ?>">
          <input type="submit" value="Изменить страницу" name="result">    
         </form>  
        </div>
      </div>
    </div>
</body>
<script src="scripts/years.js"> </script>
<script src="scripts/addcover.js"> </script>
<script src="scripts/taggenerator.js"> </script>
</html>
 <?php } ?>