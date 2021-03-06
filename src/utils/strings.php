<?php declare(strict_types=1);

// utility class for strings
class strings {
    // converst normal words to kebab-case
    public static final function convertToSlug (string $normal): string {
        return strtolower(implode('-', explode(' ', $normal)));
    }
    
    // converts kebab-case to normal words
    public static final function convertToNormal (string $slug): string {
        $slug = strtolower($slug);
        return ucwords(implode(' ', explode('-', $slug)));
    }
}
?>