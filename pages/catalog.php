<?php
$title = 'Our Plants';
$database = init_sqlite_db('db/site.sqlite', 'db/init.sql');

$is_filter_valid = False;
$is_sort_valid = False;

$filter_feedback_class = 'hidden';
$sort_feedback_class = 'hidden';

include_once('includes/sessions.php');


// Tags (consumer)
if (!is_user_logged_in()) {


  $tag = $_GET['tag'] ?? NULL; //untrusted
  $tag_id = $tag; //tainted

  if ($tag_id) {
    $records = exec_sql_query(
      $database,
      "SELECT * FROM plants INNER JOIN tag_entries ON plants.id = tag_entries.plant_id INNER JOIN tags ON tags.id = tag_entries.tag_id WHERE tag_id = :tag_id;",
      array(':tag_id' => $tag_id)
    )->fetchAll();
  } else {
    $records = exec_sql_query($database, "SELECT * FROM plants;")->fetchAll();
  }
}

// Filtering (admin)
if (is_user_logged_in()) {

  $sql_select = 'SELECT * FROM plants '; //remove semicolon when done
  $sql_where = '';
  $sql_order = '';

  $sql_filter_expression = NULL;
  $sql_filter_expressions = array();

  $filter_expl_con = $_GET['expl_con'] ?? NULL; // untrusted
  $filter_expl_sen = $_GET['expl_sen'] ?? NULL; // untrusted
  $filter_phys_play = $_GET['phys_play'] ?? NULL; // untrusted
  $filter_imag_play = $_GET['imag_play'] ?? NULL; // untrusted
  $filter_rest_play = $_GET['rest_play'] ?? NULL; // untrusted
  $filter_rules_play = $_GET['rules_play'] ?? NULL; // untrusted
  $filter_bio_play = $_GET['bio_play'] ?? NULL; // untrusted

  $sticky_expl_con = ($filter_expl_con ? 'checked' : '');
  $sticky_expl_sen = ($filter_expl_sen ? 'checked' : '');
  $sticky_phys_play = ($filter_phys_play ? 'checked' : '');
  $sticky_imag_play = ($filter_imag_play ? 'checked' : '');
  $sticky_rest_play = ($filter_rest_play ? 'checked' : '');
  $sticky_rules_play = ($filter_rules_play ? 'checked' : '');
  $sticky_bio_play = ($filter_bio_play ? 'checked' : '');

  if ($filter_expl_con) {
    array_push($sql_filter_expressions, "(expl_con = 1)");
  }

  if ($filter_expl_sen) {
    array_push($sql_filter_expressions, "(expl_sen = 1)");
  }

  if ($filter_phys_play) {
    array_push($sql_filter_expressions, "(phys_play = 1)");
  }

  if ($filter_imag_play) {
    array_push($sql_filter_expressions, "(imag_play= 1)");
  }

  if ($filter_rest_play) {
    array_push($sql_filter_expressions, "(rest_play = 1)");
  }

  if ($filter_rules_play) {
    array_push($sql_filter_expressions, "(rules_play = 1)");
  }

  if ($filter_bio_play) {
    array_push($sql_filter_expressions, "(bio_play = 1)");
  }

  if (count($sql_filter_expressions) > 0) {
    $sql_where = ' WHERE ' . implode(' AND ', $sql_filter_expressions);
  }


  // Sorting (admin)

  $sort = $_GET['sort'] ?? NULL; // untrusted

  $sticky_sort = ($sort ? 'checked' : '');

  if ($sort) {
    $sql_order = ' ORDER BY plant_name ASC;';
  }

  $query_string = http_build_query(
    array(
      'expl_con' => $filter_expl_con ?: NULL,
      'expl_sen' => $filter_expl_sen ?: NULL,
      'phys_play' => $filter_phys_play ?: NULL,
      'imag_play' => $filter_imag_play ?: NULL,
      'rest_play' => $filter_rest_play ?: NULL,
      'rules_play' => $filter_rules_play ?: NULL,
      'bio_play' => $filter_bio_play ?: NULL
    )
  );

  $final_query = $sql_select . $sql_where . $sql_order;

  $records = exec_sql_query($database, $final_query)->fetchAll();
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
    <p class="text-center">Take a look at all the plants we have for your every need.</p>
    <?php if (!is_user_logged_in()) { ?>
      <container class="flex-row">
        <div class="tag"><a href="/" class="tag-name">All</a></div>
        <div class="tag"><a href="/?tag=1" class="tag-name">Shrub</a></div>
        <div class="tag"><a href="/?tag=2" class="tag-name">Grass</a></div>
        <div class="tag"><a href="/?tag=3" class="tag-name">Vine</a></div>
        <div class="tag"><a href="/?tag=4" class="tag-name">Tree</a></div>
        <div class="tag"><a href="/?tag=5" class="tag-name">Flower</a></div>
        <div class="tag"><a href="/?tag=6" class="tag-name">Groundcovers</a></div>
        <div class="tag"><a href="/?tag=7" class="tag-name">Other</a></div>
      </container>
    <?php } ?>


    <?php if (is_user_logged_in()) { ?>
      <h2>Filters</h2>
      <hr />
      <div>
        <div>
          <h3>Filter By... </h3>
          <form method="get" action="/" novalidate>
            <div>
              <div class="flex-row flex-start">
                <div class="flex-col">
                  <label class="label-filter" for="expl_con"><input type="checkbox" value="expl_con" name="expl_con" <?php echo $sticky_expl_con; ?> />Exploratory Constructive</label><br>

                  <label class="label-filter" for="expl_sen"><input type="checkbox" value="expl_sen" name="expl_sen" <?php echo htmlspecialchars($sticky_expl_sen); ?> />Exploratory Sensory</label><br>

                  <label class="label-filter" for="phys_play"><input type="checkbox" value="phys_play" name="phys_play" <?php echo htmlspecialchars($sticky_phys_play); ?> />Physical Play</label><br>

                  <label class="label-filter" for="imag_play"><input type="checkbox" value="imag_play" name="imag_play" <?php echo htmlspecialchars($sticky_imag_play); ?> />Imaginative Play</label><br>
                </div>
                <div class="flex-col">
                  <label class="label-filter" for="rest_play"><input type="checkbox" value="rest_play" name="rest_play" <?php echo htmlspecialchars($sticky_rest_play); ?> />Restorative Play</label><br>

                  <label class="label-filter" for="rules_play"><input type="checkbox" value="rules_play" name="rules_play" <?php echo htmlspecialchars($sticky_rules_play); ?> />Play with Rules</label><br>

                  <label class="label-filter" for="bio_play"><input type="checkbox" value="bio_play" name="bio_play" <?php echo htmlspecialchars($sticky_bio_play); ?> />Bio Play</label><br>
                </div>
              </div>
            </div>
            <button type="submit">Apply Filter</button>
            <input type="hidden" name="sort" value="<?php echo htmlspecialchars($sort); ?>" />
        </div>
        </form>

        <div class="input-form">
          <div class="input">
            <h3>Sort By... </h3>
            <form method="get" action="/" novalidate>
              <label class="label-sort" for="sort"><input type="checkbox" value="sort" name="sort" <?php echo htmlspecialchars($sticky_sort) ?> />Sort from A-Z</label><br>
          </div>
          <button type="submit">Apply Sort</button>
          <input type="hidden" name="expl_con" value="<?php echo htmlspecialchars($filter_expl_con); ?>" />
          <input type="hidden" name="expl_sen" value="<?php echo htmlspecialchars($filter_expl_sen); ?>" />
          <input type="hidden" name="phys_play" value="<?php echo htmlspecialchars($filter_phys_play); ?>" />
          <input type="hidden" name="imag_play" value="<?php echo htmlspecialchars($filter_imag_play); ?>" />
          <input type="hidden" name="rest_play" value="<?php echo htmlspecialchars($filter_rest_play); ?>" />
          <input type="hidden" name="rules_play" value="<?php echo htmlspecialchars($filter_rules_play); ?>" />
          <input type="hidden" name="bio_play" value="<?php echo htmlspecialchars($filter_bio_play); ?>" />
        </div>
        </form>
        <a href="/" class="reset-label">Reset All Filters</a>
      </div>
      <hr />
      <div class="add-label">
        <a href="/add">Add a New Plant</a>
      </div>
    <?php } ?>


    <container class="flex-row">
      <?php
      foreach ($records as $record) { ?>
        <div class="flex-col">
          <a href="/plant?<?php echo http_build_query(array('name' => htmlspecialchars($record['plant_name']))); ?>" class="plant-name-catalog">
            <?php
            $path = "/public/uploads/images/" . htmlspecialchars($record['plant_number']) . ".jpg";
            ?>
            <img src=<?php echo $path ?> class="plant-card" onerror="this.onerror=null; this.src='/public/images/photo_unavailable.jpg'" alt="SOURCE OF IMAGE: https://www.istockphoto.com/illustrations/no-image-available">
            <p><?php echo htmlspecialchars($record['plant_name']) ?></p>
          </a>
        </div>
      <?php } ?>
    </container>
  </main>
</body>

</html>
