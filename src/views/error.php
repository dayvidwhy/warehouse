<?php
$configs = include(__DIR__ . '/../utils/settings.php');
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
                    Page Not Found
                </h2>
                <p class="card-text">
                    Page was not here.
                </p>
                <a class="error-link" href="/">
                    Home
                </a>
            </div>
        </main>
        <?php require('partials/footer.php');?>
    </body>
</html>