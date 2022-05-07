
DROP PROCEDURE IF EXISTS Procedure1;
DROP PROCEDURE IF EXISTS Procedure2;
DROP PROCEDURE IF EXISTS Procedure3;
DROP PROCEDURE IF EXISTS Procedure4;
DROP PROCEDURE IF EXISTS Procedure5;
DROP PROCEDURE IF EXISTS Procedure6;
DROP PROCEDURE IF EXISTS Procedure7;
DROP PROCEDURE IF EXISTS Procedure8;
DROP PROCEDURE IF EXISTS Procedure9;
DROP PROCEDURE IF EXISTS Procedure10;
DROP PROCEDURE IF EXISTS Procedure11;
DROP PROCEDURE IF EXISTS Procedure12;
DROP PROCEDURE IF EXISTS Procedure13;
DROP PROCEDURE IF EXISTS Procedure14;
DROP PROCEDURE IF EXISTS Procedure15;

DELIMITER //
--PROCEDURE 1
CREATE PROCEDURE Procedure1()
BEGIN

        select metroAreaName, avg(gdp), avg(averageHousePrice), avg(population)
        from MetroArea
        natural join
                (select metroAreaName
                from Team
                group by metroAreaName
                having count(distinct sport) = 4) as M
        group by metroAreaName;
        
END; //

--PROCEDURE 2

DELIMITER ;
