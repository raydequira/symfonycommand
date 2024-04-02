# symfonycommand

 - update .env with your localhost mySQL credentials
 - create database as `ninexb`
 - run the command > composer install
 - run the command > symfony console doctrine:migrations:migrate
 - run the command > symfony console doctrine:fixtures:load -n

 Part 1
 - run the command ninexb:calculate:sum <argument must be less than or equal to 10>
 > php bin\console ninexb:calculate:sum 4
 
 Part 2
 - run the command ninexb:user:list <argument option as userID> to view list of Users
 > php bin\console ninexb:user:list