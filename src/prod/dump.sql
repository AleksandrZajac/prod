-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 12 2021 г., 12:14
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `coats_shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `city` varchar(256) NOT NULL,
  `street` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `addresses`
--

INSERT INTO `addresses` (`id`, `city`, `street`) VALUES
(1, 'Москва', 'Абельмановская Застава, площадь'),
(2, 'Москва', 'Абельмановская улица'),
(3, 'Москва', 'Бабьегородский 1-й, переулок'),
(4, 'Москва', 'Бабьегородский 2-й, переулок'),
(5, 'Москва', 'Багратион, мост'),
(6, 'Москва', 'Багратионовский проезд'),
(7, 'Москва', 'Багрицкого, улица'),
(8, 'Москва', 'Баженова, улица'),
(9, 'Москва', 'Бажова, улица'),
(10, 'Москва', 'Базовая улица'),
(11, 'Москва', 'Базовская улица'),
(12, 'Москва', 'Байдукова, улица'),
(13, 'Москва', 'Вавилова, улица'),
(14, 'Москва', 'Вагоноремонтная улица'),
(15, 'Москва', 'Габричевского, улица'),
(16, 'Москва', 'Гаврикова улица'),
(17, 'Москва', 'Давыдковская улица'),
(18, 'Москва', 'Давыдовский переулок'),
(19, 'Москва', 'Европы, площадь'),
(20, 'Москва', 'Егерская улица'),
(21, 'Москва', 'Жебрунова, улица'),
(22, 'Москва', 'Железногорская 1-я, улица'),
(23, 'Москва', 'Забелина, улица'),
(24, 'Москва', 'Заваруевский переулок'),
(25, 'Москва', 'Ибрагимова, улица'),
(26, 'Москва', 'Ивана Бабушкина, улица'),
(27, 'Москва', 'Кабельная 1-я, улица'),
(28, 'Москва', 'Кабельная 2-я, улица'),
(29, 'Москва', 'Лавочкина, улица'),
(30, 'Москва', 'Лавров переулок'),
(31, 'Москва', 'Магаданская улица'),
(32, 'Москва', 'Магазинный тупик'),
(33, 'Москва', 'Набережная улица'),
(34, 'Москва', 'Набережная улица (пос. Рублево)'),
(35, 'Москва', 'Обводное шоссе'),
(36, 'Москва', 'Оболенский переулок'),
(37, 'Москва', 'Павелецкая набережная'),
(38, 'Москва', 'Павелецкая площадь'),
(39, 'Москва', 'Рабочая улица'),
(40, 'Москва', 'Рабочая улица (г. Зеленоград)'),
(41, 'Москва', 'Саввинская набережная'),
(42, 'Москва', 'Савельева, улица'),
(43, 'Москва', 'Таганрогская улица'),
(44, 'Москва', 'Таганская площадь'),
(45, 'Москва', 'Уваровский переулок'),
(46, 'Москва', 'Угличская улица'),
(47, 'Москва', 'Фабрициуса, улица'),
(48, 'Москва', 'Фабричная улица'),
(49, 'Москва', 'Хабаровская улица'),
(50, 'Москва', 'Хавская улица'),
(51, 'Москва', 'ЦНИИМОД, улица'),
(52, 'Москва', 'ЦНИИМЭ, улица'),
(53, 'Москва', 'Чагинская улица'),
(54, 'Москва', 'Чапаева, улица'),
(55, 'Москва', 'Шаболовка, улица'),
(56, 'Москва', 'Шарикоподшипниковская улица'),
(57, 'Москва', 'Щемиловский 1-й, переулок'),
(58, 'Москва', 'Щемиловский 2-й, переулок'),
(59, 'Москва', 'Элеваторная улица'),
(60, 'Москва', 'Элеваторный переулок'),
(61, 'Москва', 'Югорский проезд'),
(62, 'Москва', 'Южнобутовская улица'),
(63, 'Москва', 'Яблоневая аллея'),
(64, 'Москва', 'Яблонный переулок');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `path` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `path`) VALUES
(1, 'Аксессуары', 'access'),
(2, 'Женщины', 'female'),
(3, 'Мужчины', 'male'),
(4, 'Дети', 'children'),
(5, 'Все', 'all');

-- --------------------------------------------------------

--
-- Структура таблицы `categories_products`
--

CREATE TABLE `categories_products` (
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories_products`
--

