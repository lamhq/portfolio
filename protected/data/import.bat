d:\program\mysql\bin\mysql -u root -e "drop database myapp"; 
d:\program\mysql\bin\mysql -u root -e "create database myapp DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_unicode_ci;";
d:\program\mysql\bin\mysql -u root myapp < data.sql

