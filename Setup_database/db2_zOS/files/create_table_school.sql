--db2 export to school.ixf of ixf select name,type,api,staterank,address,city,county,zipcode,state,long,lat from school

connect to stlec1 user sysadm using c0deshop^

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
	lat double
)^

import from school.ixf of ixf insert into school^

select * from school^

select name, owner from sysibm.systables where owner = 'SYSADM'^

