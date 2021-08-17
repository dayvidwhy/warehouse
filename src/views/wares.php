<?php
// require files
require_once(__DIR__ . '/../utils/database.php');
require_once(__DIR__ . "/../utils/strings.php");
$configs = include(__DIR__ . '/../utils/settings.php');

// establish our db connection
$db = new Database();
$db->connect();
$db->selectDatabase();
$results = $db->fetchCategories();
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
            <section class="row">
                <p class="breadcrumb">
                    <a class="breadcrumb-link" href="/"><?php echo ucfirst($configs["stockType"]); ?></a>
                </p>
            </section>
            <?php for ($rowCount = 0; $rowCount < (ceil(sizeof($results) / 4)); $rowCount++) { ?>
                <section class='row'>
                    <?php for ($itemCount = 0; $itemCount < 4; $itemCount++) { ?>
                        <?php 
                            $currentRow = ($rowCount * 4) + $itemCount;
                            if ($currentRow === sizeof($results)) break;
                            $stockType = $configs["stockType"];
                            $stock_slug = convertToSlug($results[$currentRow]["stock_name"]);
                        ?>
                        <div class='column-quarter'>
                            <a href='/<?php echo $stockType; ?>/<?php echo $stock_slug; ?>' class='stock-card'>
                                <img
                                    class='stock-image'
                                    src='/public/<?php echo $results[$currentRow]["MAX(image_path)"]; ?>'
                                    alt='Image ID <?php echo $results[$currentRow]["stock_id"]; ?>'>
                                <h4 class='stock-title'>
                                    <?php echo convertToNormal($results[$currentRow]["stock_name"]); ?>
                                </h4>
                            </a>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </main>
        <?php require(__DIR__ . '/../partials/footer.php');?>
    </body>
</html>