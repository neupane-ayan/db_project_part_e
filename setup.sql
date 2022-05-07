
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
-- Procedure 1
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

-- Procedure 2
CREATE PROCEDURE Procedure2(IN tm VARCHAR(3), IN spt VARCHAR(20))
BEGIN

	IF EXISTS (select * from Team where teamName = tm and sport = spt) THEN
           select distinct teamName, sport, count(hallOfFame) as 'numHoF'
           from PlaysOn
           natural join Player
           where hallOfFame=1 and teamName = tm and sport = spt
           group by teamName, sport;
	ELSE
	   select 'ERROR' as teamName;
	END IF;
        
END; //

-- Procedure 3
CREATE PROCEDURE Procedure3(IN yr CHAR(10))
BEGIN
	IF yr > '2000-01-01' and yr < '2021-01-01' THEN
           select `year`, avg(gdp)
       	   from MetroArea as A
       	   natural join
                   (select champion, S.sport as sport, metroAreaName, `year`
                   from Team as T
                   inner join Season as S
                   on T.sport = S.sport and T.teamName = S.champion) as B
           group by `year`
	   having `year` = yr;
	ELSE
	   SELECT 'ERROR' AS `year`;
	END IF;
        
END; //

-- Procedure 4
CREATE PROCEDURE Procedure4(IN numTeams INT)
BEGIN

	IF numTeams > 0 THEN
           select *
           from MetroArea
       	   natural join
                (select metroAreaName, `year`
                from TeamRecord
                natural join Team
                where wins/(wins+losses) >= 0.5
                group by metroAreaName, `year`
                having count(*) >= numTeams) as A;
	ELSE
	   select 'ERROR' as metroAreaName;
	END IF;
        
END; //

-- Procedure 5
CREATE PROCEDURE Procedure5(IN mtrA VARCHAR(50))
BEGIN
	IF EXISTS (select * from MetroArea where metroAreaName = mtrA) THEN
           select metroAreaName, count(distinct mvp) as 'numMVP'
           FROM Team NATURAL JOIN Season
           group by metroAreaName
	   having metroAreaName=mtrA;
	ELSE
	   select 'ERROR' as metroAreaName;
	END IF;
        
END; //

-- Procedure 6
CREATE PROCEDURE Procedure6()
BEGIN

        
        select avg(gdp) as avggdp
        from MetroArea
        natural join
                (select *
                from Team
                natural join
                        (select *
                        from PlaysOn
                        natural join 
                                (select S.sport as sport, `year`, playerName, playerID
                                from Season as S
                                inner join Player as P
                                on S.mvp = P.playerName) as A
                        ) as B
                )as C;
        
END; //

-- Procedure 7
CREATE PROCEDURE Procedure7()
BEGIN

	SELECT metroAreaName, gdp, avg(winPct) as 'winPercent'
        FROM(
		SELECT *, (wins/(wins+losses) * 100.00) as 'winPct'
                from ((TeamRecord NATURAL JOIN Team) NATURAL JOIN (
                        SELECT `year`, avg(gdp) as 'avgGDP'
                        from MetroArea
                        GROUP BY `year`) as yearAvg)
                        NATURAL JOIN MetroArea
                WHERE gdp > avgGDP) as topMetros
        GROUP BY metroAreaName;
        
END; //

-- Procedure 8
CREATE PROCEDURE Procedure8(IN mtrA VARCHAR(50))
BEGIN


	IF EXISTS (SELECT * FROM MetroArea WHERE metroAreaName = mtrA) THEN
           SELECT metroAreaName, (maxGDPwins-minGDPwins)       
           FROM
                (SELECT metroAreaName, sum(wins) as 'maxGDPwins'
                FROM        
                        ((SELECT MetroArea.metroAreaName, MetroArea.`year`, maxgdp
                        FROM(        
                                SELECT metroAreaName, `year`, max(gdp) as 'maxgdp'
                                FROM MetroArea
                                GROUP BY metroAreaName) as maxGdpYear
                        JOIN MetroArea ON MetroArea.metroAreaName=maxGdpYear.MetroAreaName
                        WHERE gdp=maxgdp) as maxGDPs
                        NATURAL JOIN Team) NATURAL JOIN TeamRecord
                GROUP BY metroAreaName) as maxWins        
                NATURAL JOIN
                (SELECT metroAreaName, sum(wins) as 'minGDPwins'
                FROM
                        ((SELECT MetroArea.metroAreaName, MetroArea.`year`, mingdp
                        FROM(        
                                SELECT metroAreaName, `year`, min(gdp) as 'mingdp'
                                FROM MetroArea
                                GROUP BY metroAreaName) as minGdpYear
                        JOIN MetroArea ON MetroArea.metroAreaName=minGdpYear.MetroAreaName
                        WHERE gdp=mingdp) as minGDPs
                        NATURAL JOIN Team) NATURAL JOIN TeamRecord
                GROUP BY metroAreaName) as minWins
	     WHERE metroAreaName = mtrA;
	 ELSE
	     SELECT 'ERROR' AS metroAreaName;
	 END IF;
        
