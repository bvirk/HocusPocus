<?php
return ["<!<div class='auto80'>#html#</div>"
,
    <<<EOMD
<div class='gitright'>

## Hocuspocus - et lille php framework
## [![snut](/img/github32.png)](https://github.com/bvirk/hocuspocus)
</div>

Software har levetid og her forsøges så at give et lille php framework dette.

Det er implementeret i php 8.1 i apache2 i linux. Terminal og linux tools som curl anvendes hvor det er en kortere måde at konkludere på. Fil referencer er fra \$_SERVER['DOCUMENT_ROOT'] med mindre et '/' tegn forest, som så er roden af filsystemet apache kører på.

Kildekode eksempler er holdt tæt til pointen, og viser ikke den fulde php fil med <?php og syntaktisk korrekt omklamrende { }. Det er ikke en stavefejl at der er anvendte engelske termer som class og constants i uskøn blanding med dansk.

### Apache indstillinger
_/etc/apache2/mods-enabled_ (en blandt mange)
```
...
rewrite.load
...
```
_/etc/apache2/sites-enabled/minVirtHost.conf_ (minVirtHost vil konkret hedde noget andet)
```
...
<Directory /var/www/minVirtHost>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
RewriteEngine on
RewriteRule ^pages$ /pages/da/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=\\$1
</Directory>
...
```

### PHP indstillinger
#### php.ini

udover en masse standard indstillinger, så 

- error_reporting = E_ALL
- display_errors = On
- log_errors = On
- html_errors = Off




## TOC
- [Fortolkning af url'en](url_breakdown)
- [Requestets videre vej](request)
- [Den enkelte side](play)
- [Class HocusPocus](hocuspocus)
- [Class PageAware](pageaware)
- [Index eksistens](indexfile)
- [Directories og filer](dirs_and_files)
- [Specialisering af css og javascript](css_and_js)
- [Menuen](menu)
- [Class StdMenu](stdmenu)
- [API i PHP](api)
- [Javascript og AJAX](ajax)
- [NNNAPI](nnnapi/index)
- [javascript i dialog menuen](menu_js)
- [Bruger begrebet](users)
- [Sikkerhed](security)
- [Review af javascript](javareview)

EOMD];