--db2 -td"^" -f create_crime.sql
 
drop table sex_offenders^

CREATE TABLE sex_offenders(
	lastname varchar(32),
	firstname varchar(32),
	dob varchar(10),	
	gender char(1),	
	street varchar(64),	
	city varchar(32),
	state char(2),
	zip integer,
	lat double,
	long double,
	loc db2gse.st_point 
	)^

import from sexOffenders.csv of del insert into sex_offenders(lastname, firstname, dob, gender, street, city, state, zip, lat, long)^ 

update house set loc = db2gse.ST_Point(long, lat, 1)^

describe table sex_offenders^

--db2 EXPORT TO sexOffenders.csv OF DEL MODIFIED BY NOCHARDEL select last_name, first_name, dob, gender, street, city, state, zip, lat, long from sex_offenders