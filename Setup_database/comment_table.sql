--db2 -td"^" -f create.sql

--create bufferpool bp8k pagesize 8 k^
--create system temporary tablespace tmpsys8k pagesize 8 k bufferpool bp8k^
--db2se enable_db cs174^

drop table comment^

create table comment
(
	id_house varchar(10) not null references house(MLSNumber) on delete cascade,
	userID int not null references user(userID) on delete cascade,
	contentPost varchar(1000) not null,
	timePost timestamp not null
)^