INSERT INTO `categories_products` (`category_id`, `product_id`) VALUES
(1, 3),
(1, 4),
(1, 6),
(1, 7),
(1, 10),
(1, 11),
(1, 14),
(1, 17),
(2, 2),
(2, 3),
(2, 4),
(2, 6),
(2, 8),
(2, 9),
(2, 11),
(2, 13),
(2, 15),
(3, 2),
(3, 5),
(3, 8),
(3, 11),
(3, 16),
(4, 1),
(4, 2),
(4, 5),
(4, 8),
(4, 12),
(4, 14),
(4, 17),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(5, 6),
(5, 7),
(5, 8),
(5, 9),
(5, 10),
(5, 11),
(5, 12),
(5, 13),
(5, 14),
(5, 15),
(5, 16),
(5, 17);

-- --------------------------------------------------------

--
-- Структура таблицы `deliveries`
--

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `price` int(20) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `deliveries`
--

INSERT INTO `deliveries` (`id`, `name`, `price`, `description`) VALUES
(1, 'dev-no', 0, 'Самовывоз'),
(2, 'dev-yes', 280, 'Курьерская доставка');

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_customizations`
--

CREATE TABLE `delivery_customizations` (
  `id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `delivery_method_id` int(11) NOT NULL,
  `order_sum` decimal(12,2) NOT NULL,
  `delivery_price` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `delivery_customizations`
--

