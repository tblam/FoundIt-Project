--export to crime.ixf of ixf select lastname, firstname, dob, gender, street, city, state, zip, lat, long from sex_offenders
 
connect to stlec1 user sysadm using c0deshop

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
	long double 
	)^

import from crime.ixf of ixf insert into sex_offenders^

select * from sex_offenders^

select name, owner from sysibm.systables where owner = 'SYSADM'^