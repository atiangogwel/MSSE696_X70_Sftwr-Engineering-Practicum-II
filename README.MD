**About this application**

This is web-based application develoed in php to stimuluate an  Online Learning Management System (LMS). It includes a user interface for seamless interaction, a server for core functionality, and a database for information storage.

**Running the application**

1. Clone this project 

2. Change the database credentials in 'db_connection.php' to match your enviroment.

3. Create database 'LLM' and import the provided sql file.

**Running tests**

1. Download and install composer globally

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer

2. Install PHPUnit via Composer:  

     composer require --dev phpunit/phpunit

 3. Run all tests: 

      ./vendor/bin/phpunit tests

 4. Run a gievn test: 
   
    ./vendor/bin/phpunit tests/ file_name


