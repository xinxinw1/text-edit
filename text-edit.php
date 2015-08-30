<?php header("Cache-Control: no-cache"); ?>
<?php
if (isset($_POST['name'])){
  $name = rawurlencode($_POST['name']);
  $text = $_POST['text'];
  
  $file = "../docs/$name";
  if (!file_exists($file) || is_writable($file)){
    die(file_put_contents($file, $text));
  } else die();
}
$name = "Title"; $text = ""; $writable = "true";
if (isset($_GET['name'])){
  $name = rawurlencode($_GET['name']);
  $file = "../docs/$name";
  if (isset($_GET['type'])){
    if ($_GET['type'] == "make-readonly")chmod($file, 0444);
    if ($_GET['type'] == "make-writable")chmod($file, 0644);
  }
  if (file_exists($file)){
    $text = rawurlencode(file_get_contents($file));
    $writable = is_writable($file)?"true":"false";
  }
}
?>
<?php $updated = time(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Online Text Editor Devel</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="text-edit.css?<?php echo $updated ?>">
  <script src="/codes/libjs/tools/1.x/tools.js"></script>
  <script src="/codes/libjs/ajax/2.x/ajax.js"></script>
  <script src="text-edit.js?<?php echo $updated ?>" type="text/javascript" defer></script>
  <script type="text/javascript">
  var origName = decodeURIComponent("<?php echo $name ?>");
  var origText = decodeURIComponent("<?php echo $text ?>");
  var writable = <?php echo $writable ?>;
  </script>
</head>

<body>
  <form action="text-edit.php" method="get">
    <div id="top"><input name="name" id="name"></div>
    <div id="main"><textarea id="text"<?php if ($writable == "false"){ ?> readonly<?php } ?>></textarea></div>
  </form>
</body>

</html>
