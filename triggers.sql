drop trigger if exists udpateRestaurantTagsAfterHasItemInsert;
drop trigger if exists udpateRestaurantTagsAfterHasItemDelete;
drop trigger if exists udpateRestaurantTagsAfterHasItemUpdate;
drop trigger if exists udpateRestaurantTagsAfterItemUpdate;


-- When you insert to restaurantHasItem, update restaurant isVegan and isGlutenFree tags
-- If newly assigned item has any tag, update restaruant tags
delimiter $$
CREATE TRIGGER udpateRestaurantTagsAfterHasItemInsert
AFTER INSERT
ON restaurantHasItem FOR EACH ROW
BEGIN
    /*Vegan tag*/
    IF ((select isVegan from item where itemId = NEW.itemId) = TRUE and (select isInMenu from item where itemId = NEW.itemId) = TRUE) THEN
      update restaurant set hasVeganItems = TRUE where restaurant.restaurantId = NEW.restaurantId;
    END IF;


    /*Gluten tag*/
    IF ((select isGlutenFree from item where itemId = NEW.itemId) = TRUE and (select isInMenu from item where itemId = NEW.itemId) = TRUE) THEN
      update restaurant set hasVeganItems = TRUE where restaurant.restaurantId = NEW.restaurantId;
    END IF;
END;$$
delimiter ;


-- When you delete from restaurantHasItem, update restaurant isVegan and isGlutenFree tags
-- If restaruant where we unassigned item, dont have any items with tags anymore, update restaruant tags
delimiter $$
CREATE TRIGGER udpateRestaurantTagsAfterHasItemDelete
AFTER DELETE
ON restaurantHasItem FOR EACH ROW
BEGIN
    /*Vegan tag*/
    IF ((select isVegan from item where itemId = OLD.itemId) = TRUE  and (select isInMenu from item where itemId = OLD.itemId) = TRUE) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where restaurant.restaurantId = OLD.restaurantId and item.isVegan = TRUE and item.isInMenu = TRUE) = 0) THEN
          update restaurant set hasVeganItems = FALSE where restaurant.restaurantId = OLD.restaurantId;
      END IF;
    END IF;


    /*Gluten tag*/
    IF ((select isGlutenFree from item where itemId = OLD.itemId) = TRUE  and (select isInMenu from item where itemId = OLD.itemId) = TRUE) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where restaurant.restaurantId = OLD.restaurantId and item.isGlutenFree = TRUE and item.isInMenu = TRUE) = 0) THEN
          update restaurant set hasVeganItems = FALSE where restaurant.restaurantId = OLD.restaurantId;
      END IF;
    END IF;    
END;$$
delimiter ;


-- When you update in restaurantHasItem, update restaurant isVegan and isGlutenFree tags
-- Combined previous triggers
delimiter $$
CREATE TRIGGER udpateRestaurantTagsAfterHasItemUpdate
AFTER UPDATE
ON restaurantHasItem FOR EACH ROW
BEGIN
    /*Vegan tag*/
    IF ((select isVegan from item where itemId = OLD.itemId) = TRUE and (select isVegan from item where itemId = NEW.itemId) = FALSE and (select isInMenu from item where itemId = OLD.itemId) = TRUE) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where restaurant.restaurantId = OLD.restaurantId and item.isVegan = TRUE and item.isInMenu = TRUE) = 0) THEN
          update restaurant set hasVeganItems = FALSE where restaurant.restaurantId = OLD.restaurantId;
      END IF;
    END IF;

    IF ((select isVegan from item where itemId = NEW.itemId) = TRUE and (select isInMenu from item where itemId = NEW.itemId) = TRUE) THEN
      update restaurant set hasVeganItems = TRUE where restaurant.restaurantId = NEW.restaurantId;
    END IF;

    /*Gluten tag*/
    IF ((select isGlutenFree from item where itemId = OLD.itemId) = TRUE and (select isGlutenFree from item where itemId = NEW.itemId) = FALSE and (select isInMenu from item where itemId = OLD.itemId) = TRUE) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where restaurant.restaurantId = OLD.restaurantId and item.isGlutenFree = TRUE and item.isInMenu = TRUE) = 0) THEN
          update restaurant set hasVeganItems = FALSE where restaurant.restaurantId = OLD.restaurantId;
      END IF;
    END IF;

    IF ((select isGlutenFree from item where itemId = NEW.itemId) = TRUE and (select isInMenu from item where itemId = NEW.itemId) = TRUE) THEN
      update restaurant set hasVeganItems = TRUE where restaurant.restaurantId = NEW.restaurantId;
    END IF;    
END;$$
delimiter ;


-- When you update item, update restaurant isVegan and isGlutenFree tags
delimiter $$
CREATE TRIGGER udpateRestaurantTagsAfterItemUpdate
AFTER UPDATE
ON item FOR EACH ROW
BEGIN

    /*Vegan tag*/
    IF ((OLD.isVegan = TRUE and NEW.isVegan = FALSE and OLD.isInMenu = TRUE) or (OLD.isInMenu = TRUE and NEW.isInMenu = FALSE)) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where item.isVegan = TRUE and item.isInMenu = TRUE and restaurant.restaurantId in (
          select restaurant.restaurantId from restaurant 
          inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
          where restaurantHasItem.itemId = OLD.itemId
        )) = 0) THEN
          update restaurant 
          inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
          set hasVeganItems = FALSE 
          where restaurantHasItem.itemId = OLD.itemId;
      END IF;
    END IF;

    IF (NEW.isVegan = TRUE and NEW.isInMenu = TRUE) THEN
      update restaurant
      inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
      set hasVeganItems = TRUE where restaurantHasItem.itemId = NEW.itemId;
    END IF;


    /*Gluten tag*/
    IF ((OLD.isGlutenFree = TRUE and NEW.isGlutenFree = FALSE and OLD.isInMenu = TRUE) or (OLD.isInMenu = TRUE and NEW.isInMenu = FALSE)) THEN
      IF ((select count(*) from restaurant 
        inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
        inner join item on restaurantHasItem.itemId = item.itemId
        where item.isGlutenFree = TRUE and item.isInMenu = TRUE and restaurant.restaurantId in (
          select restaurant.restaurantId from restaurant 
          inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
          where restaurantHasItem.itemId = OLD.itemId
        )) = 0) THEN
          update restaurant 
          inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
          set hasVeganItems = FALSE 
          where restaurantHasItem.itemId = OLD.itemId;
      END IF;
    END IF;

    IF (NEW.isGlutenFree = TRUE and NEW.isInMenu = TRUE) THEN
      update restaurant
      inner join restaurantHasItem on restaurant.restaurantId = restaurantHasItem.restaurantId
      set hasVeganItems = TRUE where restaurantHasItem.itemId = NEW.itemId;
    END IF;
END;$$
delimiter ;
