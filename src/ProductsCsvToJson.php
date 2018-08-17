<?php
namespace App;

use App\SizeSorter\iSizeSorter;

Class ProductsCsvToJson {

    private $shoeUKSorter;
    private $numericSorter;
    private $clothingShortSorter;

    public function __construct(
        iSizeSorter $shoeUKSorter, 
        iSizeSorter $numericSorter, 
        iSizeSorter $clothingShortSorter
    ) {
        $this->shoeUKSorter = $shoeUKSorter;
        $this->numericSorter = $numericSorter;
        $this->clothingShortSorter = $clothingShortSorter;
    }

    private function csvToArrays(string $csvFile) {
        return array_map('str_getcsv', file($csvFile));
    }

    private function sortSizes(array $sizes, string $sortType) {
        $sortMap = [
            'SHOE_UK' => $this->shoeUKSorter,
            'SHOE_EU' => $this->numericSorter,
            'CLOTHING_SHORT' => $this->clothingShortSorter,
        ];

        $sorter = $sortMap[$sortType];

        return $sorter->sort($sizes);
    }

    public function convert(string $csvFile) {

        $csvRows = $this->csvToArrays($csvFile);
        $products = [];

        foreach ($csvRows as $row) {
            list($sku, $plu, $name, $size, $sizeSort) = $row;

            if (!isset($products[$plu])) {
                $products[$plu] = [
                    'PLU' => trim($plu),
                    'name' => trim($name),
                    'sizeSort' => trim($sizeSort),
                    'sizes' => [ [ 'SKU' => trim($sku), 'size' => trim($size) ] ]
                ];
            } else {
                $products[$plu]['sizes'][] = [ 'SKU' => trim($sku), 'size' => trim($size) ];
            }
        }

        $sortedProducts = [];

        foreach ($products as $product) {
            $product['sizes'] = $this->sortSizes($product['sizes'], $product['sizeSort']);
            unset($product['sizeSort']);

            $sortedProducts[] = $product;
        }

        return json_encode($sortedProducts, JSON_PRETTY_PRINT);
    }
}
