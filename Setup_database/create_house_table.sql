--db2 -td"^" -f createhouse.sql

drop table house^


create table house 
(
	status varchar(10), 
	AdditionalListingInfo varchar (70),
	MLSNumber varchar (15),
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
	lat double,
	loc DB2GSE.ST_POINT
)^

import from houses.csv of del insert into house (status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age, long, lat)^ 

update house set loc = db2gse.ST_Point(long, lat, 1)^
