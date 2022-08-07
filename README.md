# BACKBONE CHALLENGE

## Installation

 1. Make sure to have installed docker, docker-compose, php and composer.
 2. composer install
 3. set properly your .env file
 4. vendor/bin/sail build
 5. vendor/bin/sail up -d
 6. docker-compose exec mysql -u {DB_USERNAME} -p
 7. Enter the password set in your .env file
 8. CREATE DATABASE testing; CREATE DATABASE {DB_DATABASE};
 9. exit to quit mysql and come back to the terminal.
 10. vendor/bin/sail artisan migrate
 11. vendor/bin/sail artisan db:seed AppSeeder

 In order to run the tests

 12. Assign the value <b>testing</b> to the variable <b>DB_DATABASE</b> in your .env
 10. vendor/bin/sail down && vendor/bin/sail up -d
 13. Run step 11 again to seed the testing database.
 14. vendor/bin/sail down
 15. Restore the previous value that DB_DATABASE had before step 12.
 16. vendor/bin/sail up -d
