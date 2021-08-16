<?php
// converst normal words to kebab-case
function convertToSlug ($normal) {
    return strtolower(implode('-', explode(' ', $normal)));
}

// converts kebab-case to normal words
function convertToNormal ($slug) {
    $slug = strtolower($slug);
    return ucwords(implode(' ', explode('-', $slug)));
}

// checks that a string ends with another string
function endsWith($haystack, $needle) {
    return $needle === "" || (substr($haystack, -strlen($needle)) === $needle);
}
?>