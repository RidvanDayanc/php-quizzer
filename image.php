<?php
require_once "database.php";
if(!array_key_exists("image",$_GET) || !array_key_exists("id",$_GET)) exit;
switch ($_GET['image']) {
  case "1":
  default:
  $query = "SELECT question_image1 FROM questions WHERE id = ?";
  break;
  case "2":
  $query = "SELECT question_image2 FROM questions WHERE id = ?";
  break;
  case "3":
  $query = "SELECT question_image3 FROM questions WHERE id = ?";
  break;
}
$stmt = $db->prepare($query);
$stmt->bindParam(1, $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$stmt->bindColumn(1, $image, PDO::PARAM_LOB);
if ($stmt->fetch(PDO::FETCH_BOUND)) {
  header("Content-Type: image");
  echo $image;
}
