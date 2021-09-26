## Requirement
- PHP 7.0
- MySql 5
- Composer

## Getting Started
1. Download the source code
2. Change the database setting at \.env  file
   ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tcgold
    DB_USERNAME=root
    DB_PASSWORD=123456
    ```
3. Go to the root folder of project and run composer command: 
    ```composer log
    composer install
    ```
3. Run migration and import the example data by run the command below:
    ```composer log
    php artisan migrate --seed
    ```
4. Start the server:
    ```composer log
    php artisan serve
    ```
