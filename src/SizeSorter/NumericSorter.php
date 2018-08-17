<?php
namespace App\SizeSorter;

use App\SizeSorter\iSizeSorter;

Class NumericSorter implements iSizeSorter {

    public function sort(array $sizes) {

        usort($sizes, function ($size1, $size2) {
            return floatval($size1['size']) <=> floatval($size2['size']);
        });

        return $sizes;
    }
}
