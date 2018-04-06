# Project 6 of Openclassroom's PHP path

This project will be a snowboard figure directory. It will use Symfony 
Framework.

## Installation
### Summary
  - Install and configure the project  
  - Load a dataset with DoctrineFixtures
  - Switch in production 
    
#### Install and configure the project
The PHP version need to bee > 7 cause of usage of new array syntax []   

First of all, you will need Composer and the most recent source code from this repository.  
Once it's done, open a terminal and go to the project folder. Then run a composer install  

    composer install

This command will load the required dependencies and re-create the symfony's parameters file.
Open this file and adapt it to your configuration

    # /app/config/parameters.yml
        
    parameters:
        
        database_host:      DB_IP_ADDRESS
        database_port:      DB_PORT
        
        database_name:      DB_NAME
        database_user:      DB_USER
        database_password:  DB_PASSWORD
        
        mailer_transport:   MAILER_PROTOCOL
        mailer_host:        MAILER_SERVER_URL
        mailer_user:        APP_SEND_MAIL
        mailer_password:    SEND_MAIL_PASSWORD
        secret:             CHANGE_BY_RANDOM_STRING
        
Now database host connection is set, we can init the base and the tables. Go to project folder
with a terminal and launch these commands
        
        bin/console doctrine:database:create   # Create the base
        bin/console doctrine:database:update   # Execute SQL queries for build tables

#### Load dataset from DoctrineFixtures
Really simple ! launch `bin/console doctrine:fixtures:load` from the project folder

#### Switch in production
Once again, really simple. Open `/web/.htaccess` and find the above line. Change `app.php`
to `app_dev.php`
        
    <IfModule mod_rewrite.c>
    
        // Stuff
        
        RewriteRule ^ %{ENV:BASE}/app.php [L]
    </IfModule>
    
Once it's done, launch `bin/console cache:clear --env=prod` from the project folder
    

## Librairies and bundles
Librairies :     
    - Gulp : LiveReload and assets automatization   
    - Composer : Denpendencies intall    
Bundles :     
    - Twig : templating
    - Doctrine : DB gestion and Object Relation Model    
    - SwiftMailer : Mailer     
    - Symfony : Tiers-bundles from symfony framework    

## Project's roadmap

The requested web-application's engineering will be segmented, according to above step-points : 

| D | #  | Issue name                                  | Est. time   | T.Spend |
|---|----|---------------------------------------------|-------------|---------|
| ✓ | 1  | Wireframes                                  | ~~2.5days~~ | 2.5days |
| ✓ | 2  | Symfony implementation                      | ~~30min~~   | 30min   |
| ✓ | 3  | Entities and database creation              | ~~0.5day~~  | 0.25day |
| ✓ | 14 | Gulp implementation                         | ~~0.5day~~  | 0.25day |
| ✓ | 16 | UML diagrams creation                       | ~~1day~~    | 0.75day |
| ✓ | 17 | DataFixtures creation                       | ~~0.25day~~ | 0.5day  |
| ✓ | 2  | Entities rework                             | ~~1day~~    | 2days   | 
| ✓ | 4  | Home and show pages creation                | ~~0.5days~~ | 0.5day  |
| ✓ | 5  | Add/edit/delete figure features creation    | ~~1.5days~~ | 5days   |
| ✓ | 5  | Add/edit/delete features finishes           | ~~2.5days~~ | 4days   |
| ✓ | 6  | Chat feature creation                       | ~~1 day~~   | 1day    |
| ✓ | 7  | Sign-in/sign-up features creation           | ~~1 day~~   | 2.5days |
| ✓ | 11 | Securisation of authenficated features      | ~~1 day~~   | 1.5days |
| ✓ | 21 | Reset password                              | ~~1day~~    | 1day    |
| ✓ | 13 | YALM with initals figures (NOT COMPLETE)    | ~~2days~~   | 0.75day |
| ✓ | 8  | Home and show pages front-work              | ~~2days~~   | 2days   |
| ✓ | 9  | Chat feature front-work                     | ~~3.5days~~ | 0.5day  |
| ✓ | 10 | Forms front-work                            | ~~0.5day~~  | 1.5day  |
| ✕ | 12 | Graphical charter                           | 1 hour      |         |
| ✓ | 22 | Comment source code (NOT COMPLETE)          | ~~1day~~    | 0.5day  |
| ✓ | 23 | Back finitions                              | ~~2days~~   | 4days   |
