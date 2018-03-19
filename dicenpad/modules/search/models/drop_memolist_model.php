SELECT jd_crew.crew_id,
CONCAT("<li><b>", CONCAT(jd_position.code, " ",  jd_crew.fullname), "</b> <br/> ", 
(SELECT GROUP_CONCAT(document SEPARATOR ", ") 
FROM jd_crew_docs
INNER JOIN jd_document ON jd_document.id = jd_crew_docs.docs_id
WHERE jd_crew_docs.published = 1 AND jd_crew_docs.crew_id = jd_onboard.crew_id
GROUP BY crew_id ORDER BY jd_document.defaults, jd_document.id ), "<br/></li>") AS crew_document,

 jd_crew.fullname, jd_crew.birthdate, jd_crew.birthplace, jd_crew.pres_address, jd_crew.photo, jd_crew.hash,
 jd_crew.date_hired, jd_department.option AS department, jd_division.option AS division, jd_onboard.isdone, jd_position.code, jd_position.position, 
 CONCAT(jd_vessels.prefix, " ", jd_vessels.vessel_name) AS vessel_name, jd_onboard.start_date, jd_onboard.end_date, jd_onboard.vessel_id, 
 jd_vessels.code AS vcode, jd_flag.flag, jd_onboard.disembarked, jd_onboard.embarked, jd_onboard.position_id, jd_vessels.official_nos, 
 jd_vessels.imo_nos, jd_vessels.gross, jd_vessels.classification, jd_vessels.e_year, jd_vessels.builder, jd_principal.fullname AS principal, 
 jd_principal.address AS prin_address, jd_onboard.joining_port, 12 * (YEAR(jd_onboard.end_date) - YEAR(jd_onboard.start_date)) + (MONTH(jd_onboard.end_date) - MONTH(jd_onboard.start_date)) AS duration, 
 (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_nos, 
 (SELECT date_expired FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 1 LIMIT 1) AS seaman_expiry, 
 (SELECT endorsement FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 12 LIMIT 1) AS endorsement, 
 (SELECT docs_nos FROM jd_crew_docs WHERE crew_id = jd_crew.crew_id AND docs_id = 3 LIMIT 1) AS passport
 FROM (`jd_crew`)
 INNER JOIN `jd_onboard` ON `jd_crew`.`crew_id` = `jd_onboard`.`crew_id`  
 INNER JOIN `jd_vessels` ON `jd_onboard`.`vessel_id` = `jd_vessels`.`id`
 INNER JOIN `jd_position` ON `jd_onboard`.`position_id` = `jd_position`.`id`
 LEFT JOIN `jd_principal` ON `jd_vessels`.`principal_id` = `jd_principal`.`id`
 LEFT JOIN `jd_department` ON `jd_position`.`department_id` = `jd_department`.`id`
 LEFT JOIN `jd_division` ON `jd_position`.`division_id` = `jd_division`.`id`
 LEFT JOIN `jd_flag` ON `jd_vessels`.`flag_id` = `jd_flag`.`id`
 WHERE `jd_onboard`.`vessel_id` = '220' AND (start_date <= '2014-02-10' AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '2014-02-10')
 AND `onboard_id` = (SELECT MAX(onboard_id) FROM jd_onboard 
 WHERE crew_id = jd_crew.crew_id AND (start_date <= '2014-02-10'
 AND (IF(disembarked=0000-00-00, end_date, disembarked)) >= '2014-02-10') AND crew_id = jd_onboard.crew_id ORDER BY start_date DESC)
 ORDER BY `jd_position`.`sort_order`, `jd_onboard`.`start_date` ASC LIMIT 150
