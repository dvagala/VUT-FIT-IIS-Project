drop table if exists restaurantHasItem;
drop table if exists itemWillBeInMenu;
drop table if exists orderHasItem;
drop table if exists restaurant;
drop table if exists item;
drop table if exists person;
drop table if exists `order`;
drop event if exists updateDailyMenuItemsEvent;

-- CREATE USER 'iisUser'@'%' IDENTIFIED BY 'iisPassword';
-- GRANT ALL PRIVILEGES ON iisDb. * TO 'iisUser'@'%';
-- FLUSH PRIVILEGES;

CREATE TABLE restaurant (
  restaurantId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(50),
  description VARCHAR(50),
  town VARCHAR(50),
  street VARCHAR(50),
  zip INT,
  phoneNumber INT,
  openingTime TIME,
  closureTime TIME
);

CREATE TABLE item (
  itemId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(50),
  description VARCHAR(50),
  picture VARCHAR(50),
  price INT,
  type ENUM("dailyMenu", "sauce", "meal", "beverage","sidedish"),
  isInMenu BOOLEAN DEFAULT FALSE,
  isVegan BOOLEAN DEFAULT FALSE,
  isGlutenFree BOOLEAN DEFAULT FALSE
);

CREATE TABLE restaurantHasItem (
  restaurantId INT NOT NULL,
  itemId INT NOT NULL,
  PRIMARY KEY (restaurantId, itemId),
  FOREIGN KEY (restaurantId) REFERENCES restaurant(restaurantId),
  FOREIGN KEY (itemId) REFERENCES item(itemId)
);

CREATE TABLE itemWillBeInMenu (
  itemId INT NOT NULL,
  date DATE,
  PRIMARY KEY (itemId, date),
  FOREIGN KEY (itemId) REFERENCES item(itemId)
);


CREATE EVENT updateDailyMenuItemsEvent
ON SCHEDULE
  EVERY 1 DAY
  STARTS (TIMESTAMP(CURRENT_DATE) + INTERVAL 1 DAY)
DO
  update item natural join itemWillBeInMenu set isInMenu = true
  where date = CURRENT_DATE();

CREATE TABLE person (
  personId INT NOT NULL PRIMARY KEY,
  Name VARCHAR(50),
  Town VARCHAR(50),
  Street VARCHAR(50),
  ZIP INT,
  phoneNumber INT,
  mail VARCHAR(50),
  password VARCHAR(50),
  state ENUM("unregistred", "diner", "driver", "operator", "admin")
);


CREATE TABLE `order` (
  orderId INT NOT NULL PRIMARY KEY,
  additionalInfo VARCHAR(50),
  state ENUM("unconfirmed", "confirmed", "delivery"),
  dinerId INT NOT NULL,
  driverId INT NOT NULL,
  FOREIGN KEY (dinerId) REFERENCES person(personId),
  FOREIGN KEY (driverId) REFERENCES person(personId)
);

CREATE TABLE orderHasItem (
  orderId INT NOT NULL,
  itemId INT NOT NULL,
  PRIMARY KEY (orderId, itemId),
  FOREIGN KEY (orderId) REFERENCES item(orderId),
  FOREIGN KEY (itemId) REFERENCES item(itemId)
);


insert into restaurant values (1, "purkynka", "some description", "brno", "purkynova", 61200, 0944456789, TIME("08:00:00"), TIME("18:00:00"));
insert into restaurant values (2, "skacelka", "some description", "brno", "purkynova", 61200, 0944456789, TIME("09:00:00"), TIME("21:30:00"));
insert into restaurant values (3, "forkys", "some description", "Trnava", "purkynova", 61200, 0944456789, TIME("07:00:00"), TIME("17:00:00"));

insert into item values (101, "spaghetti", "Delicious spaghetti", "/img/spaghetti.jpg", 3, "meal", true, true, false);

insert into item values (102, "lasagne", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);
insert into item values (103, "chilli con carne", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);
insert into item values (104, "pizza", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);

insert into restaurantHasItem values (1, 101);
insert into restaurantHasItem values (1, 102);
insert into itemWillBeInMenu values (102, DATE("2019-11-10"));
insert into itemWillBeInMenu values (103, DATE("2019-11-11"));
insert into itemWillBeInMenu values (104, DATE("2019-11-12"));


insert into person values (10, "Jakub", "brno", "purkynova", 61200, 0985456789, "jakub@gmail.com", "hashedPassword", "diner");
insert into person values (11, "Dominik", "brno", "purkynova", 61200, 0985456789, "jakub@gmail.com", "hashedPassword", "driver");


insert into `order` values (20, "Please call me 20min before delivery", "unconfirmed", 10, 11);
insert into orderHasItem values (20, 102);
insert into orderHasItem values (20, 103);
insert into orderHasItem values (20, 104);


select * from restaurant;
select * from item;
select * from restaurantHasItem;
select * from itemWillBeInMenu;
select * from orderHasItem;
select * from `order`;
select * from person;

-- SELECT TIME_FORMAT(`openingTime`, '%H:%i') FROM `restaurant`;
