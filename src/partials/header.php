<?php
$configs = include(__DIR__ . '/../scripts/settings.php');
?>
<header role="banner" class="banner">
    <div class="container">
        <div class="row">
            <a class="banner-heading" href="/">
                <h1 class="banner-actual">
                    <?php echo $configs["name"]; ?>
                </h1>
            </a>
        </div>
    </div>
</header>