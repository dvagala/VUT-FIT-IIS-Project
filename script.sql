drop table if exists restaurantHasItem;
drop table if exists itemWillBeInMenu;
drop table if exists orderHasItem;
drop table if exists `order`;
drop table if exists restaurant;
drop table if exists item;
drop table if exists person;


CREATE TABLE restaurant (
  restaurantId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name TINYTEXT,
  description TEXT,
  town TINYTEXT,
  street TINYTEXT,
  zip INT,
  phoneNumber TINYTEXT,
  openingTime TIME,
  closureTime TIME
);

CREATE TABLE item (
  itemId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name TINYTEXT,
  description TEXT,
  picture TEXT,
  price DECIMAL(6,2),
  type ENUM("dailyMenu", "meal","sidedish", "sauce", "beverage"),
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

CREATE TABLE person (
  personId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  Name TINYTEXT,
  Surname TINYTEXT,
  Town TINYTEXT,
  Street TINYTEXT,
  ZIP INT,
  phoneNumber TINYTEXT,
  mail TINYTEXT,
  hashedPassword LONGTEXT,
  state ENUM("unregistered", "diner", "driver", "operator", "admin")
);


CREATE TABLE `order` (
  orderId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  additionalInfo TEXT,
  state ENUM("placedButNotAssignedToDriver", "assignedToDriver", "BeingDelivered"),
  dinerId INT NOT NULL,
  driverId INT,
  restaurantId INT NOT NULL,
  FOREIGN KEY (dinerId) REFERENCES person(personId),
  FOREIGN KEY (driverId) REFERENCES person(personId),
  FOREIGN KEY (restaurantId) REFERENCES restaurant(restaurantId)
);

CREATE TABLE orderHasItem (
  orderHasItemId INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  orderId INT NOT NULL,
  itemId INT NOT NULL,
  FOREIGN KEY (orderId) REFERENCES `order`(orderId),
  FOREIGN KEY (itemId) REFERENCES item(itemId)
);




insert into restaurant values (1, "Purkynka", "Menza", "Brno", "Purkynova", 61200, "0944456789", TIME("08:00:00"), TIME("18:00:00"));
insert into restaurant values (2, "Skacelka", "some description", "Brno", "Purkynova", 61200, "0944456789", TIME("09:00:00"), TIME("21:30:00"));
insert into restaurant values (3, "Forkys", "Vegetarian restaurant", "Trnava", "Purkynova", 61200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));
insert into restaurant values (4, "Lokofu", "Chinese restaurant", "Brno-stred", "Kounicova 966", 60200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));
insert into restaurant values (5, "Running & sushi", "Sushi sushi", "Trnava", "Kollarova 555", 91701, "0944456789", TIME("07:00:00"), TIME("20:00:00"));
insert into restaurant values (6, "Pizza Piccolino Trnava", "some description", "Trnava", "Hlavna 14", 91701, "0944456789", TIME("07:00:00"), TIME("17:00:00"));


insert into item values (100, "Spaghetti and Meatballs", "Delicious spaghetti", "uploads/spageti.jpg", 8.2, "dailyMenu", false, false);
insert into item values (101, "Lasagne", "Very tasty lasagne", "uploads/lasagne.jpg", 6.3, "dailyMenu", false, false);
insert into item values (102, "Chilli con carne", "Very nice chilli", "uploads/chilli.jpg", 4.4, "dailyMenu", true, false);

insert into item values (104, "Spaghetti", "Pasta di pizza", "uploads/spaghetiiplain.jpg", 3.4, "meal", false, false);
insert into item values (105, "Rice", "Nice rice", "uploads/rice.jpg", 2.7, "sidedish", false, false);
insert into item values (106, "Mashed potatoes", "Some tasty potatoes these are", "uploads/default.jpg", 3.6, "sidedish", false, false);
insert into item values (107, "Chips", "Even tastier potatoes these ones", "uploads/default.jpg", 4.2, "sidedish", false, false);