INSERT INTO `delivery_customizations` (`id`, `delivery_id`, `delivery_method_id`, `order_sum`, `delivery_price`, `created_at`) VALUES
(1, 1, 4, '2000.00', '0.00', '2021-03-09 21:33:31'),
(2, 2, 1, '2000.00', '280.00', '2021-03-09 21:24:36'),
(3, 2, 2, '2000.00', '580.00', '2021-03-09 21:35:32'),
(4, 2, 3, '2000.00', '280.00', '2021-03-09 21:36:07'),
(5, 2, 1, '1800.00', '200.00', '2021-03-31 20:51:57'),
(6, 2, 2, '1800.00', '200.00', '2021-03-31 20:52:20');

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_methods`
--

CREATE TABLE `delivery_methods` (
  `id` int(11) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `delivery_methods`
--

INSERT INTO `delivery_methods` (`id`, `description`) VALUES
(1, 'Стандартная доставка'),
(2, 'В день покупки для жителей г. Москва в пределах МКАД'),
(3, 'Доставка с примеркой перед покупкой по Москве'),
(4, 'Без доставки');

-- --------------------------------------------------------

--
-- Структура таблицы `filters`
--

CREATE TABLE `filters` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `filters`
--

INSERT INTO `filters` (`id`, `name`) VALUES
(1, 'Новинка'),
(2, 'Распродажа'),
(3, 'Все товары');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'uzer'),
(2, 'operator'),
(3, 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `groups_users`
--

CREATE TABLE `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups_users`
--

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `delivery_method_id` int(11) NOT NULL,
  `payment_status` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(256) NOT NULL,
  `surname` varchar(256) NOT NULL,
  `phone` varchar(256) NOT NULL,
  `thirdName` varchar(256) DEFAULT '',
  `email` varchar(256) NOT NULL,
  `city` varchar(256) DEFAULT '',
  `comment` text DEFAULT '',
  `street` varchar(256) DEFAULT '',
  `home` varchar(256) DEFAULT '',
  `aprt` varchar(256) DEFAULT '',
  `payment_method_id` int(11) NOT NULL,
  `price` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `delivery_id`, `delivery_method_id`, `payment_status`, `status`, `created_at`, `name`, `surname`, `phone`, `thirdName`, `email`, `city`, `comment`, `street`, `home`, `aprt`, `payment_method_id`, `price`) VALUES
(1, 3, 1, 4, 1, 1, '2021-04-12 09:12:26', 'Aleksandr', 'Sidorov', '444444555', 'Ivanovic', 'aleksandr@mail.ru', 'Moskva', 'comment2', 'Street 02', '95', '21', 2, 2999);

-- --------------------------------------------------------

--
-- Структура таблицы `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `name`, `description`) VALUES
(1, 'cash', 'Наличными'),
(2, 'card', 'Кредитной картой');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `image` varchar(512) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `price`, `created_at`, `is_deleted`) VALUES
(1, 'Платье короткое5', 'img/products/product-1.jpg', '2999.00', '2021-03-15 11:21:07', 0),
(2, 'Платье длинное', 'img/products/product-2.jpg', '1800.00', '2021-02-25 12:54:11', 0),
(3, 'Платье зеленое', 'img/products/product-3.jpg', '2999.00', '2021-02-02 23:15:05', 0),
(4, 'Платье синие', 'img/products/product-4.jpg', '3950.00', '2021-02-02 23:15:05', 0),
(5, 'Платье черное', 'img/products/product-5.jpg', '2899.00', '2021-02-02 23:15:05', 0),
(6, 'Платье желтое', 'img/products/product-6.jpg', '4199.00', '2021-02-02 23:15:05', 0),
(7, 'Платье красное', 'img/products/product-7.jpg', '2999.00', '2021-02-02 23:15:05', 0),
(8, 'Брюки синие', 'img/products/product-8.jpg', '3250.00', '2021-02-02 23:15:05', 0),
(9, 'Брюки зеленые', 'img/products/product-9.jpg', '2780.00', '2021-02-02 23:15:05', 0),
(10, 'Брюки серые', 'img/products/product-1.jpg', '3150.00', '2021-02-02 23:15:05', 0),
(11, 'Брюки черые', 'img/products/product-2.jpg', '2549.00', '2021-03-11 10:02:16', 0),
(12, 'Брюки розывые', 'img/products/product-3.jpg', '3999.00', '2021-03-11 10:02:21', 0),
(13, 'Платье розовое', 'img/products/product-4.jpg', '2999.00', '2021-03-11 10:02:24', 0),
(14, 'Блузка белая', 'img/products/product-5.jpg', '4150.00', '2021-03-11 10:02:28', 0),
(15, 'Блузка серая', 'img/products/product-6.jpg', '2979.00', '2021-03-11 10:02:31', 0),
(16, 'Блузка зеленая', 'img/products/product-7.jpg', '3789.00', '2021-03-11 10:02:36', 0),
(17, 'Юбка красная', 'img/products/product-8.jpg', '2599.00', '2021-03-11 10:02:40', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products_filters`
--

CREATE TABLE `products_filters` (
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `products_filters`
--

INSERT INTO `products_filters` (`product_id`, `filter_id`) VALUES
(1, 2),
(1, 3),
(2, 1),
(2, 3),
(3, 2),
(3, 3),
(4, 1),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(5, 3),
(6, 2),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 1),
(11, 3),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'vasilij@mail.ru', '$2y$10$bkitbHPRTVsBkLVuNhd9LOqieBhP4A5Bi03KczThmtDsIbLIuwZZu'),
(2, 'michail@mail.ru', '$2y$10$Ma5C50lebO76Qm15C1D34.LzsZYldDl0YGGsX2xqXNmMRcgrmnkga');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories_products`
--
ALTER TABLE `categories_products`
  ADD UNIQUE KEY `category_product_id` (`category_id`,`product_id`),
  ADD KEY `caterory_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `delivery_customizations`
--
ALTER TABLE `delivery_customizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `delivery_method_id` (`delivery_method_id`);

--
-- Индексы таблицы `delivery_methods`
--
ALTER TABLE `delivery_methods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD UNIQUE KEY `group_user_id` (`group_id`,`user_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `payment_method_id` (`payment_method_id`),
  ADD KEY `delivery_id` (`delivery_id`),
  ADD KEY `delivery_method_id` (`delivery_method_id`);

--
-- Индексы таблицы `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `products_filters`
--
ALTER TABLE `products_filters`
  ADD UNIQUE KEY `product_filter_id` (`product_id`,`filter_id`) USING BTREE,
  ADD KEY `product_id` (`product_id`),
  ADD KEY `filter_id` (`filter_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `delivery_customizations`
--
ALTER TABLE `delivery_customizations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `delivery_methods`
--
ALTER TABLE `delivery_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `categories_products`
--
ALTER TABLE `categories_products`
  ADD CONSTRAINT `categories_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `categories_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `delivery_customizations`
--
ALTER TABLE `delivery_customizations`
  ADD CONSTRAINT `delivery_customizations_ibfk_1` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  ADD CONSTRAINT `delivery_customizations_ibfk_2` FOREIGN KEY (`delivery_method_id`) REFERENCES `delivery_methods` (`id`);

--
-- Ограничения внешнего ключа таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`delivery_id`) REFERENCES `deliveries` (`id`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`delivery_method_id`) REFERENCES `delivery_methods` (`id`);

--
-- Ограничения внешнего ключа таблицы `products_filters`
--
ALTER TABLE `products_filters`
  ADD CONSTRAINT `products_filters_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_filters_ibfk_2` FOREIGN KEY (`filter_id`) REFERENCES `filters` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
