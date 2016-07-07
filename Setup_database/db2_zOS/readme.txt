Go into folder "files" and follow the steps below

1. Follow the "Setting up EC" file 

2. Follow the "Importing shapefile to zOS" file
	Apply to the shapefiles: cities2015 and floodzone. 
	Located at \Setup_database\data\Shapefiles

3. Connect to the database, stlec1. Use password: c0deshop
	db2 connect to stlec1 user sysadm

4. CD to {DB2InstallDir}/sqllib/bnd
	cd C:\Program Files\IBM\SQLLIB\bnd
	
5. Use the 2 following commands to bind the package to the database
	db2 bind @db2cli.lst blocking all grant public sqlerror continue
	db2 bind @db2ubind.lst blocking all grant public sqlerror continue

6. CD to this folder, containing the script and run them IN ORDER
	cd C:\xampp\htdocs\foundit\Setup_database\db2_zOS
	db2 -td"^" -f create_table_houses.sql
	db2 -td"^" -f create_tables_zos.sql
	db2 -td"^" -f create_crime_zos.sql
	db2 -td"^" -f create_table_comment_zos.sql
	db2 -td"^" -f create_table_school.sql