insert into item values (108, "Majonese", "Majoneseee", "uploads/default.jpg", 1.4, "sauce", false, false);
insert into item values (109, "Ketchup", "Poor tomatoes", "uploads/default.jpg", 0.8, "sauce", false, false);
insert into item values (110, "Mustard", "Mustard description", "uploads/default.jpg", 0.9, "sauce", false, false);
insert into item values (111, "Lemon juice", "Freshly squeezed", "uploads/default.jpg", 0.9, "sauce", false, false);

insert into item values (112, "Coca cola", "Sizzlin", "uploads/default.jpg", 2.4, "beverage", false, false);
insert into item values (113, "Beer", "Bubblin", "uploads/default.jpg", 3.2, "beverage", false, false);
insert into item values (114, "Wine", "South slope", "uploads/default.jpg", 1.6, "beverage", false, false);
insert into item values (115, "Soda", "Sizzlin n bubblin", "uploads/default.jpg", 0.5, "beverage", false, false);

insert into item values (116, "Grilled chicken", "Very nice and tasty", "uploads/chicken.jpg", 7.1, "meal", false, true);
insert into item values (117, "Salmon", "Very nice", "uploads/salnom.jpg", 8.3, "meal", false, false);
insert into item values (118, "Pork", "Very tasty", "uploads/pork.jpg", 9.7, "meal", false, false);
insert into item values (119, "Pizza", "Pizza di pasta", "uploads/pizza.jpg", 5.4, "meal", false, true);


insert into restaurantHasItem values (1, 100);
insert into restaurantHasItem values (1, 101);
insert into restaurantHasItem values (1, 102);

insert into restaurantHasItem values (1, 104);
insert into restaurantHasItem values (1, 105);
insert into restaurantHasItem values (1, 106);
insert into restaurantHasItem values (1, 107);

insert into restaurantHasItem values (1, 108);
insert into restaurantHasItem values (1, 109);
insert into restaurantHasItem values (1, 110);
insert into restaurantHasItem values (1, 111);

insert into restaurantHasItem values (1, 112);
insert into restaurantHasItem values (1, 113);
insert into restaurantHasItem values (1, 114);
insert into restaurantHasItem values (1, 115);

insert into restaurantHasItem values (1, 116);
insert into restaurantHasItem values (1, 117);
insert into restaurantHasItem values (1, 118);
insert into restaurantHasItem values (1, 119);

insert into person values (10, "Jakub", "someSurname", "brno", "purkynova", 61200, "0985456789", "jakub@gmail.com", "hashedPassword", "admin");
insert into person values (11, "Dominik", "someSurname", "brno", "purkynova", 61200, "0985456789", "w@w", "$2y$10$PqBa4hPSv2xdY4.XNtQvYuuyTh0YkYPzwGo2WWSdscnNFzr9HqLcm", "admin");
insert into person values (12, "Admin", "adminSurname", "Jaslovske Bohunice", "Atomka", 61200, "0985456789", "admin@gmail.com", "$2y$10$J6zUNuhyNCV9uY/F/Yzlr.sh5/7Ejo2kaPvIC7GP8V3TvUrg54RFa", "admin");
insert into person values (13, "Operator", "operatorSurname", "Trnava", "Skusobka", 61200, "0985456789", "operator@gmail.com", "$2y$10$yHLMJOAcCqXweWeaiU6IuuNzSGph7E7.ZX/7zcl/Rl.twKJe7Dw7K", "operator");
insert into person values (14, "Driver", "driverSurname", "Trnava", "Johna Dopieru 26/a", 61200, "0985456789", "driver@gmail.com", "$2y$10$T3ib4zk/BCAifX7OleTRiurK1aoARJr6xHD2LgSjOJLcfQFbSyd0G", "driver");
insert into person values (15, "Diner", "dinerSurname", "Brno", "Skacelova", 61200, "0985456789", "diner@gmail.com", "$2y$10$blyLUvZsCTITgNL3hxAXCO7j8EFa2f3R.y0iU6vV7ZsztJYEKWmx2", "diner");
