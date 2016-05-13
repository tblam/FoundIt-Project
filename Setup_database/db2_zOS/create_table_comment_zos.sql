connect to stlec1 user sysadm using c0deshop^ 

drop table comment^

create table comment
(
	id_house varchar(10) not null references house(MLSNumber) on delete cascade,
	userID int not null references user(userID) on delete cascade,
	contentPost varchar(1000) not null,
	timePost timestamp not null
)^

select * from comment^

select name, owner from sysibm.systables where owner = 'SYSADM'^
