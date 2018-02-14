# Basket-XML

## Installation
Using Composer :

```
composer install
```

If you don't have composer, you can get it from [Composer](https://getcomposer.org/)

## Run the application
```
php artisan migrate
```
```
php artisan db:seed --class=UsersTableSeeder
```

## Steps:
* Register a new user or login to the ystem using the user created by Seed (admin@basket.com/123456).
* In Home page, you need to register an API user. Then you have to login (API Login) to have the authorization to use the web services. (This will return a token).
* Use the generated token in every request.

Note: In my example i used a fixed token.



## Add new file structure 
* In case you need to add a new file structure (ex. CSV), create a new model (CSV.php) and write the code for manipulating this structure.
* ExpandManiPulator.php

## Full Documentation
Assume we have an XML file which contains available hotels and rooms and a JSON file which also contains available hotels and rooms as well, but with a different structure and we need a web service which manipulates the two different files and returns a unified output as XML to a front-end MVC app that displays returned results in a grid (each row represent a hotel with child rows that represent rooms) with a filtration facility.

Task Components
Web API service
Handles the unification process and returns output.
Handles the filtration process requests. 
MVC application
One view to display results in a grid.
Grid parent rows (hotels) collapsible to display child rows (rooms).
AJAX filtration by (HotelName, HotelRating, IsReady) via web service.
Task Objectives
Combine results from both JSON and XML files in a unified output.
Web service client should receive a unified output regardless the source of data (Our JSON and XML files). 
Take into consideration the following points
We need a flexible software design which accepts adding a new file structure (e.g. CSV, etc) without affecting the whole process. 
Filtration process occurs within the web service.
Development should be under  Laravel 5+.
JSON and XML data sources attached.
