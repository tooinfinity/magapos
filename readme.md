# Piont of Sale (pos) 

pos is project based on laravel framework 5.7 with AdminLTE 3  dashboard to manage your store


## Installation

After  all you need to setup your environment for php and database for that i use [___Laragon___](https://sourceforge.net/projects/laragon/files/releases/4.0/laragon-wamp.exe/download) 

you need also [___Composer___](https://getcomposer.org/) Dependency Manager for PHP
and [___git___](https://git-scm.com/)  control system 

### 1 - ___Clone Github repo for this project locally___
- go to [___Gitthub___](https://github.com/) website and login or register to an account
- go to your Terminal and look for folder __Laragon__ and sub folder __www__ and run this command

        git clone https://github.com/tooinfinity/magapos.git
  
  this ask to login to __bitbucket__ put you username and password 
- wait until finiched setting up

### 2 - ___Install Composer Dependencies___
 Open your terminal go to your project directory and run this command 

        composer install
this command install all dependency of laravel in your project

### 3 - ___Install npm Dependencies___
 Open your terminal go to your project directory and run this command 

        npm install
this command install all dependency of laravel in your project

<-- you need to install [___NodeJs___](https://nodejs.org/en/) in your pc to get __npm__ command run  -->

### 4 - ___Create a copy of your .env file___
        cp .env.example .env

This will create a copy of the .env.example file in your project and name the copy simply .env

### 5 - ___Generate an app encryption key___
Laravel requires you to have an app encryption key which is generally randomly generated and stored in your .env file Do that with this command

        php artisan key:generate

### 6 - ___Create an empty database for our application___
Create an empty database for your project using the database tools you prefer (heidiSQL)

### 7 - ___In the .env file, add database information to allow Laravel to connect to the database___
In the .env file fill in the

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=your database name
        DB_USERNAME=your database username
        DB_PASSWORD=your database password

options to match the credentials of the database you just created. This will allow us to run migrations and seed the database in the next step.

### 8 - ___Migrate and Seed the database___
Once your credentials are in the .env file, now you can migrate your database.

run this separately with two command

__Migrate :__

        php artisan migrate

__Seed :__

        php artisan db:seed
__do that with one command :__

        php artisan migrate:fresh seed


## Packages used on this Project
  -  [___Laratrust___](https://github.com/santigarcor/laratrust) (Laravel 5 Package)
  -  [___laravel-localization___](https://github.com/mcamara/laravel-localization) Easy localization for Laravel by mcamara
  -  [___SweetAlert2___](https://github.com/realrashid/sweet-alert) for Laravel 5.x by Rashid Ali
  -  [___Intervention Image___](http://image.intervention.io/getting_started/installation)  PHP image handling and manipulation
  -  __.....__

## NPM Packages used on this Project
  -  [___AdminLTE3___](https://adminlte.io/docs/2.4/installation)  Dashboard Template
  -  [___fontawesome-free___](https://github.com/realrashid/sweet-alert) Font Icon Template
  -  [___Select2.js___](https://select2.org/) a customizable select box
  -  [___OnScan.js___](https://github.com/axenox/onscan.js) On-scan events for hardware barcode scanners in vanilla JS
  -  __.....__
## Todo List featured
  - [ ] create a backup and restore for this application
  - [ ] create printing system for my app
  - [ ] Multipe and Soft Delete for Some featured actions
  - [ ] New Design with dark mode toggle
  - [ ] ............

## To fix errors
   - [x] delete category spending
   - [x] fix layout not fit properly
 
