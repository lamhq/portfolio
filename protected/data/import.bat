d:\program\mysql5.6\bin\mysql -u root -e "drop database portfolio"; 
d:\program\mysql5.6\bin\mysql -u root -e "create database portfolio DEFAULT CHARACTER SET utf8  DEFAULT COLLATE utf8_unicode_ci;";
d:\program\mysql5.6\bin\mysql -u root portfolio < data.sql

