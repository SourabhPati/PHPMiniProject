CREATE DATABASE school;
use school;
CREATE TABLE `school`.`Teacher` ( `Teacher_ID` INT NOT NULL , `Name` TEXT NOT NULL , `Free_Periods` INT NOT NULL , `Subject` TEXT NOT NULL , PRIMARY KEY (`Teacher_ID`)) ENGINE = InnoDB;);
