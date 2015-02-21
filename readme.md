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

## Install with composer
To install the latest stable release:  
`composer create-project opensourcemind/natural-php PROJECT_FOLDER 2.0.2`

To install the latest development release:  
`composer create-project -s dev opensourcemind/natural-php PROJECT_FOLDER`

To install the another specific version (i.e. 2.0.2 ):  
`composer create-project opensourcemind/natural-php PROJECT_FOLDER 2.0.0`

##Configure your database
After installing you should edit your database information in the files `bootstrap.php`, if you would like  
to keep both a production and development database config you can just duplicate the bootstrap file  
into a new file named `bootstrap.dev.php` which Natural automatically prefers over production config  
when present.  

Natural also requires some specific tables available in your database and the easiest way to add them  
to your database is to import the file `natural_framework.sql` available in your project folder.

For your conveninece you can just run the initdb.php script located in the tools directory to wipe
any instances of natural_framework database and deploy from the .sql file.

```
php -p tools/initdb.php
```
or
```
./tools/initdb.php
```

## Enable Mod Rewrite

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

Vagrant database credentials
user: root
pass: 123456
