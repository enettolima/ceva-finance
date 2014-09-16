# Natural PHP
###The open source, PHP framework for natural development
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
