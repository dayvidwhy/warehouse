<?php
$configs = include(__DIR__ . '/../utils/settings.php');
?>
<header role="banner" class="banner">
    <div class="container">
        <div class="row">
            <a class="banner-heading" href="/">
                <h1 class="banner-actual">
                    <?php echo $configs["name"]; ?>
                </h1>
            </a>
            <a class="banner-heading" href="/generate">
                <h1 class="banner-actual">
                    Generate
                </h1>
            </a>
        </div>
    </div>
</header>