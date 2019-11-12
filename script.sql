# drop table restaurantHasItem;
# drop table itemWillBeInMenu;
# drop table restaurant;
# drop table item;
drop table `Order`;


CREATE TABLE restaurant (
  restaurantId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(50),
  town VARCHAR(50),
  street VARCHAR(50),
  zip INT,
  ordersClosure TIME
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

CREATE TABLE Person (
  personId INT NOT NULL PRIMARY KEY,
  Name VARCHAR(50),
  Town VARCHAR(50),
  Street VARCHAR(50),
  ZIP INT,
  isRegistered BOOLEAN DEFAULT FALSE
);

CREATE TABLE Driver (
  driverId INT NOT NULL PRIMARY KEY,
  FOREIGN KEY (driverId) REFERENCES Person(personId)
);


CREATE TABLE `Order` (
  orderId INT NOT NULL PRIMARY KEY,
  state ENUM("unconfirmed", "confirmed", "delivery"),
  dinerId INT NOT NULL,
  driverId INT NOT NULL,
  FOREIGN KEY (dinerId) REFERENCES Person(personId),
  FOREIGN KEY (driverId) REFERENCES Driver(driverId)
);


insert into restaurant values (1, "purkynka", "brno", "purkynova", 61200, TIME("13:10:11"));
insert into item values (101, "spaghetti", "Delicious spaghetti", "/img/spaghetti.jpg", 3, "meal", true, true, false);

insert into item values (102, "lasagne", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);
insert into item values (103, "chilli con carne", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);
insert into item values (104, "pizza", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);

insert into restaurantHasItem values (1, 101);
insert into restaurantHasItem values (1, 102);
insert into itemWillBeInMenu values (102, DATE("2019-11-10"));
insert into itemWillBeInMenu values (103, DATE("2019-11-11"));
insert into itemWillBeInMenu values (104, DATE("2019-11-12"));


insert into Person values (10, "Jakub", "brno", "purkynova", 61200, true);
insert into Person values (11, "Dominik", "brno", "purkynova", 61200, true);
insert into Driver values (11);


insert into `Order` values (20, "unconfirmed", 10, 11);


select * from restaurant;
select * from item;
select * from restaurantHasItem;
select * from itemWillBeInMenu;

