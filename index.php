<?php header("Cache-Control: no-cache"); ?>
<?php $ver = "2.2"; ?>
<?php require "base64url.php"; ?>
<?php
if (isset($_POST['name'])){
  $name = rawurlencode($_POST['name']);
  $text = $_POST['text'];
  
  if (!is_dir("docs"))mkdir("docs");
  
  $file = "docs/" . base64urlencode($name);
  if (!file_exists($file) || is_writable($file)){
    die(file_put_contents($file, $text));
  } else die();
}
$name = "Title"; $text = ""; $writable = "true";
if (isset($_GET['name']) && $_GET['name'] != ""){
  $name = rawurlencode($_GET['name']);
  $file = "docs/" . base64urlencode($name);
  if (file_exists($file)){
    $text = rawurlencode(file_get_contents($file));
    $writable = is_writable($file)?"true":"false";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Online Text Editor <?php echo $ver; ?></title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="text-edit.css">
  <script src="text-edit.js" defer></script>
  <script>
  var origName = decodeURIComponent("<?php echo $name ?>");
  var origText = decodeURIComponent("<?php echo $text ?>");
  var writable = <?php echo $writable ?>;
  </script>
</head>

<body>
  <form action="index.php" method="get" id="form">
    <div id="top">
      <table><tr>
        <td id="input"><input name="name" type="text" id="name"></td>
        <td id="buttons">
        <?php if ($writable == "false"){ ?>
          <input type="button" value="Read-only" id="readonly" disabled>
          <?php } ?>
        </td>
      </tr></table>
    <div id="main"><textarea id="text"<?php if ($writable == "false"){ ?> readonly<?php } ?>></textarea></div>
  </form>
</body>

</html>
