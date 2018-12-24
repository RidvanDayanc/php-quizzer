<?php
if (!array_key_exists("logged_user", $_COOKIE)) {
    header("Location: auth.php");
    exit;
}
if (array_key_exists("logout", $_GET)) {
    setcookie("logged_user", "", time()-3600, "/");
    header("Location: auth.php");
    exit;
}
require_once "../database.php";

function addTextQuestion($question_text, $option1, $option2, $option3, $option4)
{  //0
    global $db;
    $query = "INSERT INTO questions(question_type,question_text,option1,option2,option3,option4) VALUES (?,?,?,?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(1, $question_type = 0, PDO::PARAM_INT); //question_type
    $stmt->bindParam(2, $question_text, PDO::PARAM_STR); //question_text
    $stmt->bindParam(3, $option1, PDO::PARAM_STR); //option1
    $stmt->bindParam(4, $option2, PDO::PARAM_STR); //option2
    $stmt->bindParam(5, $option3, PDO::PARAM_STR); //option3
    $stmt->bindParam(6, $option4, PDO::PARAM_STR); //option4
    $db->errorInfo();
    $stmt->execute();
}
function AddRatingToImageQuestion($question_text, $question_image1, $question_image2, $question_image3)
{ //1
    global $db;
    $query = "INSERT INTO questions(question_type,question_text,question_image1,question_image2,question_image3) VALUES(?,?,?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bindparam(1, $question_type = 1, PDO::PARAM_INT); //question_type
    $stmt->bindparam(2, $question_text, PDO::PARAM_STR); //question_text
    $stmt->bindParam(3, $question_image1, PDO::PARAM_LOB); //question_image1
    $stmt->bindParam(4, $question_image2, PDO::PARAM_LOB); //question_image2
    $stmt->bindParam(5, $question_image3, PDO::PARAM_LOB); //question_image3
    $stmt->execute();
}
function AddTopicFromImageQuestion($question_text, $question_image1, $question_image2, $question_image3, $option1, $option2, $option3, $option4)
{ //2
    global $db;
    $query = "INSERT INTO questions(question_type,question_text,question_image1,question_image2,question_image3,option1,option2,option3,option4) VALUES(?,?,?,?,?,?,?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bindparam(1, $question_type = 2, PDO::PARAM_INT); //question_type
    $stmt->bindparam(2, $question_text, PDO::PARAM_STR); //question_text
    $stmt->bindParam(3, $question_image1, PDO::PARAM_LOB); //question_image1
    $stmt->bindParam(4, $question_image2, PDO::PARAM_LOB); //question_image2
    $stmt->bindParam(5, $question_image3, PDO::PARAM_LOB); //question_image3
    $stmt->bindParam(6, $option1, PDO::PARAM_STR); //option1
    $stmt->bindParam(7, $option2, PDO::PARAM_STR); //option2
    $stmt->bindParam(8, $option3, PDO::PARAM_STR); //option3
    $stmt->bindParam(9, $option4, PDO::PARAM_STR); //option4
    $stmt->execute();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <style media="screen">
      body{
        background-color: #F2F2F2;
      }
      b.logout{
        float: right;
      }
    </style>
  </head>
  <body>
    <b class="logout"><a href="?logout">Çıkış Yap</a></b><br>
<center>
<?php
if (array_key_exists("action", $_GET)) {
    if (strcmp($_GET['action'], "text") === 0) {
        if (array_key_exists("question", $_POST)) {
            addTextQuestion($_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4']);
        } ?>
    <h1> Add Text Question </h1>
    <form method="post">
      <div>
        <label for="question">Question:</label>
        <input type="text" name="question" value="">
      </div>
    <br>
        <div>
        <label for="option1">Option 1:</label>
        <input type="text" name="option1" value="">
      </div>
    <br>
        <div>
        <label for="option2">Option 2:</label>
        <input type="text" name="option2" value="">
      </div>
    <br>
        <div>
        <label for="option3">Option 3:</label>
        <input type="text" name="option3" value="">
      </div>
    <br>
        <div>
        <label for="option4">Option 4:</label>
        <input type="text" name="option4" value="">
      </div>
    <br>
      <input type="submit" name="submit" value="Add Question">
    </form>
    <?php
    } elseif (strcmp($_GET['action'], "image") === 0) {
        if (array_key_exists("question", $_POST)) {
            AddRatingToImageQuestion($_POST['question'], file_get_contents($_FILES['image1']['tmp_name']), file_get_contents($_FILES['image2']['tmp_name']), file_get_contents($_FILES['image3']['tmp_name']));
        } ?>
        <h1>Add Rating to Image Question</h1>
        <form method="post" enctype="multipart/form-data">
          <div>
            <label for="question">Question:</label>
            <input type="text" name="question" value="">
          </div>
        <br>
          <div>
            <label for="image1">Question Image 1:</label>
            <input type="file" name="image1" value="">
          </div>
        </br>
        <div>
          <label for="image2">Question Image 2:</label>
          <input type="file" name="image2" value="">
        </div>
      </br>
      <div>
        <label for="image3">Question Image 3:</label>
        <input type="file" name="image3" value="">
      </div>
    </br>
          <input type="submit" name="submit" value="Add Question">
        </form>
    <?php
    } elseif (strcmp($_GET['action'], "image2") === 0) {
        if (array_key_exists("option1", $_POST)) {
            AddTopicFromImageQuestion($_POST['question'], file_get_contents($_FILES['image1']['tmp_name']), file_get_contents($_FILES['image2']['tmp_name']), file_get_contents($_FILES['image3']['tmp_name']), $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['option4']);
        } ?>
        <form method="post" enctype="multipart/form-data">
          <div>
            <label for="image1">Question Image 1:</label>
            <input type="file" name="image1" value="">
          </div>
          <br>
        <div>
          <label for="image2">Question Image 2:</label>
          <input type="file" name="image2" value="">
        </div>
      <br>
      <div>
        <label for="image3">Question Image 3:</label>
        <input type="file" name="image3" value="">
      </div>
    <br>
            <div>
            <label for="option1">Option 1:</label>
            <input type="text" name="option1" value="">
          </div>
        <br>
            <div>
            <label for="option2">Option 2:</label>
            <input type="text" name="option2" value="">
          </div>
        <br>
            <div>
            <label for="option3">Option 3:</label>
            <input type="text" name="option3" value="">
          </div>
        <br>
            <div>
            <label for="option4">Option 4:</label>
            <input type="text" name="option4" value="">
          </div>
        <br>
          <input type="submit" name="submit" value="Add Question">
        </form>

    <?php
    }
} else {
    ?>
    <h1> Select Question Type </h1>
    <a href="?action=text"><img src="1.png" alt=""></a>
    <a href="?action=image"><img src="2.png" alt=""></a>
    <a href="?action=image2"><img src="3.png" alt=""></a>
    <?php
} ?>
  </center>
</body>
</html>
