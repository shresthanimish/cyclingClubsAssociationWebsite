# Cycling Clubs Association

## About
This is a simple laravel 9 project that models a fictional Cycling Club Association website.

The initial idea came from a developer exercise that defined relationships between a Club, Rider, Race and the entrants (i.e. Riders) to a Race. The exercise was a test to see how the data is modelled and the manner that the data is to be displayed.

I took this as an opportunity to have some fun exploring Laravel 9.



## Getting Started

### Installation

#### STEP 1: GET PROJECT
Check out project from github via

git clone git@github.com:rhombusdigital/cyclingClubsAssociationWebsite.git

gh repo clone rhombusdigital/cyclingClubsAssociationWebsite

#### STEP 2: SET UP DATABASE
Create the database you will be using to store the data

create database cyclingClubsAssociation;

Make sure you have the required permissions


#### STEP 3: CONFIGURE PROJECT
Download the required libraries, including laravel, by doing a composer update (assuming you have composer installed)

```shell
composer update
```

Ensure the project has a key generated
```shell
php artisan key:generate
```

Copy the .env.example and modify as required by your set up

```shell
cp .env.example .env
```

Install the required javascript packages
```shell
npm install
```
Generate the stylesheets from the Sass files using
```shell
npm run dev
```

#### Step 4: POPULATE DATABASE
Prepare the database by run the migrations and seeding the database with test data using

php artisan migrate:fresh --seed


#### STEP 5: START DEV SERVER. 

You can use PHP's built-in development server (only PHP 5.4+) via using

```shell
php artisan serve
```

Alternatively, you can use the following virtual host configuration example and set up a virtual host on Apache

<VirtualHost *:80>
        ServerAlias some-domain.com
        ServerAdmin bugs@some-domain.com
        DocumentRoot /home/someUser/cyclingClubsAssociation/public

        <Directory /home/someUser/cyclingClubsAssociation/public/>
                Options FollowSymLinks SymLinksIfOwnerMatch MultiViews
                Require all granted

                RewriteEngine On
                RewriteBase /
                RewriteRule ^index\.php$ - [L]
                RewriteCond %{REQUEST_FILENAME} !-f
                RewriteCond %{REQUEST_FILENAME} !-d
                RewriteRule . /index.php [L]
                
        </Directory>

        ErrorLog /home/someUser/cyclingClubsAssociation/storage/logs/apache.error.log
        LogLevel warn

        CustomLog /home/someUser/cyclingClubsAssociation/storage/logs/apache.access.log combined

</VirtualHost>


## BACKEND ACCESS

You can access the backend tools for the website using the following credentials

username: info@rhombus.com.au
password: password


## FUTURE

This is an incomplete test project that is in no way production ready

### TODO List

Minor tasks that will be undertaken in the short term
- Make UI responsive
- Improve style/colours of UI
- Integrate dummy footer links
- Add the display of the riders in an upcoming race via API
- Add the display of the riders in an completed race via API
- Implement tests for all models

### Experiments for future
- Fork out project and convert the front end to ReactJS
- Fork out project and convert the front end to Vue.js

### Future User Stories
- As an informal user I would like to view the details for a selected race
- As an informal user I would like to view the details for a selected club
- As an informal user I would like to join/register my club to the association
- As a club user I would like to 
	- Add, edit or remove any of my races
	- Remove a rider from my club
	- be able to approve/deny a rider registering for my club
		~ Remove rider from club
- As a rider I would like to be able to be part of more than one club
