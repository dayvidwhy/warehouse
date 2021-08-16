<?php
// converst normal words to kebab-case
function convertToSlug (string $normal): string {
    return strtolower(implode('-', explode(' ', $normal)));
}

// converts kebab-case to normal words
function convertToNormal (string $slug): string {
    $slug = strtolower($slug);
    return ucwords(implode(' ', explode('-', $slug)));
}

// checks that a string ends with another string
function endsWith(string $haystack, string $needle): string {
    return $needle === "" || (substr($haystack, -strlen($needle)) === $needle);
}
?>