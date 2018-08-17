<?php
namespace App\SizeSorter;

use App\SizeSorter\iSizeSorter;

Class ClothingShortSorter implements iSizeSorter {

    public function sort(array $sizes) {

        $sizeRank = [
            "XS" => 0,
            "S" => 1,
            "M" => 2,
            "L" => 3,
            "XL" => 4,
            "XXL" => 5,
            "XXXL" => 6,
            "XXXXL" => 7
        ];

        usort($sizes, function ($size1, $size2) use ($sizeRank) {
            return $sizeRank[$size1['size']] <=> $sizeRank[$size2['size']];
        });

        return $sizes;
    }
}
