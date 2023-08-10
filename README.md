# VAT Calculator

## Installation Instructions

Please do the following:

- be running php 8.1
- composer install
- php artisan migrate
- php artisan serve

## About

- This VAT Calculator shows a history of calculations requested, and it can be exported as a CSV file.
- For user provided monetary value V and VAT percentage rate R, it calculates and display both sets of calculations:
- When V is treated as being ex VAT it shows the original value V, the value V with VAT added and the amount of VAT calculated at the rate R.
- When V is treated as being inc VAT it shows the original value V, the value V with VAT subtracted and the amount of VAT calculated at the rate R.
- The results from each requested set of calculations are stored, and are displayed on the screen as a table of historical calculations.
- The history is able to be cleared and exportable to a CSV file.

This project was constructed using the latest 10.x of [/laravel/laravel](https://github.com/laravel/laravel/tree/10.x). I haven't used Laravel since 5.4, a few things have changed, so it was nice to catch up on it. 

If you have any further questions, please contact me.

## Files of interest

- /resources/views/welcome.blade.php
- /app/Http/Controllers/Vat.php 
- /routes/web.php
- /app/helpers.php
- /database/migrations/2023_08_08_194105_create_vat_calculators_table.php
- /app/Models/VatCalculator.php
- /app/Http/Controllers/Clear.php
- /public/js/vat.js

If you care about the styling, but I would normally use SCSS/SASS for a larger project but vanilla CSS suited me just fine this time:
- /public/css/custom.css 

## Used resources
- Laravel 10.x (which I checked, and it uses Symfony as a vendor)
- Bootstrap
- Jquery
