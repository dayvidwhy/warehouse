<?php
// require files
require_once(__DIR__ . '/../scripts/connect.php');
$configs = include(__DIR__ . '/../scripts/settings.php');


// establish our db connection
$db = new MySQLDatabase();
$db->connect();

// initiate query
$query = $db->link->prepare("SELECT stock_name, MAX(image_path) FROM stock WHERE (in_stock != 0) GROUP BY stock_name");
$query->execute();
$query->store_result();
$db->disconnect();

function convertToSlug ($normal) {
    return strtolower(implode('-', explode(' ', $normal)));
}

function convertToNormal ($slug) {
    $slug = strtolower($slug);
    return ucwords(implode(' ', explode('-', $slug)));
}

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
        <?php
            // bind the results
            mysqli_stmt_bind_result($query, $stock_name, $image_path);
            $i = 0;
            while (mysqli_stmt_fetch($query)) {
                $normalName = convertToNormal($stock_name);
                // start of a row
                if ($i % 4 === 0) echo "<div class='row'>";
                // start of a control column
                if ($i % 2 === 0) echo "<div class='con-col'>";
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
                // end of a control column
                if ($i % 2 === 1) echo "</div>";
                // end of a row
                if ($i % 4 === 3) echo "</div>";
                // bu
                $i++;
            }

            // we didn't close con-col in the loop
            if ($i % 2 !== 0) echo "</div>";
            // we didn't close a row in the loop
            if ($i % 4 !== 0) echo "</div>";
        ?>
        </section>
    </main>
    <?php require(__DIR__ . '/../partials/footer.php');?>
</body>
</html>