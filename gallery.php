<?php
 // INCLUDE ON EVERY TOP-LEVEL PAGE!
include("includes/init.php");
$title = "Gallery";

$messages = array();

// Set maximum file size for uploaded files.
// MAX_FILE_SIZE must be set to bytes
// 1 MB = 1000000 bytes
const MAX_FILE_SIZE = 1000000;

// Users must be logged in to upload files!
if ( isset($_POST["submit_upload"]) && is_user_logged_in() ) {

  // TODO: filter input for the "img_file" and "description" parameters.
  // Hint: filtering input for files means checking if the upload was successful

  // TODO: If the upload was successful, record the upload in the database
  // and permanently store the uploaded file in the uploads directory.

  $upload_info = $_FILES["img_file"];
  if ($upload_info['error'] == 0) {
    $basename = basename($upload_info["name"]);
    $upload_ext = strtolower(pathinfo($basename, PATHINFO_EXTENSION));
    //Insert a new record into the images table with the following fields: user_id, file_name, file_ext, description.
    $sql = "INSERT INTO images (name, file_name, file_ext, description, user_id) VALUES (:name, :file_name, :file_ext, :description, :user_id)";
    $params = array(
      ':name' => filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING),
      ':file_name' => $basename,
      ':file_ext' => $upload_ext,
      ':description' => filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING),
      ':user_id' => $current_user['id'],
    );

    $result = exec_sql_query($db, $sql, $params);
    $last_id = $db->lastInsertId("id");

    $new_path = "uploads/images/" . $last_id . "." . $upload_ext;
    move_uploaded_file( $_FILES["img_file"]["tmp_name"], $new_path );
  }

}

