<?php
try {
     $db = new PDO("mysql:host=localhost;dbname=ridvan", "root", "");
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch ( PDOException $e ){
     print $e->getMessage();
}
?>
