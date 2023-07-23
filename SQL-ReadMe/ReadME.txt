#Currency Converter task for Procon 
#Made by Christos Beroukas

To run the Project after the download and after you have run the sql script to your database (which you will find inside this file). Open the terminal go to directory of the file and run the commands: 
1)npm install 
2)composer install (you will need to download composer if you don't have it already)(don't worry if you see some Warnings it will still do the installation just takes some time)
3)then go to .env file and look if your DATABASE_URL is correct  
4)symfony server:start (To start the server. Keep this terminal running and open another terminal)(you will need to download symfony if you don't have it already)
5)yarn encore dev --watch(in the other terminal .)(Keep this terminal running)
Ready to use Currency Converter :D
#########################
#Users credentials for logging in :

#Simple User: 
#Email : 'test@test.com' , Password: 1234

#Admin User:
#Email : 'testadmin@testadmin.com' , Password: 1234
#########################
#Project Using:
#Symfony version : 6.1.12

#DATABASE :
#Server type:MariaDB , Server Version :10.4.27 using MySQL
#Database Username: 'root' , Password :'' (Doesn't have)
#Database URL :DATABASE_URL="mysql://root@127.0.0.1:3306/currency_calculator?serverVersion=15&charset=utf8"

#PHP version:8.2.0
#
#React Version :18.2.0
#React-Dom :18.2.0 




