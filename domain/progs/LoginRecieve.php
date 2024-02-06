<?php
namespace progs;

function windowOldLocation() { ?>
<!DOCTYPE html><html><body><script>window.location ="<?= $_REQUEST['url']; ?>";</script></body></html>
<?php }


class LoginRecieve {
    function saveEncryption() {
        $uname = $_POST['uname'];
        $allUsers =include(AUTHFILE); 
        if (in_array($uname,USERS) && array_key_exists($uname,$allUsers)==false) {
            $salt = uniqid();
            $newUser=[$uname => [ crypt($_POST['password'],$salt),$salt]];
            file_put_contents(AUTHFILE,'<?php return '.var_export(array_merge($allUsers,$newUser),true).';');    
        }
        windowOldLocation();
    }
    function oneauth() {
        $allUsers =include(AUTHFILE); 
        $uname = $_POST['uname'];
        if (array_key_exists($uname,$allUsers)) {
            [$encrypted,$salt] = $allUsers[$uname];
            if (hash_equals(crypt($_POST['password'],$salt),$encrypted))
                $_SESSION[LOGGEDIN]=$uname;
            else 
                $_SESSION[LOGGEDIN]='';
        }
        windowOldLocation();
    }
    function logout() {
        $_SESSION[LOGGEDIN]='';
        windowOldLocation();
    }
}
