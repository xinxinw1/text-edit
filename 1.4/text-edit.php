<?php header("Cache-Control: no-cache"); ?>
<?php
if (isset($_POST['name'])){
  $name = rawurlencode(rawurldecode($_POST['name']));
  $text = $_POST['text'];
  
  $file = "../docs/$name";
  die(file_put_contents($file, $text));
}
$name = "Title"; $text = "";
if (isset($_GET['name'])){
  $name = rawurlencode(rawurldecode($_GET['name']));
  $file = "../docs/$name";
  $text = (file_exists($file))?rawurlencode(file_get_contents($file)):"";
}
?>
<?php $updated = "Jul.18.2013.13.24"; ?>
<!DOCTYPE html>
<html>

<head>
  <title>Online Text Editor 1.4</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="text-edit.css?<?php echo $updated ?>">
  <script src="text-edit.js?<?php echo $updated ?>" type="text/javascript" defer></script>
  <script type="text/javascript">
  var origName = decodeURIComponent("<?php echo $name ?>");
  var origText = decodeURIComponent("<?php echo $text ?>");
  </script>
</head>

<body>
  <form action="text-edit.php" method="get">
    <div id="top"><input name="name" id="name"></div>
    <div id="main"><textarea id="text"></textarea></div>
  </form>
</body>

</html>