if(isset($_POST['deleteImage']) && is_user_logged_in())
  {
    $currentRecord_id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM images WHERE images.id = :currentRecord";
    $params = array(
      ':currentRecord' => $currentRecord_id
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
    deleteImage($db, $result);
  }

function deleteImage($db, $record){
  $record_id = $record[0]['id'];
  $sql = "DELETE FROM images WHERE images.id = :record_id;";
  $params = array(
    ":record_id" => $record_id
  );
  $result = exec_sql_query($db, $sql, $params);
  $sql = "DELETE FROM image_tags WHERE image_tags.image_id = :record_id;";
  $params = array(
    ":record_id" => $record_id
  );
  $result = exec_sql_query($db, $sql, $params);
  unlink("/uploads/images/" . $record_id . "/" . $record[0]['file_ext']);
  header("location: gallery.php");
}

function print_record($db, $record) {
  ?>
  <tr>
    <td><?php echo ('<a href="image.php?' . http_build_query( array( 'id' => $record['id'] ) ) . '"><img class="thumb" src="/uploads/images/' . $record['id'] . '.' . $record["file_ext"] . '" alt="' . htmlspecialchars($record['file_name']) . '"></a>');?></td>
    <td><?php echo htmlspecialchars($record["file_name"]);?></td>
    <td><?php echo htmlspecialchars($record["file_ext"]);?></td>
    <td><?php echo htmlspecialchars($record["description"]);?></td>
    <td><?php echo htmlspecialchars($record["username"]);?></td>
    <!-- SEPARATE HERE -->
    <?php
      $sql = "SELECT tags.name FROM (((images INNER JOIN users ON images.user_id = users.id) LEFT OUTER JOIN image_tags ON image_tags.image_id = images.id) LEFT OUTER JOIN tags ON image_tags.tag_id = tags.id) WHERE images.id = :id;";
      $params = array(
        ":id" => $record['id']
      );
      $result = exec_sql_query($db, $sql, $params)->fetchAll();
      //COMPLETE THIS HERE BY GETTING THE ARRAY OF TAGS AND MAKING A STRING -> INTO TABLE AS THAT STRING
      $a = "";
      foreach ($result as $tag){
        $a = $a . $tag[0] . ", ";
      }
      $a = substr($a, 0, (strlen($a) - 2));
    ?>
    <td><?php echo htmlspecialchars($a);?></td>
  </tr>
  <?php
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<body style="padding-left: 160px;">
  <?php include('includes/header.php'); ?>
  <!-- TODO: This should be your gallery page for your site. -->
  <div id="content-wrap">
    <h1><u>CornelleScope Gallery</u></h1>

    <?php
    // If the user is logged in, let them upload files and view their uploaded files.
    if ( is_user_logged_in() ) {

      foreach ($messages as $message) {
        echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
      }
      ?>

      <h2>Upload an Image</h2>

      <form id="uploadFile" action="gallery.php" method="post" enctype="multipart/form-data">
        <ul>
          <li>
            <label for="name_field">Image Name:</label>
            <input id="name" type="text" name="name">
          </li>
          <li>
            <!-- MAX_FILE_SIZE must precede the file input field -->
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />

            <label for="img_file">Upload Image:</label>
            <input id="img_file" type="file" name="img_file">
          </li>
          <li>
            <label for="img_desc">Description:</label>
            <textarea id="img_desc" name="description" cols="40" rows="5"></textarea>
          </li>
          <li>
            <button name="submit_upload" type="submit">Upload File</button>
          </li>
        </ul>
      </form>

      <h2>Uploaded Images</h2>

      <ul style="list-style: none;">
        <?php
        $records = exec_sql_query(
          $db,
          "SELECT * FROM images WHERE user_id = :user_id;",
          array(':user_id' => $current_user['id'])
          )->fetchAll();

        if (count($records) > 0) {
          foreach($records as $record){
            echo "<li><a href=\"/uploads/images/" . $record["id"] . "." . $record["file_ext"] . "\">" . htmlspecialchars($record["file_name"]) . "</a> - " . htmlspecialchars($record["description"]) . "</li>";
            echo ("<li><form action='gallery.php' method='post'>
            <input type='hidden' name='id' value='" . $record["id"] . "'/>
            <input type='submit' name='deleteImage' value='Delete'/>
            </form></li>");
          }
        } else {
          echo '<p><strong>No images uploaded yet. Try uploading an image!</strong></p>';
        }
        ?>
      </ul>
      <?php
    } else {
      ?>
      <p><strong>You need to sign in before you can upload an image</strong></p>

      <?php
    }
    ?>

  </div>

  <?php
  if (isset($_GET['tag'])) {
  ?>
  <div id = "imageGallery">
  <h2 style="padding-left: 10px;"><u>Search Results - Image Gallery</u></h2>
  <h2>Tags:</h2>
  <ul>
  <?php
    $sql = "SELECT DISTINCT tags.name FROM tags;";
    $params = array();
    $results = exec_sql_query($db, $sql, $params);
    foreach ($results as $record){
      echo("<li> <a href=\"gallery.php?" . http_build_query( array( 'tag' => htmlspecialchars($record['name'] )) ) . "\">" . htmlspecialchars($record["name"]) . "</a></li>");
    }
  ?>
  </ul>
  <?php
    $tag = filter_input(INPUT_GET, 'tag', FILTER_SANITIZE_STRING);
    $sql = "SELECT DISTINCT images.name, images.file_name, images.file_ext, images.description, users.username, images.id FROM (((images INNER JOIN users ON images.user_id = users.id) LEFT OUTER JOIN image_tags ON image_tags.image_id = images.id) LEFT OUTER JOIN tags ON image_tags.tag_id = tags.id) WHERE tags.name = :tag;";
    $params = array(
      ':tag' => $tag
    );
    $result = exec_sql_query($db, $sql, $params)->fetchAll();
  ?>
  <table cellspacing="50">
          <tr>
            <th>Image</th>
            <th>File Name</th>
            <th>File Ext</th>
            <th>Description</th>
            <th>User ID</th>
            <th>Tags</th>
          </tr>

          <?php
          foreach($result as $record) {
            print_record($db, $record);
          }
          ?>
        </table>
  </div>

  <?php } else { ?>

  <div id = "imageGallery">
  <h2 style="padding-left: 10px;"><u>All Images - Image Gallery</u></h2>
  <h2>Tags:</h2>
  <ul>
  <?php
    $sql = "SELECT DISTINCT tags.name FROM tags;";
    $params = array();
    $results = exec_sql_query($db, $sql, $params);
    foreach ($results as $record){
      echo("<li><a href=\"gallery.php?" . http_build_query( array( 'tag' => htmlspecialchars($record['name'] )) ) . "\">" . htmlspecialchars($record["name"]) . "</a></li>");
    }
  ?>
  <?php
    $sql = "SELECT DISTINCT images.name, images.file_name, images.file_ext, images.description, users.username, images.id, tags.name FROM (((images INNER JOIN users ON images.user_id = users.id) LEFT OUTER JOIN image_tags ON image_tags.image_id = images.id) LEFT OUTER JOIN tags ON image_tags.tag_id = tags.id) GROUP BY images.name;";
    $params = array();
    $results = exec_sql_query($db, $sql, $params);
  ?>
  </ul>
  <table cellspacing="50">
          <tr>
            <th>Image</th>
            <th>File Name</th>
            <th>File Ext</th>
            <th>Description</th>
            <th>User ID</th>
            <th>Tags</th>
          </tr>

          <?php
          foreach($results as $record) {
            print_record($db, $record);
          }
          ?>
    </table>
  </div>

  <?php }?>

  <?php include("includes/footer.php"); ?>
</body>
</html>
