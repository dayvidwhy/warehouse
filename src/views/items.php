<?php 
// require files
require_once(__DIR__ . '/../utils/database.php');
require_once(__DIR__ . "/../utils/strings.php");
$configs = include(__DIR__ . '/../utils/settings.php');

$uriSections = explode('/', $_SERVER['REQUEST_URI']);
if (sizeof($uriSections) > 3) {
  header("Location: /");
}

// establish our db connection
$db = new Database();
$db->connect();

// initiate query
$query = $db->link->prepare("SELECT * FROM stock WHERE (stock_name = ?) AND (in_stock != 0)");
$search = filter_var($uriSections[2], FILTER_SANITIZE_STRING); 
$query->bind_param("s", $search);
$query->execute();
$query->store_result();
$db->disconnect();

// stock in database?
if ($query->num_rows === 0) {
    // wasnt in list, send them away
    header("Location: /");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require(__DIR__ . '/../partials/meta.php'); ?>
</head>
<body>
    <?php require(__DIR__ . '/../partials/header.php');?>
    <main role="main" class="container">
        <section class="row">
            <div class="card">
                <p class="breadcrumb">
                    <a class="breadcrumb-link" href="/"><?php echo ucfirst($configs["stockType"]); ?></a> - <?php echo convertToNormal($search);?>
                </p>
            </div>
        </section>
        <?php
            mysqli_stmt_bind_result($query, $stock_id, $stock_name, $image_path, $stock_story, $image_large, $in_stock);
            $i = 0;
            while (mysqli_stmt_fetch($query)) {
                $normalStory = convertToNormal($stock_story);
                $normalSearch = convertToNormal($search);
                if ($i % 4 === 0) echo "<section class='row'>";
                echo "<div class='column-quarter'>
                    <a href='/public/${image_large}' class='stock-card'>
                        <img class='stock-image' src='/public/${image_path}' alt='Image ID ${stock_id}'>
                        <h4 class='stock-title'>
                            ${normalStory}
                        </h4>
                        <p class='stock-description'>
                            ID: ${stock_id}
                        </p>
                    </a>
                </div>";
                if ($i % 4 === 3) echo "</section>";
                $i++;
            }
            
            if ($i % 4 !== 0) echo "</section>";
        ?>
    </main>
    <?php require(__DIR__ . '/../partials/footer.php');?>
</body>
</html>