--db2 -td"^" -f createhouse.sql

--create bufferpool bp8k pagesize 8 k^
--create system temporary tablespace tmpsys8k pagesize 8 k bufferpool bp8k^
--db2 connect to sample^

drop table house^

create table house 
(
	status varchar(10), 
	AdditionalListingInfo varchar (50),
	MLSNumber varchar (20),
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
	Age integer
)^

import from SantaClaraListing.csv of del insert into house^
import from SanMateoAlamedaListings.csv of del insert into house^
