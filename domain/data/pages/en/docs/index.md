<?php
return ["<!<div class='auto80'>#html#</div>"
,
    <<<EOMD
<div class='gitright'>

## Hocuspocus - et lille php framework
## [![snut](/img/github32.png)](https://github.com/bvirk/hocuspocus)
</div>

Software has lifetime and this is an attempt give a small php framework this.  

It is implemented in php 8.1 in apache2 in linux. Terminal and linux tools are used - curl and not a browser for examples where it is a shorter way to conclude. File references are from \$_SERVER['DOCUMENT_ROOT'] unless a '/' character occurs, which is the root of the file system apache is running on.  

The use, in this writing, of the url http://domain/ could in practice be the name of a local virtual webdir, localhost or a real DNS designated domain, just as commands in terminal can be direct or over ssh.  

Source code examples are kept close to the point, and do not show the full php file with <?php and syntactically correct curly braces { }.

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
RewriteRule ^pages$ /pages/en/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^pages/en$ /pages/en/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=
</Directory>
...
```

### PHP settings

### php.ini

Some settings among others 

- error_reporting = E_ALL
- display_errors = On
- log_errors = On
- html_errors = Off

### TOC
- [Interpretation of the url](url_breakdown)
- [The further path of the request](request)
- [The single page](play)
- [Class HocusPocus](hocuspocus)
- [Class PageAware](pageaware)
- [Index existence](indexfile)
- [Directories and files](dirs_and_files)
- [Specialization of css and javascript](css_and_js)
- [The dialog menu](menu)
- [Class StdMenu](stdmenu)
- [API in PHP](api)
- [Javascript and AJAX](ajax)
- [NNNAPI](nnnapi/index)
- [Javascript in dialog menu](menu_js)
- [Users](users)
- [Security](security)

EOMD];