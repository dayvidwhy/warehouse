<?php declare(strict_types=1);

class traversal {
    // tests if a file at a given path is an image type
    private function isImage(string $stockFileName): bool {
        return str_starts_with(mime_content_type($stockFileName), "image/");
    }

    // tests if what we're iterating over is a directory
    private function isDirectory ($path): bool {
        return $path->isDir();
    }

    public function getStockImages (): array {
        // create the iterator to traverse our stock directory
        $directory = new RecursiveDirectoryIterator(__DIR__ . "/../public/stock");
        $iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::SELF_FIRST);

        $imageData = array();
        foreach ($iterator as $path) {
            // skip directories and non image files
            if ($this->isDirectory($path)) continue;
            $imagePath = $path->__toString();
            if (!$this->isImage($imagePath)) continue;

            // found an image, get the string
            $imagePath = substr($imagePath, strpos($imagePath, ".."));

            // pieces of the directory
            $dirSplit = explode('/', $imagePath);

            // the name of the stock or range
            $stockName = $dirSplit[3];

            // the potential story of name
            $stockStory = "";

            // where image is stored
            $imageDir = "";

            // file name or id
            $stockFileName = "";

            if (sizeof($dirSplit) == 5) {
                $stockStory = $stockName;
                $stockFileName = $dirSplit[4];
                $imageDir = 'stock/' . $stockName . '/' . $stockFileName;
            } else if (sizeof($dirSplit) == 6) {
                $stockStory = $dirSplit[4];
                $stockFileName = $dirSplit[5];
                $imageDir = 'stock/' . $stockName . '/' . $stockStory . '/' . $stockFileName;
            }            

            $stockId = substr($stockFileName, 0, strlen($stockFileName) - 4);

            // insert into the database
            $inStock = '1';
            array_push($imageData, [$stockId, $stockName, $imageDir, $stockStory, $inStock]);
        }
        return $imageData;
    }
}
?>