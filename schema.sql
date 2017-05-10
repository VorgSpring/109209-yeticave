CREATE TABLE category (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name CHAR(64) NOT NULL
);

CREATE TABLE lots (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date_created DATETIME NOT NULL,
  name CHAR(128) NOT NULL,
  description TEXT,
  image_url CHAR(64),
  start_price INT NOT NULL,
  completion_date DATE NOT NULL,
  step_rate INT DEFAULT 0,
  favorites INT DEFAULT 0,
  author_id INT NOT NULL,
  winner_id INT NOT NULL,
  category_id INT NOT NULL
);

CREATE TABLE rates (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date DATETIME NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL
);

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  registration_date DATETIME NOT NULL,
  email CHAR(128) NOT NULL,
  name CHAR(64) NOT NULL,
  password CHAR(32) NOT NULL,
  avatar CHAR(64),
  contacts TEXT
);

CREATE UNIQUE INDEX user_email ON users(email);
CREATE UNIQUE INDEX category_name ON category(name);

CREATE INDEX lot_category ON lots(category_id);
CREATE INDEX lot_name ON lots(name);
