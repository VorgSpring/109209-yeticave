// получить список из всех категорий
SELECT name FROM category;

// получить самые новые, открытые лоты
SELECT lots.name, lots.start_price, lots.image_url, COUNT(rates.id), category.name FROM lots
JOIN category ON lots.category_id = category.id
JOIN rates ON lots.id = rates.lot_id
WHERE now() < lots.completion_date AND lots.winner_id IS NULL;

// найти лот по его названию или описанию
SELECT * FROM lots WHERE name LIKE '%name%' OR description LIKE '%описание%';

// добавить новый лот
INSERT INTO lots SET
  date_created = NOW(),
  name = 'название',
  description = 'описание',
  image_url = 'img/lot.jpg',
  start_price = 10000,
  completion_date = DATA_ADD(now(), INTERVAL 1 MONTH),
  step_rate = 100,
  author_id = 1,
  category_id = 1;

// обновить название лота по его идентификатору
UPDATE lots SET name = 'новое название' WHERE id = 1;

// добавить новую ставку для лота
INSERT INTO rates SET
  date = NOW(),
  price = 4000,
  user_id = 1,
  lot_id = 1

// получить список ставок для лота по его идентификатору
SELECT rates.date, rates.price, users.name
FROM rates
JOIN users ON rates.user_id = users.id
WHERE rates.lot_id = 1;