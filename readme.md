# Natural PHP
###The open source framework for natural app development in PHP
***
Natural PHP is a framework that incorporates other open source projects
to provide a feature rich platform for app development.
Develop fast, develop Naturally !

## Requirements
* PHP 5+
* MYSQL 5+
* [PHP Composer] (https://getcomposer.org/)
* Apache mod_rewrite enabled (Restler APIs and Docs)
* Apache must be able to write to the API cache folder under YOUR_PROJECT/api
* Apache must be able to write to the API docs folder under YOUR_PROJECT/api/docs

## Installation
To install the latest stable release using composer:
`composer create-project opensourcemind/natural-php PROJECT_FOLDER`

To install the latest development release using composer:
`composer create-project -s dev opensourcemind/natural-php PROJECT_FOLDER`

To install the another specific version (i.e. 2.0.0 ) using composer:
`composer create-project opensourcemind/natural-php PROJECT_FOLDER 2.0.0`

## Enabling Mod Rewrite

#####You must edit your Apache configuration to make sure you allow overrides, this is required by mod_rewrite

```
        <Directory /var/www/html/>
                Options Indexes FollowSymLinks
                AllowOverride All
        </Directory>
```
####Enable mod_rewrite in Apache

`a2enmod rewrite`

####Restart Apache service
`service apache2 restart`