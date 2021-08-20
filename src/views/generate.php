<?php
$traversal = new traversal();
$imageData = $traversal->getStockImages();

// establish our db connection
$database = new database();
$database->addStocks($imageData);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php require('partials/meta.php');?>
        <link rel="canonical" href="<?php echo $configs["baseURL"]; ?>">
    </head>
    <body>
        <?php require('partials/header.php');?>
        <main role="main" class="container">
            <div class="row">
                <h2 class="banner-actual">
                    Generation complete
                </h2>
                <p class="card-text">
                    You can head back home now
                </p>
                <a class="error-link" href="/">
                    Home
                </a>
            </div>
        </main>
        <?php require('partials/footer.php');?>
    </body>
</html>