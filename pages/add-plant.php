<?php
// A lot of this code is just copied from the plant-edit.php code I wrote
$title = 'Add a Plant';
include_once('includes/sessions.php');
$database = init_sqlite_db('db/site.sqlite', 'db/init.sql');

define("MAX_FILE_SIZE", 1000000);

if (is_user_logged_in()) {

  $is_add_form_valid = False;
  $insert_successful = False;
  $file_upload_successful = False;

  $name_feedback_class = 'hidden';
  $number_feedback_class = 'hidden';
  $genus_feedback_class = 'hidden';

  $name_not_unique = False;
  $number_not_unique = False;

  $upload_feedback_class = 'hidden';

  $sticky_name = '';
  $sticky_number = '';
  $sticky_genus = '';

  $sticky_shrub = '';
  $sticky_grass = '';
  $sticky_vine = '';
  $sticky_tree = '';
  $sticky_flower = '';
  $sticky_groundcovers = '';
  $sticky_other = '';

  $expl_con = $_POST['expl_con'] ? 1 : 0; // untrusted
  $expl_sen = $_POST['expl_sen'] ? 1 : 0; // untrusted
  $phys_play = $_POST['phys_play'] ? 1 : 0; // untrusted
  $imag_play = $_POST['imag_play'] ? 1 : 0; // untrusted
  $rest_play = $_POST['rest_play'] ? 1 : 0; // untrusted
  $rules_play = $_POST['rules_play'] ? 1 : 0; // untrusted
  $bio_play = $_POST['bio_play'] ? 1 : 0; // untrusted

  $perennial = $_POST['perennial'] ? 1 : 0; // untrusted
  $annual = $_POST['annual'] ? 1 : 0; // untrusted
  $full_sun = $_POST['full_sun'] ? 1 : 0; // untrusted
  $partial_shade = $_POST['partial_shade'] ? 1 : 0; // untrusted
  $full_shade = $_POST['full_shade'] ? 1 : 0; // untrusted

  $sticky_expl_con = ($expl_con ? 'checked' : '');
  $sticky_expl_sen = ($expl_sen ? 'checked' : '');
  $sticky_phys_play = ($phys_play ? 'checked' : '');
  $sticky_imag_play = ($imag_play ? 'checked' : '');
  $sticky_rest_play = ($rest_play ? 'checked' : '');
  $sticky_rules_play = ($rules_play ? 'checked' : '');
  $sticky_bio_play = ($bio_play ? 'checked' : '');

  $sticky_annual = ($annual ? 'checked' : '');
  $sticky_perennial = ($perennial ? 'checked' : '');
  $sticky_full_sun = ($full_sun ? 'checked' : '');
  $sticky_partial_shade = ($partial_shade ? 'checked' : '');
  $sticky_full_shade = ($full_shade ? 'checked' : '');

  if (isset($_POST['add'])) {
    $plant_name = trim($_POST['name']);
    $plant_number = trim($_POST['number']);
    $plant_genus = trim($_POST['genus']);
    $tag_name = trim($_POST['tag']);

    $is_add_form_valid = True;

    if (empty($plant_name)) {
      $is_add_form_valid = False;
      $name_feedback_class = '';
    } else {
      $plants_with_same_names = exec_sql_query(
        $database,
        "SELECT * FROM plants WHERE (plant_name = :plant_name);",
        array(
          ':plant_name' => $plant_name,
        )
      )->fetchAll();
      if (count($plants_with_same_names) > 0) {
        $is_add_form_valid = False;
        $name_not_unique = True;
      }
    }
    if (empty($plant_number)) {
      $is_add_form_valid = False;
      $number_feedback_class = '';
    } else {
      $plants_with_same_number = exec_sql_query(
        $database,
        "SELECT * FROM plants WHERE (plant_number = :plant_number);",
        array(
          ':plant_number' => $plant_number,
        )
      )->fetchAll();
      if (count($plants_with_same_number) > 0) {
        $is_add_form_valid = False;
        $number_not_unique = True;
      }
    }
    if (empty($plant_genus)) {
      $is_add_form_valid = False;
      $genus_feedback_class = '';
    }

    if (!in_array($tag_name, array('', 'shrub', 'vine', 'grass', 'tree', 'flower', 'groundcovers', 'other'))) {
      $is_add_form_valid = False;
    } elseif (empty($tag_name)) {
      $tag_name = NULL;
    }

    if ($is_add_form_valid) {

      $insert = exec_sql_query(
        $database,
        "INSERT INTO plants (plant_number, plant_name, plant_genus, expl_con, expl_sen, phys_play, imag_play, rest_play, rules_play, bio_play, perennial, annual, full_sun, partial_shade, full_shade) VALUES (:plant_number, :plant_name, :plant_genus, :expl_con, :expl_sen, :phys_play, :imag_play, :rest_play, :rules_play, :bio_play, :perennial, :annual, :full_sun, :partial_shade, :full_shade)",
        array(
          ':plant_number' => $plant_number,
          ':plant_name' => $plant_name,
          ':plant_genus' => $plant_genus,
          ':expl_con' => $expl_con,
          ':expl_sen' => $expl_sen,
          ':phys_play' => $phys_play,
          ':imag_play' => $imag_play,
          ':rest_play' => $rest_play,
          ':rules_play' => $rules_play,
          ':bio_play' => $bio_play,
          ':perennial' => $perennial,
          ':annual' => $annual,
          ':full_sun' => $full_sun,
          ':partial_shade' => $partial_shade,
          ':full_shade' => $full_shade
        )
      );

      $tag_id = exec_sql_query($database, "SELECT tags.id FROM tags WHERE (tag_name= :tag_name);")->fetch();

      $plant_id = $database->lastInsertId('id');

      $insert_tags = exec_sql_query(
        $database,
        "INSERT INTO tag_entries (plant_id, tag_id) VALUES (:plant_id, :tag_id)",
        array(
          ':plant_id' => $plant_id,
          ':tag_id' => $tag_id

        )
      );


      if ($insert) {
        $insert_successful = True;
      }
    } else {
      $sticky_name = $plant_name;
      $sticky_number = $plant_number;
      $sticky_genus = $plant_genus;
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
    <?php if ($insert_successful) { ?>
      <p>Plant successfully added!. <a href="/">Back to catalog.</a></p>
    <?php } else { ?>
      <a href="/">Cancel</a>
      <form action="add" method="post" novalidate>
        <?php if ($name_not_unique) { ?>
          <p class="invalid">This plant shares the same name as another plant in our catalog. Please choose a different name!</p>
        <?php } ?>
        <div class="label-input">
          <p class="invalid <?php echo htmlspecialchars($name_feedback_class); ?>">Please enter a plant name.</p>
          <label for="name">Plant Name:</label>
          <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($sticky_name); ?>" />
        </div>
        <?php if ($number_not_unique) { ?>
          <p class="invalid">This plant shares the same number as another plant in our catalog. Please choose a different number!</p>
        <?php } ?>
        <div class="label-input">
          <p class="invalid <?php echo htmlspecialchars($number_feedback_class); ?>">Please enter a plant number.</p>
          <label for="number">Plant Number:</label>
          <input id="number" type="text" name="number" value="<?php echo htmlspecialchars($sticky_number); ?>" />
        </div>
        <div class="label-input">
          <p class="invalid <?php echo htmlspecialchars($genus_feedback_class); ?>">Please enter a genus.</p>
          <label for="genus">Plant Genus:</label>
          <input id="genus" type="text" name="genus" value="<?php echo htmlspecialchars($sticky_genus); ?>" />
        </div>
        <h3>Types of play supported</h3>
        <div class="flex-row flex-start">
          <div class="flex-col">
            <label class="label-filter" for="expl_con"><input type="checkbox" value="1" name="expl_con" <?php echo htmlspecialchars($sticky_expl_con); ?> />Exploratory Constructive</label><br>

            <label class="label-filter" for="expl_sen"><input type="checkbox" value="1" name="expl_sen" <?php echo htmlspecialchars($sticky_expl_sen); ?> />Exploratory Sensory</label><br>

            <label class="label-filter" for="phys_play"><input type="checkbox" value="1" name="phys_play" <?php echo htmlspecialchars($sticky_phys_play); ?> />Physical Play</label><br>

            <label class="label-filter" for="imag_play"><input type="checkbox" value="1" name="imag_play" <?php echo htmlspecialchars($sticky_imag_play); ?> />Imaginative Play</label><br>
          </div>
          <div class="flex-col">
            <label class="label-filter" for="rest_play"><input type="checkbox" value="1" name="rest_play" <?php echo htmlspecialchars($sticky_rest_play); ?> />Restorative Play</label><br>

            <label class="label-filter" for="rules_play"><input type="checkbox" value="1" name="rules_play" <?php echo htmlspecialchars($sticky_rules_play); ?> />Play with Rules</label><br>

            <label class="label-filter" for="bio_play"><input type="checkbox" value="1" name="bio_play" <?php echo htmlspecialchars($sticky_bio_play); ?> />Bio Play</label><br>
          </div>
        </div>
        <div class="flex-col">
          <h3>Growing needs and characteristics:</h3>
          <label class="label-filter" for="perennial"><input type="checkbox" value="1" name="perennial" <?php echo htmlspecialchars($sticky_perennial); ?> />Perennial</label><br>

          <label class="label-filter" for="annual"><input type="checkbox" value="1" name="annual" <?php echo htmlspecialchars($sticky_annual); ?> />Annual</label><br>

          <label class="label-filter" for="full_sun"><input type="checkbox" value="1" name="full_sun" <?php echo htmlspecialchars($sticky_full_sun); ?> />Full Sun</label><br>

          <label class="label-filter" for="partial_shade"><input type="checkbox" value="1" name="partial_shade" <?php echo htmlspecialchars($sticky_partial_shade); ?> />Partial Shade</label><br>

          <label class="label-filter" for="full_shade"><input type="checkbox" value="full_shade" name="1" <?php echo htmlspecialchars($sticky_full_shade); ?> />Bio Play</label><br>

        </div>
        <label for="tag">Tag:</label>
        <select id="tag" name="tag">
          <option value=''>No Tag</option>
          <option value='shrub' <?php echo $sticky_shrub; ?>>Shrub</option>
          <option value='grass' <?php echo $sticky_grass; ?>>Grass</option>
          <option value='vine' <?php echo $sticky_vine; ?>>Vine</option>
          <option value='tree' <?php echo $sticky_tree; ?>>Tree</option>
          <option value='flower' <?php echo $sticky_flower; ?>>Flower</option>
          <option value='groundcovers' <?php echo $sticky_groundcovers; ?>>Grouncovers</option>
          <option value='other' <?php echo $sticky_other; ?>>Other</option>
        </select>
        </div>
        <p>Feel free to add a picture to this entry later on the Edit a Plant page!</p>
        <input type="hidden" name="add" value="<?php echo htmlspecialchars($plant_name); ?>" />
        <button type="submit">Add Plant</button>
      </form>
    <?php }  ?>
  </main>
</body>

</html>
