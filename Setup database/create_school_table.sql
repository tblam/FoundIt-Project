drop table school^

create table school
(
	name varchar(50), 
	type varchar(25),
	API integer, 
	staterank integer,
	address varchar (70),
	city varchar (40),
	county varchar(40),
	zipcode integer,
	state char(2),  
	long double,
	lat double,
	loc DB2GSE.ST_POINT
)^

import from schools.csv of del insert into school (name, type, API, staterank, address, city, county, zipcode, state, long, lat)^
update school set loc = db2gse.ST_Point(long, lat, 1)^

--import from AlamedaCountySchools.csv of del insert into school (name, staterank, address, api, type)^
--import from SanMateoCountySchools.csv of del insert into school (name, staterank, address, api, type)^
--import from SantaClaraCountySchools.csv of del insert into school (name, staterank, address, api, type)^

--db2 EXPORT TO schools.csv OF DEL MODIFIED BY NOCHARDEL select name, type, api, staterank, address, city, county, zipcode, state,long,lat from school