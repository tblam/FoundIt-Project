--db2 -td"^" -f createhouse.sql

--create bufferpool bp8k pagesize 8 k^
--create system temporary tablespace tmpsys8k pagesize 8 k bufferpool bp8k^
--db2 connect to sample^

drop table house^


create table house 
(
	status varchar(10), 
	AdditionalListingInfo varchar (20),
	MLSNumber varchar (15),
	address char(50),
	CurrentPrice integer(10),
	DOM integer(5),
	BathsTotal integer(2),
	BedsTotal integer(2),
	BathsFull integer(2),
	BathsHalf integer(2),
	SqftTotal integer(10),
	LotSizeArea_Min double,
	City varchar(20),
	Age integer,
)^

