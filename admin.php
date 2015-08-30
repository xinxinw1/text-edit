<?php header("Cache-Control: no-cache"); ?>
<?php session_start(); ?>
<?php $ver = "2.1"; ?>
<?php
if (!file_exists("admin-pass")){
  $_SESSION['priv'] = "yes";
  $nopass = true;
}
if (isset($_POST['pass'])){
  $pass = $_POST['pass'];
  $file = "admin-pass";
  if (!file_exists($file) || password_verify($pass, file_get_contents($file))){
    $_SESSION['priv'] = "yes";
  } else {
    $mess = "Incorrect password";
  }
}
if (isset($_SESSION['priv'])){
  if (isset($_POST['newpass'])){
    $pass = $_POST['newpass'];
    $file = "admin-pass";
    if ($pass == ""){
      unlink($file);
      $mess = "Unset password";
      $nopass = true;
    } else {
      file_put_contents($file, password_hash($pass, PASSWORD_DEFAULT));
      $mess = "Changed password";
      if (isset($nopass))unset($nopass);
    }
  }
  if (isset($_POST['protect'])){
    $origname = $_POST['protect'];
    $name = rawurlencode($origname);
    $file = "docs/" . base64_encode($name);
    if (file_exists($file)){
      chmod($file, 0444);
      $mess = "Protected \"$origname\"";
    } else {
      $mess = "\"$origname\" doesn't exist";
    }
  }
  if (isset($_POST['unprotect'])){
    $origname = $_POST['unprotect'];
    $name = rawurlencode($origname);
    $file = "docs/" . base64_encode($name);
    if (file_exists($file)){
      chmod($file, 0644);
      $mess = "Unprotected \"$origname\"";
    } else {
      $mess = "\"$origname\" doesn't exist";
    }
  }
  if (isset($_POST['delete'])){
    $origname = $_POST['delete'];
    $name = rawurlencode($origname);
    $file = "docs/" . base64_encode($name);
    if (file_exists($file)){
      unlink($file);
      $mess = "Deleted \"$origname\"";
    } else {
      $mess = "\"$origname\" doesn't exist";
    }
  }
  if (isset($_GET['logout'])){
    session_destroy();
    header("Location: admin");
    die();
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Admin | Online Text Editor <?php echo $ver; ?></title>
  <meta charset="UTF-8">
  <style>
  * {margin: 0; padding: 0; border: 0; font-family: "Courier New", "DejaVu Sans Mono", monospace;}
  #main {margin: 10px; margin-right: 16px;}
  h2, p {margin-bottom: 10px;}
  input {border: 1px solid #000; padding: 1px 2px; width: 100%;}
  input[type=submit] {background-color: #F1EFEB; padding: 1px 10px; width: auto;}
  input[type=submit]:hover {background-color: #E6E3DE;}
  a {color: #005ec8;}
  </style>
</head>

<body>
  <div id="main">
    <h2>Admin | Online Text Editor <?php echo $ver; ?><?php if (isset($_SESSION['priv']) && !isset($nopass)){ ?> | <a href="admin?logout=true">Logout</a><?php } ?></h2>
    <p>Type in the box and press Enter to submit.</p>
    <?php if (isset($_SESSION['priv'])){ ?>
    <form action="admin" method="post">
      <p>Protect (make read-only): <input type="text" name="protect"></p>
    </form>
    <form action="admin" method="post">
      <p>Unprotect: <input type="text" name="unprotect"></p>
    </form>
    <form action="admin" method="post">
      <p>Delete: <input type="text" name="delete"></p>
    </form>
    <form action="admin" method="post">
      <p>New Password: <input type="password" name="newpass"></p>
    </form>
    <?php } else { ?>
    <form action="admin" method="post">
      <p>Password: <input type="password" name="pass"></p>
    </form>
    <?php } ?>
    <p><?php if (isset($mess))echo $mess; ?></p>
  </div>
</body>

</html>
