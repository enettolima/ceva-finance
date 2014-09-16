# Natural PHP
###The open source, PHP framework for natural development
***
Natural PHP is a framework that incorporates other open source projects
to provide a feature rich platform for app development.
Develop fast, develop Naturally !

## Requirements
* [PHP Composer] (https://getcomposer.org/)
* Apache mod_rewrite enabled (Restler APIs and Docs)

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

####Restart Apache
`service apache2 restart`

**Make sure Apache can write to the natural/api/cache directory**