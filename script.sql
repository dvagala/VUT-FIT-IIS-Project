drop table if exists restaurantHasItem;
drop table if exists itemWillBeInMenu;
drop table if exists orderHasItem;
drop table if exists `order`;
drop table if exists restaurant;
drop table if exists item;
drop table if exists person;

-- CREATE USER 'iisUser'@'%' IDENTIFIED BY 'iisPassword';
-- # GRANT ALL PRIVILEGES ON iisDb. * TO 'iisUser'@'%';
-- # FLUSH PRIVILEGES;

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
  driverId INT NULL,
  restaurantId INT NOT NULL,
  FOREIGN KEY (dinerId) REFERENCES person(personId),
  FOREIGN KEY (driverId) REFERENCES person(personId),
  FOREIGN KEY (restaurantId) REFERENCES restaurant(restaurantId)
);

CREATE TABLE orderHasItem (
  orderId INT NOT NULL,
  itemId INT NOT NULL,
  PRIMARY KEY (orderId, itemId),
  FOREIGN KEY (orderId) REFERENCES `order`(orderId),
  FOREIGN KEY (itemId) REFERENCES item(itemId)
);




insert into restaurant values (1, "purkynka", "some description", "brno", "purkynova", 61200, "0944456789", TIME("08:00:00"), TIME("18:00:00"));
insert into restaurant values (2, "skacelka", "some description", "brno", "purkynova", 61200, "0944456789", TIME("09:00:00"), TIME("21:30:00"));
insert into restaurant values (3, "forkys", "some description", "Trnava", "purkynova", 61200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));
insert into restaurant values (4, "forkysq", "some description", "Trnava", "purkynova", 61200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));
insert into restaurant values (5, "forkysw", "some description", "Trnava", "purkynova", 61200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));
insert into restaurant values (6, "forkyse", "some description", "Trnava", "purkynova", 61200, "0944456789", TIME("07:00:00"), TIME("17:00:00"));


insert into item values (100, "Spaghetti and Meatballs", "Delicious spaghetti", "uploads/spageti.jpg", 8.2, "dailyMenu", true, false);
insert into item values (101, "lasagne", "lasagne decrip", "uploads/lasagne.jpg", 6.3, "dailyMenu", false, false);
insert into item values (102, "chilli con carne", "lasagne decrip", "uploads/chilli.jpg", 4.4, "dailyMenu", true, false);

insert into item values (116, "grilled chicken", "lasagne decrip", "uploads/chicken.jpg", 7.1, "meal", false, true);
insert into item values (117, "salmon", "lasagne decrip", "uploads/salnom.jpg", 8.3, "meal", false, false);
insert into item values (118, "pork", "lasagne decrip", "uploads/pork.jpg", 9.7, "meal", false, false);
insert into item values (119, "pizza", "lasagne decrip", "uploads/pizza.jpg", 5.4, "meal", false, true);


insert into item values (104, "spaghetti", "lasagne decrip", "uploads/spaghetiiplain.jpg", 3.4, "sidedish", false, false);
insert into item values (105, "rice", "lasagne decrip", "uploads/rice.jpg", 2.7, "sidedish", false, false);
insert into item values (106, "mashed potatoes", "lasagne decrip", "uploads/default.jpg", 3.6, "sidedish", false, false);
insert into item values (107, "chips", "lasagne decrip", "uploads/default.jpg", 4.2, "sidedish", false, false);

insert into item values (108, "majonese", "lasagne decrip", "uploads/default.jpg", 1.4, "sauce", false, false);
insert into item values (109, "ketchup", "lasagne decrip", "uploads/default.jpg", 0.8, "sauce", false, false);
insert into item values (110, "mustard", "lasagne decrip", "uploads/default.jpg", 0.9, "sauce", false, false);
insert into item values (111, "lemon juice", "lasagne decrip", "uploads/default.jpg", 0.9, "sauce", false, false);

insert into item values (112, "Coca cola", "lasagne decrip", "uploads/default.jpg", 2.4, "beverage", false, false);
insert into item values (113, "Beer", "lasagne decrip", "uploads/default.jpg", 3.2, "beverage", false, false);
insert into item values (114, "Wine", "lasagne decrip", "uploads/default.jpg", 1.6, "beverage", false, false);
insert into item values (115, "Soda", "lasagne decrip", "uploads/default.jpg", 0.5, "beverage", false, false);