END; //

-- Procedure 9
CREATE PROCEDURE Procedure9(IN mtrA VARCHAR(50))
BEGIN

	IF EXISTS (SELECT * FROM MetroArea WHERE metroAreaName = mtrA) THEN
           select metroAreaName, numTeams, avg(population) as avgpopulation, avg(gdp) as avggdp
           from MetroArea
           natural join
                (select metroAreaName, count(*) as numTeams
                from Team
                group by metroAreaName) as N
           group by metroAreaName
	   having metroAreaName = mtrA
           order by numTeams desc, metroAreaName asc;
	ELSE
	   select 'ERROR' as metroAreaName;
	END IF;
        
END; //

-- Procedure 10
CREATE PROCEDURE Procedure10(IN mtrA VARCHAR(50))
BEGIN

	IF EXISTS (select * from MetroArea where metroAreaName = mtrA) THEN
           select D.metroAreaName as metroAreaName, sport, `year`, gdp, D.winPercent as winPercent
           from      
                (select B.teamName as teamName, B.sport as sport, `year`, B.winPercent as winPercent, metroAreaName, gdp 
                from
                        (select teamName, sport, `year`, wins/(wins+losses) as winPercent, metroAreaName, gdp
                        from TeamRecord
                        natural join
                                (select *
                                from MetroArea
                                natural join Team) as A)as B
                join
                        (select sport, teamName, max(wins/(wins+losses)) as winPercent
                        from TeamRecord
                        group by teamName, sport) as C
                on B.teamName = C.teamName and B.sport = C.sport and B.winPercent = C.winPercent) as D
           join
                (select max(wins/(wins+losses)) as winPercent, metroAreaName
                from TeamRecord
                natural join
                        (select *
                        from MetroArea
                        natural join Team) as A
                group by metroAreaName) as E
           on D.winPercent = E.winPercent and D.metroAreaName = E.metroAreaName;
	ELSE
	   select 'ERROR' as metroAreaName;
	END IF;
        
END; //

-- Procedure 11
CREATE PROCEDURE Procedure11()
BEGIN        

        select metroAreaName, `year`, gdp, averageHousePrice
        from MetroArea
        natural join
                (select `year`, metroAreaName
                from Season as S
                join Team as T
                on S.champion = T.teamName and S.sport = T.sport
                group by `year`, metroAreaName
                having count(S.sport) > 1) as A;
        
END; //

-- Procedure 12
CREATE PROCEDURE Procedure12()
BEGIN        

        select metroAreaName, `year`, gdp, averageHousePrice
        from MetroArea
        natural join
                (select `year`, metroAreaName
                from Player
                natural join PlaysOn
                natural join Team
                where hallOfFame=1
                group by `year`, metroAreaName
                having count(playerID) > 4) as A
        order by `year`, metroAreaName;
        
END; //

-- Procedure 13
CREATE PROCEDURE Procedure13()
BEGIN        

        SELECT metroAreaName, '2001-2010' as decade, count(hallOfFame) as 'numHoF'
        FROM
                ((PlaysOn NATURAL JOIN Team) NATURAL JOIN MetroArea) NATURAL JOIN Player
                WHERE hallOfFame=1 AND `year` >= '2001-01-01 00:00:00' AND `year` <= '2010-01-01 00:00:00'
                GROUP BY metroAreaName
        UNION
                SELECT metroAreaName, '2011-2020' as decade, count(hallOfFame) as 'numHoF'
                FROM
                        ((PlaysOn NATURAL JOIN Team) NATURAL JOIN MetroArea) NATURAL JOIN Player
                WHERE hallOfFame=1 AND `year` >= '2011-01-01 00:00:00' AND `year` <= '2020-01-01 00:00:00'
        GROUP BY metroAreaName
        ORDER BY numHoF DESC;
        
END; //

-- Procedure 14
CREATE PROCEDURE Procedure14()
BEGIN        

        select metroAreaName, avg(gdp) as avggdp, championships
        from MetroArea
        natural join
                (select metroAreaName, count(*) as championships
                from Season as S
                join Team as T
                on S.champion = T.teamName and S.sport = T.sport
                group by metroAreaName
                having count(*) > 4) as C
        group by metroAreaName
        order by championships desc, metroAreaName asc;
        
END; //

-- Procedure 15
CREATE PROCEDURE Procedure15()
BEGIN        

        SELECT sport, avg(gdp) FROM
                (SELECT Season.sport, Season.`year`, champion, metroAreaName FROM Season JOIN Team
                ON Season.sport = Team.sport AND Season.champion = Team.teamName) as teamSeason
        JOIN MetroArea
        ON MetroArea.metroAreaName=teamSeason.metroAreaName AND MetroArea.`year`=teamSeason.`year`
        GROUP BY sport;
        
END; //

DELIMITER ;

