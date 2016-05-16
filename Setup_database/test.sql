--select INTERSECTION from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY'^

--EXPORT TO house_fusion.csv OF DEL MODIFIED BY NOCHARDEL select status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age, long, lat from house^

--select INTERSECTION 
--	from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION 
--		from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY'^

--update floodzone set city = 'Milpitas' where cast(db2gse.ST_AsText(shape) as VARCHAR (20000)) IN (select INTERSECTION 
--	from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION 
--		from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY')^


--Select city from floodzone where city is not null^

--import from C:\Users\IBM_ADMIN\Desktop\download.jpg method p(1) insert into user (image) where userID = 100^

insert into user (image) values (blob('C:\Users\IBM_ADMIN\Desktop\download.jpg')) where userID = 100^