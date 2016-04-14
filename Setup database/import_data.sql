delete from school^
delete from restaurant^

import from pubschls.csv of del insert into school (name,street,city,state,zip,county,long,lat)^
update school set loc = db2gse.ST_Point(long, lat, 1)^


import from restaurant.csv of del insert into restaurant (name,street,city,state,zip,county,long,lat)^
update restaurant set loc = db2gse.ST_Point(long, lat, 1)^
