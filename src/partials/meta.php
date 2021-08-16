<?php
$configs = include(__DIR__ . '/../scripts/settings.php');
?>
<meta charset="utf-8"> 
<meta name="theme-color" content="#838383">
<meta name="description" content="<?php echo $configs["description"]; ?>">
<meta name="keywords" content="<?php echo $configs["keywords"]; ?>">
<meta name="robots" content="index,follow">
<meta name="author" content="<?php echo $configs["name"]; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel='stylesheet' href='/public/css/styles.css'/>
<title><?php echo $configs["name"]; ?></title>
<link rel="canonical" <?php echo 'href="' . $configs["baseURL"] . $_SERVER['REQUEST_URI'] . '"'; ?> />