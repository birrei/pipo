
/*

Problemstellung: Aufgrund technischer Einschränkungen funktioniert das Versenden an alle Empfänger in Tabelle "Newsletter" (über Einfügen in BCC) nicht mehr 

Aufgabe: Die Einträge in Tabelle "Newsletter" müssen in einzelne Gruppen von ca. 200 Zeilen aufgeteilt werden. 

Umsetzung: 
* Gruppen werden als Views auf Tabelle "Newsletter" abgebildet. 
* Jede Gruppe enthält 200 Mitglieder. 
* Die jeweils letzte Gruppe (Stand 23.09.2026) wird so lange verwendet, bis sie max. 200 Mitglieder enth�lt
* Hinweis: Wenn Gruppe 4 mehr ca. 200 Zeilen enthlt, muss eine neue Gruppe gebildet werden 

Umsetzung Stand 24.09.2026 s.u. 

*/


---------------------------------- Gruppe 1: 

-- SELECT MAX(ID) 
-- FROM (
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- Order by ID  
-- LIMIT 200
-- ) auswahl 
-- 1 - 398


-- DROP VIEW Newsletter_01; 
-- CREATE VIEW Newsletter_01 AS 
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- AND ID BETWEEN 1 AND 398 
-- ; 
-- SELECT COUNT(*) FROM Newsletter_01
-- ; 

---------------------------------- Gruppe 2: 



-- SELECT MAX(ID) 
-- FROM (
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- AND ID > 398
-- Order by ID  
-- LIMIT 200
-- ) auswahl 
-- 399 - 830


-- DROP VIEW Newsletter_02; 
-- CREATE VIEW Newsletter_02 AS 
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- AND ID BETWEEN 399 AND 830 
-- ; 
-- SELECT COUNT(*) FROM Newsletter_02
-- ; 


---------------------------------- Gruppe 3



-- SELECT MAX(ID) 
-- FROM (
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- AND ID > 830
-- Order by ID  
-- LIMIT 200
-- ) auswahl 


-- 830 - 1099


-- DROP VIEW Newsletter_03; 
-- CREATE VIEW Newsletter_03 AS 
-- SELECT * 
-- FROM Newsletter 
-- WHERE freigeschaltet=1 
-- AND ID BETWEEN 831 AND 1099 
-- ; 
-- SELECT COUNT(*) FROM Newsletter_03
-- ; 

---------------------------------- Gruppe 4 (aktuell letzte nach oben offene Gruppe) 


SELECT MAX(ID) 
FROM (
SELECT * 
FROM Newsletter 
WHERE freigeschaltet=1 
AND ID > 1099
Order by ID  
LIMIT 200
) auswahl 

-- 1100 - 1265


DROP VIEW Newsletter_04; 
CREATE VIEW Newsletter_04 AS 
SELECT * 
FROM Newsletter 
WHERE freigeschaltet=1 
AND ID >= 1100 
; 
SELECT COUNT(*) FROM Newsletter_04
; 





