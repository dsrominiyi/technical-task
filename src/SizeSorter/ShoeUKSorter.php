<?php
namespace App\SizeSorter;

use App\SizeSorter\iSizeSorter;
use App\SizeSorter\NumericSorter;

Class ShoeUKSorter implements iSizeSorter {

    public function sort(array $sizes) {

        $childSizes = [];
        $adultSizes = [];

        foreach ($sizes as $size) {
            $size['size'] = strtolower($size['size']);

            if (strpos($size['size'], '(child)')) {
                $size['size'] = trim(str_replace("(child)", "", $size['size']));
                $childSizes[] = $size;
            } else {
                $adultSizes[] = $size;
            }
        }

        $numericSorter = new NumericSorter();

        $sortedChildSizes = $numericSorter->sort($childSizes);
        $sortedAdultSizes = $numericSorter->sort($adultSizes);

        foreach ($sortedChildSizes as $key => $size) {
            $size['size'] .= ' (Child)';
            $sortedChildSizes[$key] = $size;
        }

        return array_merge($sortedChildSizes, $sortedAdultSizes);
    }
}
