<?php 
// require files
$configs = include(__DIR__ . '/../utils/settings.php');

$uriSections = explode('/', $_SERVER['REQUEST_URI']);
if (sizeof($uriSections) > 3) {
  header("Location: /");
}
$search = filter_var($uriSections[2], FILTER_SANITIZE_STRING); 

// establish our db connection
$db = new Database();
$results = $db->fetchStock($search);

// stock in database?
if (sizeof($results) === 0) {
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
                <p class="breadcrumb">
                    <a class="breadcrumb-link" href="/"><?php echo ucfirst($configs["stockType"]); ?></a> - <?php echo strings::convertToNormal($search);?>
                </p>
            </section>
            <?php for ($rowCount = 0; $rowCount < (ceil(sizeof($results) / 4)); $rowCount++) { ?>
                <section class='row'>
                    <?php for ($itemCount = 0; $itemCount < 4; $itemCount++) { ?>
                        <?php 
                            $currentRow = ($rowCount * 4) + $itemCount;
                            if ($currentRow === sizeof($results)) break;
                        ?>
                        <div class='column-quarter'>
                            <a href='/public/<?php echo $results[$currentRow]["image_large"]; ?>' class='stock-card'>
                                <img
                                    class='stock-image'
                                    src='/public/<?php echo $results[$currentRow]["image_path"]; ?>'
                                    alt='Image ID <?php echo $results[$currentRow]["stock_id"]; ?>'>
                                <h4 class='stock-title'>
                                    <?php echo strings::convertToNormal($results[$currentRow]["stock_story"]); ?>
                                </h4>
                                <p class='stock-description'>
                                    ID: <?php echo $results[$currentRow]["stock_id"]; ?>
                                </p>
                            </a>
                        </div>
                    <?php } ?>
                </section>
            <?php } ?>
        </main>
        <?php require(__DIR__ . '/../partials/footer.php');?>
    </body>
</html>