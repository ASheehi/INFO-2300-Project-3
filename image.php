<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$sql = "SELECT images.user_id FROM images WHERE images.id = :id;";
$params = array(
  ':id' => $id
);
$result = exec_sql_query($db, $sql, $params)->fetchAll();

if(isset($_POST['deleteTag']) && $current_user[0] == $result[0][0]){
  //todo: implement deleteTag fucntion
  $currenttag_id = filter_input(INPUT_POST, "tagid", FILTER_VALIDATE_INT);
  $sql = "DELETE FROM image_tags WHERE image_tags.image_id = :id AND image_tags.tag_id = :currentTag;";
  $params = array(
    ":id" => $id,
    ":currentTag" => $currenttag_id
  );
  $result = exec_sql_query($db, $sql, $params)->fetchAll();
}

if(isset($_POST['addTag'])){
  //todo: implement addTag function
  $newTag = filter_input(INPUT_POST, "newTag", FILTER_SANITIZE_STRING);
  $alreadyExists = FALSE;
  $sql = "SELECT DISTINCT tags.name FROM tags;";
  $params = array();
  $results = exec_sql_query($db, $sql, $params);
  foreach ($results as $record){
    if ($record['name'] == $newTag){
      $alreadyExists = TRUE;
    }
  }
  if (!$alreadyExists){
    $sql = "INSERT INTO tags (name) VALUES (:newTag);";
    $params = array(
      ':newTag' => $newTag
    );
    $result = exec_sql_query($db, $sql, $params);
  }
  $sql = "SELECT tags.id FROM tags WHERE tags.name = :newTag;";
  $params = array(
    ':newTag' => $newTag
  );
  $result = exec_sql_query($db, $sql, $params)->fetchAll();
  $newTagID = $result[0]["id"];
  $sql = "INSERT INTO image_tags (image_id, tag_id) VALUES (:id, :newTagID)";
  $params = array(
    ':id' => $id,
    ':newTagID' => $newTagID
  );
  $result = exec_sql_query($db, $sql, $params);
}

if (isset($_GET['id'])) {
  $sql = "SELECT images.name, images.description, users.username, tags.name, images.file_name, images.file_ext, users.id FROM (((images INNER JOIN users ON images.user_id = users.id) LEFT OUTER JOIN image_tags ON image_tags.image_id = images.id) LEFT OUTER JOIN tags ON image_tags.tag_id = tags.id) WHERE images.id = :id;";
  $params = array(
    ':id' => $id
  );
  $result = exec_sql_query($db, $sql, $params)->fetchAll();
}

$name = htmlspecialchars($result[0][0]);
$title = $name;
?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body style="padding-left: 160px;">
  <?php include('includes/header.php'); ?>
  <div class="imgind">
    <div class="row">
    <img src=<?php echo("/uploads/images/" . $id . "." . $result[0]["file_ext"] . " alt=" . $result[0]["file_name"]);?>>
    <h2><u>User: <?php echo(htmlspecialchars($result[0]["username"]))?></u></h2>
    <h3>Description: <?php echo(htmlspecialchars($result[0]["description"]));?></h3>
    <?php
      $sql = "SELECT tags.name, tags.id FROM (((images INNER JOIN users ON images.user_id = users.id) LEFT OUTER JOIN image_tags ON image_tags.image_id = images.id) LEFT OUTER JOIN tags ON image_tags.tag_id = tags.id) WHERE images.id = :id;";
      $params = array(
        ":id" => $id
      );
      $result = exec_sql_query($db, $sql, $params)->fetchAll();
      $a = "";
      foreach ($result as $tag){
        $a = $a . $tag[0] . ", ";
      }
      $a = substr($a, 0, (strlen($a) - 2));
    ?>
    <h2><em>Tags: <?php echo(htmlspecialchars($a))?></em></h2>
    <?php
      foreach ($result as $tag){
        echo ("<form action='image.php?id=" . $id . "' method='post'>
            <input type='hidden' name='tagid' value='" . $tag[1] . "'/>
            <input type='submit' name='deleteTag' value='Delete " . $tag["name"] . " tag'/>
            </form>");
      }
    ?>
    <form action=<?php echo("'image.php?id=" . $id . "' method='post'")?>>
      <input type='text' name='newTag'/>
      <input type='submit' name='addTag' value='Add Tag'/>
    </form>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
</body>
</html>
