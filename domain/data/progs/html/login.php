<?php 
[$h3label,$method,$sendTxt,$signShift] = count(file(AUTHFILE)) < 5 || array_key_exists('signup',$_GET)
    ? ['Make Encryption of password','saveEncryption','Save encryption'
        ,"'window.location = window.location.toString().replace(/&signup$/,\"\");' value='Sign in'>"]
    : ['LOGIN','oneauth','Login'
        ,"'window.location = window.location.toString() + \"&signup\";' value='Sign up' >"];
return "
<form action='/index.php' method='post'>
    <input type='button' onClick= $signShift
    <h3>$h3label</h3>
    <label>User Name</label>
    <input type='text' name='uname' placeholder='User Name'><br>
    <label>Password</label>
    <input type='password' name='password' placeholder='Password'><br>
    <input type='hidden' name='url' value='".$_GET['url']."'>
    <input type='hidden' name='path' value='progs/LoginRecieve/$method'>
    <button type='submit'>$sendTxt</button>
</form>";
