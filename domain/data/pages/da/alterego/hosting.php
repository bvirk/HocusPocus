<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Som for alle andre har de første hostinger været køb af et shared hosting abonnement.  

Microprocessornes  kerne antal ekspansion og clockcycle frekvens øgning og meget andet eksotisk teknik, har åbnet en forunderlig verden af virtualisering af OS'er på en måde hvor der til hver OS er tildelt et bestemt antal kerner.  

i en [vps](https://en.wikipedia.org/wiki/Virtual_private_server) er det kerner - ligeså private som dem på desktop eller laptop computeren, man lejer remote med tilhørende gear - og en ip adresse.  Det er et alternativet til shared hosting og meget sjovere. Man er meget friere stillet til hvad der skal køre.

Grundet markedet derfor er det ikke spor svært. Det er faktisk lettere for den viden man tilegner sig er grundviden - mens en shared hosting bare har noget service viden der retter sig mod kunde segmentet - og det kan godt virke bestemmer agtigt.  

Viden eksponeres behjælpeligt af f.eks digitalocean.com - det er guider derfra der har gjort det let for mig.  

Her følger de skridt jeg tog. 

Jeg fik root password og valgte ubuntu 20 som OS

oprettede bruger på sudoers list og installerede dengang midnight commander
```
# adduser jane
# sudo usermod -a -G sudo jane
# apt install mc
```
Jeg distro opdatere på et tidspunkt til ubuntu 22 - det lykkedes til min overraskelse.

Lamp installation
- apache2 installeres
- php - en masse pakker installeres 
- oprette apache config fil i /etc/apache2/site-available
- oprette directory som <Directory i virtualHost angav og udførte echo "<?php phpinfo();" >info.php deri.
- enable apache modul rewrite
- $ sudo systemctl start apache2

Dns  på https://www.one.com/admin - a record bvirk.dk 185.212.47.136

Efter at have fulgt [ssh-keys](https://www.digitalocean.com/community/tutorials/how-to-set-up-ssh-keys-on-ubuntu-20-04)  
Og tilføjet til /etc/hosts
- 185.212.47.136 vps

Er det muligt at logge ind i gnome-terminal med
```
$ ssh vps
```

Midnight Commander, har efter 30 års bekendtskab lidt denne skæbne

```
$ sudo apt remove mc
$ sudo apt install nnn  
```
Det skal være et kort greb at se og redigere config filer:

```
$ cd ~/.config/nnn/plugins
$ cat less
#!/usr/bin/env sh
less \\$1

$ cat vim
#!/usr/bin/env sh
vim \\$1

$ cat sudovim
#!/usr/bin/env sh
sudo vim \\$1

$ tail -n 18 ~/.bashrc 
export NNN_PLUG='l:less;v:vim;s:sudovim'
export NNN_BMS='b:/var/www';
function n() {
    # Block nesting of nnn in subshells
    if [ -n \$NNNLVL ] && [ "\${NNNLVL:-0}" -ge 1 ]; then
        echo "nnn is already running"
        return
    fi
    export NNN_TMPFILE="\${XDG_CONFIG_HOME:-\$HOME/.config}/nnn/.lastd"
    nnn -U "$@"
    if [ -f "\$NNN_TMPFILE" ]; then
            . "\$NNN_TMPFILE"
            rm -f "\$NNN_TMPFILE" > /dev/null
    fi
}
[ -n "\$NNNLVL" ] && PS1="N\$NNNLVL \$PS1"
```

EOMD,actors\tocNavigate($func)];