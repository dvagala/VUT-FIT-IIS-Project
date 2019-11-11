drop table restaurantHasItem;
drop table itemWillBeInMenu;
drop table restaurant;
drop table item;


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
  type ENUM("dailyMenu", "sauce", "meal", "beverage"),
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

insert into restaurant values (1, "purkynka", "brno", "purkynova", 61200, TIME("13:10:11"));
insert into item values (101, "spaghetti", "Delicious spaghetti", "/img/spaghetti.jpg", 3, "meal", true, true, false);

insert into item values (102, "lasagne", "lasagne decrip", "/img/lasagne.jpg", 6, "dailyMenu", false, false, false);

insert into restaurantHasItem values (1, 101);
insert into restaurantHasItem values (1, 102);
insert into itemWillBeInMenu values (102, DATE("2017-07-23"));

select * from restaurant;
select * from item;
select * from restaurantHasItem;
select * from itemWillBeInMenu;

