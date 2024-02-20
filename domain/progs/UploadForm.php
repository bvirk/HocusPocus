<?php
namespace progs;



class UploadForm {
    function index() { ?>
<!DOCTYPE html>
<html>
<body>
<form action="/progs/html/getupload" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="selfile">
  <input type="submit" value="Upload" name="submit">
  <input type="hidden" name="refer" id="refer">
  <input type="hidden" name="updest" id="updest">
</form>
<button onClick="exitForm();">Exit Upload</button>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const updest = document.getElementById("updest");
    updest.setAttribute('value',urlParams.get('updest'));
    const refer = document.getElementById("refer");
    refer.setAttribute('value',urlParams.get('refer'));
    let exitForm = () => window.open(urlParams.get('refer'),'_self')
</script>
</body>
</html>
    <?php }
}