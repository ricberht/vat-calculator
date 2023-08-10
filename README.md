# VAT Calculator

## Installation Instructions

Please do the following:

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
