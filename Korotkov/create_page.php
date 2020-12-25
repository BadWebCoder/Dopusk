<?php session_start(); // запуск сессии
   if(empty($_SESSION['login'])) header('Location: Index.php'); // если не авторизован как админ, не пускает сюда
   
   else // в другом случае пускает
   { 
    include('connect.php'); // подключаем БД 

    $mysqli_genres = "SELECT * FROM genres"; // запрос жанров
    $query = mysqli_query($link, $mysqli_genres); // выполнение запроса жанров
    $res_gen = mysqli_fetch_all($query, MYSQLI_ASSOC); // занесение полученных жанров в массив
    $mysqli_cons = 'SELECT id_console ,name_console FROM consoles'; // запрос консолей
    $query_cons = mysqli_query($link, $mysqli_cons); // выполнение запроса консолей
    $res_cons = mysqli_fetch_all($query_cons, MYSQLI_ASSOC); // занесение полученных консолей в массив

    if(isset($_POST['create'])) // проверка для вывода введенных данных
    {
      $gameName = $_POST['game']; // название игры
      $dev = $_POST['dev']; // имя разработчика
      $pub = $_POST['pub']; // имя издателя
      $year = $_POST['year']; // год выхода
      $genre = $_POST['genre']; // жанр
      $plat = $_POST['platform']; // платформы, на которые игра выходила
      $pic = $_FILES['image']['name']; // название картинки
      $tmp_pic = $_FILES['image']['tmp_name']; // временное хранение картинки
      $serv = $_SERVER['DOCUMENT_ROOT'] . "/pics/coverarts/"; // путь корневой директории
   

      $checkGame = mysqli_query($link, "SELECT `id_game` FROM `games` WHERE `name_game` = '$gameName'"); // проверка на существующую игру
      if(mysqli_num_rows($checkGame) == 0) // если игры с таким именем нет
      {
        if(preg_match("/.jpg\z/i", $pic) or preg_match("/.png\z/i", $pic) or $pic == '') // если картинки формата png, jpg или ее нет
        {
          if ($pic == '') $pic = 'nocover.png'; // если изображения нет, то автоматически ставится пикча, сообщающая, что обложки нет
          $addGame = "INSERT INTO games (`id_game`, `name_game`, `dev`, `publisher`, `year`, `id_genre`, `cov_art`, `info`) 
                      VALUES (NULL, '$gameName', '$dev', '$pub', '$year', '$genre', 'pics/coverarts/$pic', '');"; // запрос на добавление игры
          $query_create = mysqli_query($link, $addGame); // выполнение запроса на добавление игры
          foreach ($plat as $index => $platforms) 
          {
            mysqli_query($link, "INSERT INTO `platforms_for_game`
                         VALUES ((SELECT id_game FROM games ORDER BY id_game DESC LIMIT 1), $platforms)");
          }
          if($tmp_pic != '') // если изображение подгруженно
          {
            move_uploaded_file($tmp_pic, $serv . $pic); // загрузка картинки 
          }
           $zap = mysqli_query($link, "SELECT id_game FROM games ORDER BY id_game DESC LIMIT 1"); // запрос на id созданой страницы игры
           $res_id = mysqli_fetch_array($zap); // занесение id игры в массив ?>
           <meta http-equiv="refresh" content="0;URL=page_of_game.php?game=<?php echo $res_id[0]  // перекидывает на страницу созданной игры?>">
       <?php
        }
        else echo '<script> alert("Неправильный формат!"); </script>'; // если у картинки неверный формат то выдает ошибку
      }
      else echo '<script> alert("Игра с таким именем есть!"); </script>'; // иначе сообщает о наличии игры с таким названием
    }
    ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая страница</title>
    <link rel="shortcut icon" href="pics/favicon.png" type="image/png">
    <link rel="stylesheet" href="CSS/style.css"> <!-- Стили сайта -->
</head>
<body>
    <div id="registr">
      <div class="reg_content">
        <h1> Создание страницы с игрой </h1>
        <div>
         <form method="POST" enctype="multipart/form-data">
            <p class="game_page"> Игра </p> <input type="text" name="game" required> 
            <p> Разработчик </p> <input type='text' name="dev" required>
            <p> Издатель </p> <input type='text' name="pub" required> 
            <p> Год выхода </p>
               <select id="year" name="year" required>
                  <option disabled selected ></option>
               </select>     
            <p> Жанр </p>
                <select name="genre" required>
                  <option type="hidden" disabled selected ></option>
                  <?php foreach($res_gen as $genres){ ?>
                    <option value="<?php echo $genres['id_genre'] ?>"> <?php echo $genres['genre'] ?> </option>
                  <?php }?>
                </select>
            
            <p id="bottom"> Платформа </p>
            <a href="#" id="add" onclick="add()"> +Добавить список </a>
            <a href="#" id="del" onclick="del()"> -Удалить список </a>
            <div id="crt">
              <select name="platform[]" required>
                  <option disabled selected ></option>
                  <?php foreach($res_cons as $consoles){ ?>
                    <option value="<?php echo $consoles['id_console'] ?>"> <?php echo $consoles['name_console'] ?> </option>
                  <?php } ?>
               </select> 
            </div>             
            <p>Обложка игры (если у нее она есть)</p> <input type="file" name="image"> <br>
          <input type="submit" value="Создать страницу" name="create">    
         </form>  
        </div>
      </div>
    </div>
</body>
<script src="scripts/years.js"> </script>
<script src="scripts/taggenerator.js"> </script>
</html>
 <?php } ?>
