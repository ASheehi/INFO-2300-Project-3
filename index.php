<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Home";
?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<?php
  $id = 1;
  /*^CHANGE IMAGE ID MANUALLY DEPENDING ON FEATURED PHOTO^*/
  $sql = "SELECT images.name, users.username, images.description, images.file_ext, images.file_name FROM images INNER JOIN users ON images.user_id = users.id WHERE images.id = :id;";
  //could change image id manually depending on featured photo
  $params = array(
    ":id" => $id
  );
  $result = exec_sql_query($db, $sql, $params)-> fetchAll();
  $current_image = $result;
?>

<body style="padding-left: 160px;">
  <?php include('includes/header.php'); ?>

  <!-- TODO: This should be your main page for your site. -->
  <div class = pageTitle>
    <h2><u>_Featured Photo_</u></h2>
  </div>
  <div class="featured">
    <div class = "row">
      <img src=<?php echo("/uploads/images/" . $id . "." . $current_image[0]["file_ext"] . " alt=" . $current_image[0]["file_name"]);?>>
      <h3 style="color: rgb(161, 0, 0);;"><?php echo(htmlspecialchars($current_image[0]["name"]));?></h3>
      <h4><u>User:</u> <?php echo(htmlspecialchars($current_image[0]["username"]));?></h4>
      <h4><u>Description:</u> <?php echo(htmlspecialchars($current_image[0]["description"]));?></h4>
    </div>
  </div>

  <?php include("includes/footer.php"); ?>
</body>
</html>
