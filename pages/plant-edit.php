<?php
$title = 'Edit Plant';
include_once('includes/sessions.php');
$database = init_sqlite_db('db/site.sqlite', 'db/init.sql');

define("MAX_FILE_SIZE", 1000000);

if (is_user_logged_in()) {
  $is_edit_form_valid = False;
  $update_successful = False;
  $delete_successful = False;
  $file_upload_successful = False;

  $name_feedback_class = 'hidden';
  $number_feedback_class = 'hidden';
  $genus_feedback_class = 'hidden';

  $upload_feedback_class = 'hidden';

  // Search for plant in database to see if it exists
  if (isset($_GET['name'])) {
    $plant_name = $_GET['name'];
    $plant = exec_sql_query(
      $database,
      "SELECT * FROM plants WHERE (plant_name = :plant_name);",
      array(
        ':plant_name' => $plant_name
      )
    )->fetch();
  }

  // If we found a corresponding plant entry
  if ($plant) {
    $plant_id = $plant['id'];
    $sticky_name = $plant['plant_name'];
    $sticky_number = $plant['plant_number'];
    $sticky_genus = $plant['plant_genus'];
  }

  if (isset($_POST['update'])) {
    var_dump($_POST['update']);
    $new_plant_name = trim($_POST['new_name']);
    $new_plant_number = trim($_POST['new_number']);
    $new_plant_genus = trim($_POST['new_genus']);

    $is_edit_form_valid = True;

    if (empty($new_plant_name)) {
      $is_edit_form_valid = False;
      $name_feedback_class = '';
    }
    if (empty($new_plant_number)) {
      $is_edit_form_valid = False;
      $number_feedback_class = '';
    }
    if (empty($new_plant_genus)) {
      $is_edit_form_valid = False;
      $genus_feedback_class = '';
    }
    if ($is_edit_form_valid) {
      $update = exec_sql_query(
        $database,
        "UPDATE plants SET
        plant_name = :plant_name,
        plant_number = :plant_number,
        plant_genus = :plant_genus
      WHERE (id = :id);",
        array(
          ':plant_name' => $new_plant_name,
          ':plant_number' => $new_plant_number,
          ':plant_genus' => $new_plant_genus,
          ':id' => $plant_id
        )
      );


      if ($update) {
        $update_successful = True;
      } else {
        $sticky_name = $new_plant_name;
        $sticky_number = $new_plant_number;
        $sticky_genus = $new_plant_genus;
      }
    }
  }

  if (isset($_POST['delete'])) {
    $plant_name = $_POST['delete'];
    $delete = exec_sql_query(
      $database,
      "DELETE FROM plants WHERE (plant_name = :plant_name);",
      array(
        ':plant_name' => $plant_name
      )
    );
    if ($delete) {
      $delete_successful = True;
    }
  }

  if (isset($_POST['upload-file'])) {
    var_dump($_POST['upload-file']);
    $upload = $_FILES['jpg-file'];

    if ($upload['error'] == UPLOAD_ERR_OK) {
      $upload_name = basename($upload['name']);
      $upload_extension = strtolower(pathinfo($upload_name, PATHINFO_EXTENSION));
      $upload_size = $upload['size'];
      if (!in_array($upload_extension, array('jpg'))) {
        $file_upload_successful = False;
      } else {
        $file_upload_successful = True;
      }
      if ($file_upload_successful) {
        $upload_query = exec_sql_query(
          $database,
          "INSERT INTO images (file_name, file_type, file_size) VALUES (:file_name, :file_type, :file_size)",
          array(
            ':file_name' => $upload_name,
            ':file_type' => $upload_extension,
            ':file_type' => $upload_extension,
            ':file_size' => $upload_size
          )
        );
      }

      if ($upload_query) {
        $upload_path = 'public/uploads/images/' . $plant['plant_number'] . '.' . $upload_extension;
        move_uploaded_file($upload['tmp_name'], $upload_path);
      } else {
        $upload_feedback_class = '';
      }
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title><?php echo $title ?></title>

  <link rel="stylesheet" type="text/css" href="/public/styles/theme.css" media="all" />
</head>

<body>
  <?php include('includes/header.php'); ?>
  <main>
    <h1><?php echo $title ?></h1>
    <a href="/plant?<?php echo http_build_query(array('name' => $plant['plant_name'])); ?>" class="plant-detailed-options">Back to Plant</a>
    <?php if ($delete_successful) { ?>
      <p>Plant successfully deleted. <a href="/">Back to catalog.</a></p>
    <?php } elseif ($update_successful) { ?>
      <p>Plant successfully updated!. <a href="/">Back to catalog.</a></p>
    <?php } else { ?>
      <?php
      $path = "/public/uploads/images/" . $plant['plant_number'] . ".jpg";
      ?>
      <img src=<?php echo $path ?> class="detailed-plant" onerror="this.onerror=null; this.src='/public/images/photo_unavailable.jpg'">


      <form action="/plant/edit?<?php echo http_build_query(array('name' => $plant_name)); ?>" method="post" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <label for="file">JPG File:</label>
        <input id="file" type="file" name="jpg-file" accept=".jpg,image/jpg+xml" />
        <br></br>
        <button type="submit" name="upload-file">Upload new image</button>
      </form>
      <form action="/plant/edit?<?php echo http_build_query(array('name' => $plant_name)); ?>" method="post" novalidate>
        <div class="label-input">
          <label for="new_name">Plant Name:</label>
          <input id="new_name" type="text" name="new_name" value="<?php echo htmlspecialchars($sticky_name); ?>" />
        </div>
        <div class="label-input">
          <label for="new_number">Plant Number:</label>
          <input id="new_number" type="text" name="new_number" value="<?php echo htmlspecialchars($sticky_number); ?>" />
        </div>
        <div class="label-input">
          <label for="new_genus">Plant Genus:</label>
          <input id="new_genus" type="text" name="new_genus" value="<?php echo htmlspecialchars($sticky_genus); ?>" />
        </div>
        <input type="hidden" name="update" value="<?php echo htmlspecialchars($plant_name); ?>" />
        <button type="submit">Save Plant</button>
      </form>

      <form action="/plant/edit?<?php echo http_build_query(array('name' => $plant_name)) ?>" method="post" novalidate>
        <input type="hidden" name="delete" value="<?php echo htmlspecialchars($plant_name); ?>" />
        <button type="submit">Delete Plant</button>
      </form>
    <?php }  ?>
  </main>
</body>

</html>
