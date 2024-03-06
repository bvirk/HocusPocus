<?php
$formInputTypeFileName='selfile';
$permittedMimes = ['image/gif','image/jpeg','image/png'];

if (!array_key_exists($formInputTypeFileName,$_FILES))
    throw new \Exception('form input type="file" name not found in $_FILES');

if (!array_key_exists('updest',$_POST))
    throw new \Exception('$_POST[\'updest\'] do not exist');
$updest = $_POST['updest'];

extract($_FILES[$formInputTypeFileName]);

function returnText($infoLast,$infoInPre=''){
    $get = varLnStr('$_GET',$_GET);
    $post = varLnStr('$_POST',$_POST);
    $files = varLnStr('$_FILES',$_FILES);
    $button = "<button onClick = \"window.open('".$_POST['refer'] ."','_self');\">Exit Upload</button>";
    return <<< EOMD
### Image upload

$button

```
$get
$post
$files
$infoInPre
```
$infoLast
EOMD;
}

if ($error !== 0)
    return returnText($error == 1 || $error == 2 
        ? 'file exceeds form or php.ini upload_max_filesize'
        : "Error $error");

if (strlen($tmp_name) == 0)
    return returnText('\$tmp_name is empty - no file uploadet');

if (filesize($tmp_name) > actors\kmgStrToInt(ini_get('upload_max_filesize')))
    return returnText('PHP filesize() value exceeds upload_max_filesize\n');

$mimetype = mime_content_type($tmp_name);
if (!in_array(mime_content_type($tmp_name),$permittedMimes))
    return returnText("mimetype $mimetype is not allowed");

$imageInfo = varLnStr('getimagesize',getimagesize($tmp_name));
$script = "<!DOCTYPE html><html><body><script>window.open('".$_POST['refer']."','_self');</script></body></html>";

if ( !file_exists($updest)) {
    $oldMask = umask(0);
    mkdir($updest,0777,true);
    umask($oldMask);
}
move_uploaded_file($tmp_name,"$updest/$name");

//return returnText('file would have been uploadet',$imageInfo);
return $script;
