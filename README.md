### HocusPocus
HocusPocus is a PHP web framework with a Javascript dialog menu inspired by [filemanager nnn](https://github.com/jarun/nnn/wiki).

Css and javascript are associated with pages according to principles of specialization known for class hierarchies.  

The dialog menu supports the creation, renaming and deletion of pages and their directories and editing content in browser.

HocusPocus' counterpart to nnns 'e' for edit selected, is to save the file name in a file on the server, __and__, open the file for editing in a new browser tab. This, two ways choice, assists a simple way for minor corrections in browser and more assisted way in a real editor. How local edit is made depends on how the server's file system is made accessible.

It is implemented in php 8.1 in apache2 in linux.

Because it implements something which purpose is exposing information, it obvious contains its own documentation.


### Apache settings
_/etc/apache2/mods-enabled_ (one among others)
```
...
rewrite.load
...
```
_/etc/apache2/sites-enabled/domain.conf_ 
```
...
<Directory /var/www/domain>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
RewriteEngine on
RewriteRule ^pages$ /pages/da/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^pages/en$ /pages/en/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=$1
</Directory>
...
```

