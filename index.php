<?php header("Cache-Control: no-cache"); ?>
<?php $ver = "2.9.0"; ?>
<?php require "base64url.php"; ?>
<?php
if (isset($_POST['name'])){
  $name = rawurlencode($_POST['name']);
  $text = $_POST['text'];
  
  if (!is_dir("data"))mkdir("data");
  if (!is_dir("data/docs"))mkdir("data/docs");
  
  $file = "data/docs/" . base64urlencode($name);
  if (!file_exists($file) || is_writable($file)){
    die(file_put_contents($file, $text));
  } else die();
}
$name = "Title"; $text = ""; $writable = "true";
if (isset($_GET['name']) && $_GET['name'] != ""){
  $name = rawurlencode($_GET['name']);
  $file = "data/docs/" . base64urlencode($name);
  if (file_exists($file)){
    $text = rawurlencode(file_get_contents($file));
    $writable = is_writable($file)?"true":"false";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Online Text Editor <?php echo $ver ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <link rel="stylesheet" href="text-edit.css?v=<?php echo $ver ?>">
  <script src="text-edit.js?v=<?php echo $ver ?>" defer></script>
  <script>
  var origName = decodeURIComponent("<?php echo $name ?>");
  var origText = decodeURIComponent("<?php echo $text ?>");
  var writable = <?php echo $writable ?>;
  </script>
</head>

<body>
  <form method="get" id="form">
    <div id="top">
      <table><tr>
        <td id="input"><input name="name" type="text" id="name"></td>
        <td id="buttons">
        <?php if ($writable == "false"){ ?>
          <input type="button" value="Read-only" id="readonly" disabled>
        <?php } else { ?>
          <input type="button" value="Save" title="Ctrl+S" id="save" disabled>
        <?php } ?>
        </td>
      </tr></table>
    <div id="main"><textarea id="text"<?php if ($writable == "false"){ ?> readonly<?php } ?>></textarea></div>
  </form>
</body>

</html>
