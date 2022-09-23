<?php
$title = '404 Error'
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
    <p class="text-center">This page does not exist. Feel free to look at our Catalog page or Submit Form page to get back on track.</p>
  </main>
</body>

</html>
