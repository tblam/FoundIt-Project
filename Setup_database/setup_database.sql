--Delete existing database with same name "foundit"
drop database foundit^

--Create database "foundit" with pagesize set to 32K. This process takes around 5 minutes
create database foundit pagesize 32768^

--Check if the database is created successfully
--list database directory^

--Start to connect to the "foundit" database
connect to foundit^

--Change number of page for the bufferpool to 32K
--alter bufferpool ibmdefaultbp size 32768^

--Check if the the number of page and pagesize is set to 32K
--select bpname, npages, pagesize from syscat.bufferpools^

--Check if the 
--list tablespaces show detail^

--Enable the spatial operation for the database by MANUALLY type in the following statement: db2se enable_db foundit
db2se enable_db foundit^