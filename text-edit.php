<?php header("Cache-Control: no-cache"); ?>
<?php
if (isset($_POST['name'])){
  $name = rawurlencode($_POST['name']);
  $text = $_POST['text'];
  
  if (!is_dir("docs"))mkdir("docs");
  
  $file = "docs/" . base64_encode($name);
  if (!file_exists($file) || is_writable($file)){
    die(file_put_contents($file, $text));
  } else die();
}
$name = "Title"; $text = ""; $writable = "true";
if (isset($_GET['name']) && $_GET['name'] != ""){
  $name = rawurlencode($_GET['name']);
  $file = "docs/" . base64_encode($name);
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
<!DOCTYPE html>
<html>

<head>
  <title>Online Text Editor 2.0</title>
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
  <form action="text-edit.php" method="get">
    <div id="top"><input name="name" id="name"></div>
    <div id="main"><textarea id="text"<?php if ($writable == "false"){ ?> readonly<?php } ?>></textarea></div>
  </form>
</body>

</html>
