<?php
$title = 'Details';
include_once('includes/sessions.php');
$database = init_sqlite_db('db/site.sqlite', 'db/init.sql');

$name = $_GET['name'] ?? NULL; // untrusted
$plant_name = $name; // tainted

// Check to see if plant exists and then fetch db record
// Inner joining just so I can get the tag name
if ($plant_name) {
  $plant = exec_sql_query(
    $database,
    "SELECT * FROM plants INNER JOIN tag_entries ON plants.id = tag_entries.plant_id INNER JOIN tags ON tags.id = tag_entries.tag_id WHERE plant_name = :plant_name;",
    array(':plant_name' => $plant_name)
  )->fetch();
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
    <a href="/" class="plant-detailed-options">Back to Catalog</a>
    <?php if (is_user_logged_in()) { ?>
      <a href="/plant/edit?<?php echo http_build_query(array('name' => htmlspecialchars($plant['plant_name']))); ?>" class="plant-detailed-options" style="margin-left:70px;">Edit Plant</a>
    <?php } ?>
    <div class="container-plant">
      <?php
      $path = "/public/uploads/images/" . htmlspecialchars($plant['plant_number']) . ".jpg";
      ?>
      <img src=<?php echo $path ?> class="detailed_plant" onerror="this.onerror=null; this.src='/public/images/photo_unavailable.jpg'">
      <h2><?php echo htmlspecialchars($plant['plant_name']); ?></h2>
      <?php if (!is_user_logged_in()) { ?>
        <h3>Tag: <?php echo htmlspecialchars(ucfirst($plant['name'])) ?></h3>
        <h3>Growing needs and characteristics:</h3>
        <ul>
          <?php if ($plant['perennial'] == 1) { ?>
            <li>Perennial</li>
          <?php } ?>
          <?php if ($plant['annual'] == 1) { ?>
            <li>Annual</li>
          <?php } ?>
          <?php if ($plant['full_sun'] == 1) { ?>
            <li>Full Sun</li>
          <?php } ?>
          <?php if ($plant['partial_shade'] == 1) { ?>
            <li>Partial Shade</li>
          <?php } ?>
          <?php if ($plant['full_shade'] == 1) { ?>
            <li>Full Shade</li>
          <?php } ?>
        </ul>
      <?php } ?>
      <?php if (is_user_logged_in()) { ?>
        <h3><?php echo htmlspecialchars($plant['plant_number']); ?></h3>
        <h3><?php echo htmlspecialchars($plant['plant_genus']); ?></h3>
        <h3>Play types supported: </h3>
        <ul>
          <?php if ($plant['expl_con'] == 1) { ?>
            <li>Exploratory Constructive</li>
          <?php } ?>
          <?php if ($plant['expl_sen'] == 1) { ?>
            <li>Exploratory Sensory</li>
          <?php } ?>
          <?php if ($plant['phys_play'] == 1) { ?>
            <li>Physical Play</li>
          <?php } ?>
          <?php if ($plant['imag_play'] == 1) { ?>
            <li>Imaginative Play</li>
          <?php } ?>
          <?php if ($plant['rest_play'] == 1) { ?>
            <li>Restorative Play</li>
          <?php } ?>
          <?php if ($plant['rules_play'] == 1) { ?>
            <li>Play with Rules</li>
          <?php } ?>
          <?php if ($plant['bio_play'] == 1) { ?>
            <li>Bio Play</li>
          <?php } ?>
        </ul>
      <?php } ?>
    </div>
  </main>
</body>

</html>
