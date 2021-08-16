<?php
// require files
require_once(__DIR__ . '/../utils/database.php');
require_once(__DIR__ . "/../utils/strings.php");
$configs = include(__DIR__ . '/../utils/settings.php');

// establish our db connection
$db = new Database();
$db->connect();
$db->selectDatabase();

// initiate query
$query = $db->link->prepare("SELECT stock_name, MAX(image_path) FROM stock WHERE (in_stock != 0) GROUP BY stock_name");
$query->execute();
$query->store_result();
$db->disconnect();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require(__DIR__ . '/../partials/meta.php');?>
    </head>
    <body>
        <?php require(__DIR__ . '/../partials/header.php');?>
        <main role="main" class="container">
            <?php
                mysqli_stmt_bind_result($query, $stock_name, $image_path);
                $i = 0;
                while (mysqli_stmt_fetch($query)) {
                    $normalName = convertToNormal($stock_name);
                    if ($i % 4 === 0) echo "<section class='row'>";
                    $stock_slug = convertToSlug($stock_name);
                    $stockType = $configs["stockType"];
                    echo "<div class='column-quarter'>
                        <a href='/${stockType}/${stock_slug}' class='stock-card'>
                            <img class='stock-image' src='/public/${image_path}' alt='ID ${stock_id}'>
                            <h4 class='stock-title'>
                                ${normalName}
                            </h4>
                        </a>
                    </div>";
                    if ($i % 4 === 3) echo "</section>";
                    $i++;
                }

                // we didn't close a row in the loop
                if ($i % 4 !== 0) echo "</section>";
            ?>
        </main>
        <?php require(__DIR__ . '/../partials/footer.php');?>
    </body>
</html>