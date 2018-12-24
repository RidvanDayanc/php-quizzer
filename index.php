<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Questions</title>
    <?php
    if(!array_key_exists("qtype",$_GET)){
    ?>
    <style media="screen">
      body{
        background-color: #F2F2F2;
      }
    </style>
    <?php
  }
    ?>
  </head>
  <body>
    <center>
<?php
require_once "database.php";
if(!array_key_exists("qtype",$_GET)){
?>
<h1> Select Question Type </h1>
<a href="?qtype=0"><img src="admin/1.png" alt=""></a>
<a href="?qtype=1"><img src="admin/2.png" alt=""></a>
<a href="?qtype=2"><img src="admin/3.png" alt=""></a>
<?php
exit;
}
$query = "SELECT id,question_text,question_type,option1,option2,option3,option4 FROM questions where question_type = ?";
$stmt = $db->prepare($query);
$stmt->bindParam(1,$_GET['qtype'],PDO::PARAM_INT);
$stmt->execute();
$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
foreach ($datas as $data) {
    if ($data['question_type'] == 0) {
        ?>
    <b><?php echo $data['question_text'] ?> </b>
    <form method="post">
      <input type="radio" name="" value=""><?php echo $data['option1']?>
      <input type="radio" name="" value=""><?php echo $data['option2']?>
      <input type="radio" name="" value=""><?php echo $data['option3']?>
      <input type="radio" name="" value=""><?php echo $data['option4']?>
    </form>
    <?php
  } elseif ($data['question_type'] == 1) {
        ?>
        <img src="image.php?id=<?php echo $data['id']?>&image=1" alt="" width="300px" height="300px">
        <img src="image.php?id=<?php echo $data['id']?>&image=2" alt="" width="300px" height="300px">
        <img src="image.php?id=<?php echo $data['id']?>&image=3" alt="" width="300px" height="300px">
        <br>
        <b><?php echo $data['question_text'] ?> </b>
        <br>
        <div>
        <input type="radio" value="">1
        <input type="radio" value="">2
        <input type="radio" value="">3
        <input type="radio" value="">4
        <input type="radio" value="">5
        <input type="radio" value="">6
        <input type="radio" value="">7
        <input type="radio" value="">8
        <input type="radio" value="">9
        <input type="radio" value="">10
    <?php
  } elseif ($data['question_type'] == 2) {
        ?>
      <img src="image.php?id=<?php echo $data['id']?>&image=1" alt="" width="200px" height="200px">
      <img src="image.php?id=<?php echo $data['id']?>&image=2" alt="" width="200px" height="200px">
      <img src="image.php?id=<?php echo $data['id']?>&image=3" alt="" width="200px" height="200px">
      <br>
      <b><?php echo $data['question_text'] ?> </b>
      <br>
        <input type="radio" name="" value=""><?php echo $data['option1']?>
        <input type="radio" name="" value=""><?php echo $data['option2']?>
        <input type="radio" name="" value=""><?php echo $data['option3']?>
        <input type="radio" name="" value=""><?php echo $data['option4']?>
    <?php
    } ?>
    <hr>
    <br>
    <?php
}
?>
</center>
</body>
</html>
