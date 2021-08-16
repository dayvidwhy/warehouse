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
            <div class="card">
                <h2 class="card-title">
                    Page Not Found
                </h2>
                <p class="card-text">
                    Page was not here.
                </p>
                <a class="error-link" href="/">
                    Home
                </a>
            </div>
        </div>
    </main>
    <?php require('partials/footer.php');?>
</body>
</html>