-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 23 2020 г., 15:55
-- Версия сервера: 5.7.25
-- Версия PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `korotkov`
--

-- --------------------------------------------------------

--
-- Структура таблицы `consoles`
--

CREATE TABLE `consoles` (
  `id_console` int(11) NOT NULL,
  `name_console` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `consoles`
--

INSERT INTO `consoles` (`id_console`, `name_console`, `pic`) VALUES
(1, 'NES/Famicom', 'nes'),
(2, 'SNES', 'snes'),
(3, 'N64', 'n64'),
(4, 'GB', 'gb'),
(5, 'GBC', 'gbc'),
(6, 'GBA', 'gba'),
(7, 'Sega Genesis', 'genesis'),
(8, 'Sega Saturn', 'saturn'),
(9, 'Dreamcast', 'dreamcast');

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE `gallery` (
  `id_pic` int(11) NOT NULL,
  `id_game` int(11) NOT NULL,
  `pic` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `gallery`
--

INSERT INTO `gallery` (`id_pic`, `id_game`, `pic`) VALUES
(17, 16, 0x706963732f73637265656e73686f74732f73757065726d6172696f776f726c64312e6a7067),
(18, 75, 0x706963732f73637265656e73686f74732f4d6172696f5f655f4c756967695f5375706572737461725f536167612d356331613731653932336562612e6a7067),
(19, 75, 0x706963732f73637265656e73686f74732f696d6167653037382e706e67),
(22, 15, 0x706963732f73637265656e73686f74732f53757065722d4d6172696f2d42726f732d332d3734303833363733302e706e67),
(30, 97, 0x706963732f73637265656e73686f74732f726574726f6d6172696f5f363437383337323938363532352e6a7067),
(31, 97, 0x706963732f73637265656e73686f74732f736d36345f373034383039323833353037323633342e6a7067),
(32, 97, 0x706963732f73637265656e73686f74732f73757065722d6d6172696f2d36342d77696e672d6361707936373538393734353230323333352e6a7067),
(36, 99, 0x706963732f73637265656e73686f74732f73637265656e73686f745f756c74696d6174655f6d6f7274616c5f6b6f6d6261745f335f31353532333532382e6a7067),
(37, 99, 0x706963732f73637265656e73686f74732f73637265656e73686f745f756c74696d6174655f6d6f7274616c5f6b6f6d6261745f335f3133373435363334362e6a7067),
(41, 14, 0x706963732f73637265656e73686f74732f7265676e756d5f706963747572655f313439333039363333363237373034325f6e6f726d616c2e6a7067);

-- --------------------------------------------------------

--
-- Структура таблицы `games`
--

CREATE TABLE `games` (
  `id_game` int(11) NOT NULL,
  `name_game` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dev` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publisher` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_genre` int(11) NOT NULL,
  `cov_art` blob,
  `info` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `games`
--

INSERT INTO `games` (`id_game`, `name_game`, `dev`, `publisher`, `year`, `id_genre`, `cov_art`, `info`) VALUES
(11, 'Sonic the Hedgehog', 'SEGA', 'SEGA', '1991', 2, 0x706963732f636f766572617274732f736f6e69632d7468652d6865646765686f675f64333633363831342e6a7067, ''),
(14, 'Contra', 'Konami', 'Konami', '1987', 3, 0x706963732f636f766572617274732f6e65735f636f6e7472612e6a7067, '<p> <b>Contra</b> (в Европе — Probotector для NES и Gryzor для аркадного автомата и домашних компьютеров, в Японии — яп. 魂斗羅 Контора) — первая игра из одноимённой серии игр, вышедшая в 1987 году.</p>'),
(15, 'Super Mario Bros 3', 'Nintendo', 'Nintendo', '1988', 1, 0x706963732f636f766572617274732f6e65735f73757065726d6172696f62726f73332e6a7067, '<p> <b>Super Mario Bros. 3</b> (яп. スーパーマリオブラザーズ3 Су:па Марио Бурадза:дзу Сури:, рус. Супербратья Марио 3), также известная как Mario 3, SMB3, или Super Mario 3 — видеоигра в жанре платформенной аркады, разработанная и изданная Nintendo для консоли NES, продолжающая серию игр, начатых Super Mario Bros. Релиз игры в Японии состоялся осенью 1988 года, зимой 1990-го в Северной Америке и летом 1991-го — в Европе.</p>\r\n\r\n<p>Super Mario Bros. 3 добавила много нововведений в серию Super Mario: дополнительный экран карты, мини-игры, множество новых способностей, врагов и типов уровней. Также в этой игре впервые фигурируют дети Боузера — Купалинги. В то же время игра внесла гораздо больше новшеств в серию, чем Super Mario Bros.: The Lost Levels. Благодаря всему этому Super Mario Bros. 3 можно часто наблюдать на первых позициях списков «Величайших игр всех времён».</p>'),
(16, 'Super Mario World', 'Nintendo EAD', 'Nintendo', '1990', 1, 0x706963732f636f766572617274732f736e65735f73757065726d6172696f776f726c642e6a7067, '<p> <b>Super Mario World</b>, в Японии известная как Super Mario World: Super Mario Bros. 4 (яп. スーパーマリオワールドスーパーマリオブラザーズ4 Су:па: Марио Ва:рудо: Су:па Марио Бурадза:дзу Фо:) — платформер, выпущенный компанией Nintendo для Super Nintendo Entertainment System (SNES) в 1990 году. Производством игры занималась студия Nintendo Entertainment Analysis and Development под руководством Сигэру Миямото и Такаси Тэдзуки. Super Mario World попала в стартовую линейку игр SNES.</p>\r\n\r\n<p>По сюжету Марио и Йоши должны спасти Страну Динозавров (англ. Dinosaur Land) от тирании Боузера — главного антагониста серии. Марио и его брату, Луиджи, предстоит путешествие через семь миров, в конце каждого из которых они должны победить босса. Игровой процесс Super Mario World схож с предыдущими играми франшизы. Однако, появились новые, увеличивающие способности главного героя, бонусы, которые были перенесены в последующие игры серии. В Super Mario World впервые появился динозавр Йоши, спутник и скакун главного героя во многих последовавших играх с участием Марио.</p>\r\n\r\n<p>Игра была тепло встречена критиками и имела огромный успех среди игроков, став бестселлером — по всему миру было продано более 20 млн. экземпляров. Многие профильные издания называли её одной из лучших игр в истории. Согласно продажам, Super Mario World занимает первое место среди всех игр, выпущенных для SNES. Благодаря своей популярности Super Mario World была портирована на различные игровые платформы нескольких поколений и входила в состав некоторых сборников.</p>'),
(17, 'Donkey Kong Country', 'Rare', 'Nintendo', '1994', 1, 0x706963732f636f766572617274732f736e65735f646f6e6b65796b6f6e67636f756e7472792e6a7067, '<p> <b>Donkey Kong Country плываоепдыв</b></p>'),
(61, 'Vectorman', 'SEGA', 'SEGA', '1990', 8, 0x706963732f636f766572617274732f67656e657369735f766563746f726d616e5f70616c2e6a7067, ''),
(66, 'Pokemon Blue', 'Game Freak', 'Nintendo', '1996', 13, 0x706963732f636f766572617274732f67625f706f6b656d6f6e626c75652e6a7067, ''),
(67, 'Super Mario Land', 'Nintendo', 'Nintendo', '1989', 1, 0x706963732f636f766572617274732f67625f73757065726d6172696f6c616e642e6a7067, ''),
(68, 'The Legend of Zelda: Link’s Awakening', 'Nintendo EAD', 'Nintendo', '1993', 10, 0x706963732f636f766572617274732f6762635f6c6567656e646f667a656c64616c696e6b736177616b656e696e6764782e6a7067, ''),
(72, 'Metroid Fusion', 'Nintendo R&D1', 'Nintendo', '2002', 11, 0x706963732f636f766572617274732f6d6574726f6964667573696f6e2e6a7067, ''),
(75, 'Mario & Luigi: Superstar Saga', 'AlphaDream', 'Nintendo', '2003', 13, 0x706963732f636f766572617274732f6d6172696f616e646c75696769737570657273746172736167612e6a7067, ''),
(76, 'Wario Land II', 'Nintendo R&D1', 'Nintendo', '1998', 1, 0x706963732f636f766572617274732f6762635f776172696f6c616e64322e6a7067, ''),
(79, 'Mortal Kombat Trilogy', 'Midway Games', 'Midway Games', '1996', 4, 0x706963732f636f766572617274732f73617475726e5f6d6f7274616c6b6f6d6261747472696c6f67792e6a7067, ''),
(87, 'Saturn Bomberman', 'Hudson Soft', 'Sega', '1988', 5, 0x706963732f636f766572617274732f73617475726e5f73617475726e626f6d6265726d616e5f61752e6a7067, ''),
(96, 'Super Metroid', 'Nintendo R&D1', 'Nintendo', '1994', 11, 0x706963732f636f766572617274732f736e65735f73757065726d6574726f69642e6a7067, ''),
(97, 'Super Mario 64', 'Nintendo EAD', 'Nintendo', '1996', 1, 0x706963732f636f766572617274732f6e36345f73757065726d6172696f36342e6a7067, ''),
(99, 'Ultimate Mortal Kombat 3', 'Midway Games', 'Midway Games', '1995', 4, 0x706963732f636f766572617274732f67656e657369735f756c74696d6174656d6f7274616c6b6f6d626174332e6a7067, '<p><b>Ultimate Mortal Kombat 3</b> (сокр. UMK3; с англ. — «Окончательная Смертельная Битва 3») — мультиплатформенная компьютерная игра в жанре файтинг, разработанная и выпущенная компанией Midway в 1995 году[1][2]. Первоначально игра появилась на аркадных автоматах, а затем на домашних игровых консолях. В этом обновлении более ранней игры Mortal Kombat 3 представлен оптимальный геймплей, а также присутствуют дополнительные персонажи и новые арены.</p>');

-- --------------------------------------------------------

--
-- Структура таблицы `genres`
--

CREATE TABLE `genres` (
  `id_genre` int(11) NOT NULL,
  `genre` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `genres`
--

INSERT INTO `genres` (`id_genre`, `genre`) VALUES
(1, 'Платформер'),
(2, 'Приключение'),
(3, 'Шутер'),
(4, 'Файтинг'),
(5, 'Экшен'),
(6, 'Beat-em up'),
(7, 'Стелс-экшен'),
(8, 'Survival-action'),
(9, 'Ритм-игра'),
(10, ' action-adventure'),
(11, 'Метроидвания'),
(13, 'Ролевая');

-- --------------------------------------------------------

--
-- Структура таблицы `platforms_for_game`
--

CREATE TABLE `platforms_for_game` (
  `id_game` int(11) NOT NULL,
  `id_platform` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `platforms_for_game`
--

INSERT INTO `platforms_for_game` (`id_game`, `id_platform`) VALUES
(11, 7),
(14, 1),
(15, 1),
(16, 2),
(17, 2),
(17, 5),
(17, 6),
(61, 7),
(66, 4),
(67, 4),
(68, 4),
(68, 5),
(72, 6),
(75, 6),
(76, 4),
(76, 5),
(79, 3),
(79, 8),
(87, 8),
(96, 2),
(97, 3),
(99, 2),
(99, 7),
(99, 8);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `login` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nickname` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `root` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`login`, `password`, `nickname`, `root`) VALUES
('ivanushka', '$2y$10$jT/CBwxSsQ0dlupShDopzu4rY0J6EMICUbJC2npyz1MHALG2aLVUS', 'ILON', 1),
('korotkov', '$2y$10$gNjgR1wNooBeTwJg68ZvXOMkXOAZvuN86KqF6KWhZj5OccyTNHUFq', 'Lovushka', 0),
('loveushka', '$2y$10$PDVZAb46EoVi36SSzDjvP.urLFAQHQMsVc4s0lF0eNy71EQCr5q5m', 'Пользователь', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `consoles`
--
ALTER TABLE `consoles`
  ADD PRIMARY KEY (`id_console`);

--
-- Индексы таблицы `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_pic`),
  ADD KEY `id_game` (`id_game`);

--
-- Индексы таблицы `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id_game`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Индексы таблицы `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id_genre`);

--
-- Индексы таблицы `platforms_for_game`
--
ALTER TABLE `platforms_for_game`
  ADD PRIMARY KEY (`id_game`,`id_platform`),
  ADD KEY `id_game` (`id_game`),
  ADD KEY `id_platform` (`id_platform`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_pic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT для таблицы `games`
--
ALTER TABLE `games`
  MODIFY `id_game` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT для таблицы `genres`
--
ALTER TABLE `genres`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_3` FOREIGN KEY (`id_genre`) REFERENCES `genres` (`id_genre`);

--
-- Ограничения внешнего ключа таблицы `platforms_for_game`
--
ALTER TABLE `platforms_for_game`
  ADD CONSTRAINT `platforms_for_game_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `platforms_for_game_ibfk_2` FOREIGN KEY (`id_platform`) REFERENCES `consoles` (`id_console`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
