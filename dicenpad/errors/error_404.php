<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php 
$base_url = "http://".$_SERVER['HTTP_HOST'];
$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>FSC Crew Management System | The page you were looking for doesn't exist (404)</title>
  <style type="text/css">
    body { background-color: #efefef; color: #333; font-family: Georgia,Palatino,'Book Antiqua',serif;padding:0;margin:0;text-align:center; }
    p {font-style:italic;}
    div.dialog {
      width: 490px;
      margin: 4em auto 0 auto;
    }
    img { border:none; }
  </style>
</head>

<body>
  <!-- This file lives in public/404.html -->
  <div class="dialog">
    <img src="<?php echo $base_url . 'includes/img/404.png'; ?>" />
    <p>It looks like <?php echo strip_tags(strtolower($message)); ?>, Sorry.</p>
    <p><a href="<?php echo $base_url; ?>">[ Back to Home Page ]</a></p>
  </div>
</body>
</html>