insert into restaurantHasItem values (1, 100);
insert into restaurantHasItem values (1, 101);
insert into restaurantHasItem values (1, 102);
insert into restaurantHasItem values (1, 103);

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

insert into person values (10, "Jakub", "someSUrname", "brno", "purkynova", 61200, "0985456789", "jakub@gmail.com", "hashedPassword", "admin");
insert into person values (11, "Dominik", "someSUrname", "brno", "purkynova", 61200, "0985456789", "w@w", "$2y$10$PqBa4hPSv2xdY4.XNtQvYuuyTh0YkYPzwGo2WWSdscnNFzr9HqLcm", "admin");
insert into person values (12, "Peter", "someSUrname", "Jaslovske Bohunice", "Atomka", 61200, "0985456789", "peter@gmail.com", "hashedPassword", "diner");
insert into person values (13, "Marek", "someSUrname", "Trnava", "Skusobka", 61200, "0985456789", "marek@gmail.com", "hashedPassword", "diner");
insert into person values (14, "Michal", "someSUrname", "Trnava", "Johna Dopieru 26/a", 61200, "0985456789", "michal@gmail.com", "hashedPassword", "driver");


insert into `order` values (20, "Please call me 20min before delivery", "placedButNotAssignedToDriver", 10, null,1);
insert into `order` values (21, "Please call me 20min before delivery", "placedButNotAssignedToDriver", 11, null,2);
insert into `order` values (22, "Please call me 20min before delivery", "placedButNotAssignedToDriver", 12, null,3);
insert into `order` values (23, "Please call me 20min before delivery", "placedButNotAssignedToDriver", 13, null,4);
insert into `order` values (24, "Please call me 20min before delivery", "placedButNotAssignedToDriver", 14, null,5);

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

select * from item inner join restaurantHasItem on item.itemId = restaurantHasItem.itemId
where restaurantHasItem.restaurantId = 1 and item.type = "dailyMenu";

SELECT personId,Name, COUNT(orderId) as pocet FROM person LEFT JOIN `order` on person.personId = `order`.driverId where person.state='driver' group by personId,Name order by Count(orderId);

SELECT DISTINCT personId,Name, orderId from person LEFT JOIN `order` on person.personId = `order`.driverId where person.state='driver';

SELECT orderId,O.state,Name FROM `order` O LEFT JOIN person on driverId = personId;

SELECT R.name as r_name,R.town as r_town,R.street as r_street,orderId,P.Name,P.Town,P.Street,P.personId FROM `order` LEFT JOIN person D on `order`.driverId = D.personId INNER JOIN person P on `order`.dinerId = P.personId JOIN restaurant R on R.restaurantId=`order`.restaurantId where D.personId=14;

update person set state = "admin" where mail = "w@w";

UPDATE restaurant SET name = "smth", description = "a", town = "a", street = "a", zip = 12345, phoneNumber = "a", openingTime = TIME("07:00:00"), closureTime =TIME("07:00:00") WHERE restaurantId = 3;


SELECT O.orderId,O.state, SUM(price)from `order` O NATURAL JOIN orderHasItem NATURAL JOIN item GROUP BY orderId,state;
SELECT R.name,orderId,O.state FROM `order` O INNER JOIN person P on P.personId=O.dinerId LEFT JOIN restaurant R on O.restaurantId=R.restaurantId WHERE dinerId=10;
SELECT i.name,i.description,picture,price, isVegan,isGlutenFree FROM `order` O NATURAL JOIN orderHasItem NATURAL JOIN item i  where orderId = 20

SELECT * from `order`;
SELECT * from person;

insert into item values (145, "Burritos", "lasagne decrip", "/img/lasagne.jpg", 7.9, "dailyMenu", true, false);
insert into item values (146, "Burritos2", "lasagne decrip", "/img/lasagne.jpg", 7.9, "dailyMenu", true, false);
insert into restaurantHasItem values (4, 145);
insert into restaurantHasItem values (4, 146);

delete item, restaurantHasItem FROM item inner join restaurantHasItem on item.itemId = restaurantHasItem.itemId WHERE restaurantHasItem.restaurantId = 4;
