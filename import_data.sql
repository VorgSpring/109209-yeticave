# добавляем категории
INSERT INTO category SET name = 'Доски и лыжи';
INSERT INTO category SET name = 'Крепления';
INSERT INTO category SET name = 'Ботинки';
INSERT INTO category SET name = 'Одежда';
INSERT INTO category SET name = 'Инструменты';
INSERT INTO category SET name = 'Разное';

# добавляем пользователей
INSERT INTO users SET
  registration_date = NOW() + INTERVAL -5 DAY,
  email = 'ignat.v@gmail.com',
  name = 'Игнат',
  password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
  avatar = 'img/user.jpg',
  contacts = NULL;

INSERT  INTO users SET
  registration_date = NOW() + INTERVAL -5 DAY,
  email = 'kitty_93@li.ru',
  name = 'Леночка',
  password = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa',
  avatar = 'img/user.jpg',
  contacts = NULL;

INSERT INTO users SET
  registration_date = NOW() + INTERVAL -5 DAY,
  email = 'warrior07@mail.ru',
  name = 'Руслан',
  password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
  avatar = 'img/user.jpg',
  contacts = NULL;

# добавляем объявления
INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = '2014 Rossignol District Snowboard',
  description = 'Истинная твин-тип доска для парка и пайпа. Форма сноуборда AmpTek Auto Turn сочетает небольшой стандартный прогиб между закладными для стабильности и хватки кантов и высокие рокеры на носке и хвосте для того, чтобы легко входить в поворот, контролировать доску и плавно перекантовываться без нежелательных зарезаний. Оптимальная доска для быстрого прогресса в парке и пайпе!',
  image_url = 'img/lot-1.jpg',
  start_price = 10999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 1,
  category_id = 1;

INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = 'DC Ply Mens 2016/2017 Snowboard',
  description = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
  image_url = 'img/lot-2.jpg',
  start_price = 159999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 2,
  category_id = 1;

INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = 'Крепления Union Contact Pro 2015 года размер L/XL',
  description = 'Невероятно легкие универсальные крепления весом всего 720 грамм готовы порадовать прогрессирующих райдеров, практикующих как трассовое катание, так и взрывные спуски в паудере. Легкая нейлоновая база в сочетании с очень прочным хилкапом, выполненным из экструдированного алюминия, выдержит серьезные нагрузки, а бакли, выполненные из магния не только заметно снижают вес, но и имеют плавный механизм. Система стрепов 3D Connect обеспечивает равномерное давление на верхнюю часть ноги, что несомненно добавляет комфорта как во время выполнения трюков, так и во время катания в глубоком снегу.',
  image_url = 'img/lot-3.jpg',
  start_price = 10999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 3,
  category_id = 2;

INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = 'Ботинки для сноуборда DC Mutiny Charocal',
  description = 'Эти ботинки созданы для фристайла и для того, чтобы на любом споте Вы чувствовали себя как дома в уютных тапочках, в которых Вы будете также прекрасно чувствовать свою доску, как ворсинки на любимом коврике около дивана. Каучуковая стелька Impact S погасит нежелательные вибрации и смягчит приземления, внутренник White Liner с запоминающим форму ноги наполением и фиксирующим верхним стрепом добавит эргономики в посадке, а традиционная шнуровка с блокирующими верхними крючками поможет идеально подогнать ботинок по ноге, тонко фиксируя натяжение шнурков.',
  image_url = 'img/lot-4.jpg',
  start_price = 10999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 1,
  category_id = 3;

INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = 'Куртка для сноуборда DC Mutiny Charocal',
  description = 'Спокойный дизайн, не обремененный лишними деталями, впишется практически в любой гардероб, так что куртка DC Arctic 2 будет отлично сочетаться как с джинсами и кедами, так и с более строгим гардеробом. Внешняя влагостойкая ткань, удобные карманы для рук и съемный капюшон отлично справятся с капризами погоды, защищая Вас от холода, ветра и моросящего дождя, а стеганая подкладка сохранит ценное тепло.',
  image_url = 'img/lot-5.jpg',
  start_price = 10999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 2,
  category_id = 4;

INSERT INTO lots SET
  date_created = NOW() + INTERVAL -4 DAY,
  name = 'Маска Oakley Canopy',
  description = 'Увеличенный объем линзы и низкий профиль оправы маски Canopy способствуют широкому углу обзора, а специальное противотуманное покрытие поможет ориентироваться в условиях плохой видимости. Технология вентиляции O-Flow Arch и прослойка из микрофлиса сделают покорение горных склонов более комфортным.',
  image_url = 'img/lot-6.jpg',
  start_price = 10999,
  completion_date = NOW() + INTERVAL 1 MONTH,
  step_rate = 100,
  author_id = 3,
  category_id = 6;

# добавляем ставки
INSERT INTO rates SET
  date = NOW() + INTERVAL -3 DAY,
  price = 11500,
  user_id = 1,
  lot_id = 1;

INSERT INTO rates SET
  date = NOW() + INTERVAL -2 DAY,
  price = 12000,
  user_id = 2,
  lot_id = 1;

INSERT INTO rates SET
  date = NOW() + INTERVAL -1 DAY,
  price = 12500,
  user_id = 3,
  lot_id = 1;