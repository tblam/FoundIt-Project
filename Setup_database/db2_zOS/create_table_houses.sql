--export to house.ixf of ixf select status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age, long, lat from house^

connect to stlec1 user sysadm using c0deshop

drop table house^

create table house 
(
	status varchar(10), 
	AdditionalListingInfo varchar (70),
	MLSNumber varchar (10) not null primary key,
	address varchar(70),
	CurrentPrice integer,
	DOM integer,
	BathsTotal integer,
	BedsTotal integer,
	BathsFull integer,
	BathsHalf integer,
	SqftTotal integer,
	LotSizeArea_Min double,
	City varchar(20),
	Age integer,
	long double,
	lat double
)^

import from house.ixf of ixf insert into house^

select * from house^

select name, owner from sysibm.systables where owner = 'SYSADM'^

