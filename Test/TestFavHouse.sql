--test favorite house
drop table favoriteHouse^
create table favoriteHouse
(
	userID int not null references user(userID) on delete cascade,
	id_house varchar(10) references house(MLSNumber) on delete cascade
)^

--test favorite house
insert into favoriteHouse (userID, id_house) values (101, 'ML81522308')^
insert into favoriteHouse (userID, id_house) values (101, 'ML81561337')^
insert into favoriteHouse (userID, id_house) values (101, 'ML81550581')^

--test user log in
insert into user (firstname, lastname, email, password) values ('Luan', 'Bui', 'mluan1110@gmail.com', 'pass')^
insert into user (firstname, lastname, email, password) values ('Tran', 'Lam', 'tblam55@gmail.com', 'tran')^

select * from user^

