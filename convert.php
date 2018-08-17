<?php

require_once __DIR__ . '/autoload.php';

use App\ProductsCsvToJson;
use App\SizeSorter\ShoeUKSorter;
use App\SizeSorter\NumericSorter;
use App\SizeSorter\ClothingShortSorter;

$converter = new ProductsCsvToJson(
    new ShoeUKSorter(),
    new NumericSorter(),
    new ClothingShortSorter()
);

file_put_contents('products.json', $converter->convert(__DIR__ . '/' . $argv[1]));
