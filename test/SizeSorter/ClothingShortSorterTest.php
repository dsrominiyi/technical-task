<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use App\SizeSorter\ClothingShortSorter;

class ClothingShortSorterTest extends TestCase {
    public $sorter;

    protected function setUp() {
        $this->sorter = new ClothingShortSorter();
    }

    public function testSortClothingSizes() {
        $sizes = [
            [ 'SKU' => '***', 'size' => 'L' ],
            [ 'SKU' => '***', 'size' => 'XS' ],
            [ 'SKU' => '***', 'size' => 'S' ],
            [ 'SKU' => '***', 'size' => 'XL' ],
            [ 'SKU' => '***', 'size' => 'M' ],
            [ 'SKU' => '***', 'size' => 'XXL' ],
            [ 'SKU' => '***', 'size' => 'XXXXL' ],
            [ 'SKU' => '***', 'size' => 'XXXL' ],
        ];

        $sortedSizes = $this->sorter->sort($sizes);

        $this->assertEquals(8, count($sortedSizes));

        $this->assertEquals($sizes[1], $sortedSizes[0]);
        $this->assertEquals($sizes[2], $sortedSizes[1]);
        $this->assertEquals($sizes[4], $sortedSizes[2]);
        $this->assertEquals($sizes[0], $sortedSizes[3]);
        $this->assertEquals($sizes[3], $sortedSizes[4]);
        $this->assertEquals($sizes[5], $sortedSizes[5]);
        $this->assertEquals($sizes[7], $sortedSizes[6]);
        $this->assertEquals($sizes[6], $sortedSizes[7]);
    }
}
