--select INTERSECTION from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY'^

--EXPORT TO house_fusion.csv OF DEL MODIFIED BY NOCHARDEL select status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age, long, lat from house^

select INTERSECTION 
	from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION 
		from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY'^

--update floodzone set city = 'Milpitas' where cast(db2gse.ST_AsText(shape) as VARCHAR (20000)) IN (select INTERSECTION 
--	from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION 
--		from floodzone a, city_boundary b where b.name = 'Milpitas') where INTERSECTION <> 'POINT EMPTY')^


--Select city from floodzone where city is not null^

<div style="text-align:center; font-size:17px;">
<a href="forum.php?house={MLSNumber}">
<b>{address}, {City}</b>
</a>
</div>

<div style="font-size:14px;"><b>Bedrooms: </b> {BedsTotal}<br> 
<b>Bathrooms: </b>{BathsTotal}<br>
<b>Area: </b>{SqftTotal} sqft<br>
<b>Lot Size Area: </b>{LotSizeArea_Min} sqft<br>
<b>Age: </b>{Age} year(s)<br>
<b>Price: </b>$ numberWithThousandSep({CurrentPrice})<br>
<b>MLSNumber: </b>{MLSNumber} 
</div>