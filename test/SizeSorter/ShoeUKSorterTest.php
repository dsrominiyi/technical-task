<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use App\SizeSorter\ShoeUKSorter;

class ShoeUKSorterTest extends TestCase {
    public $sorter;

    protected function setUp() {
        $this->sorter = new ShoeUKSorter();
    }

    public function testSortUKShoeSizes() {
        $sizes = [
            [ 'SKU' => '***', 'size' => '6' ],
            [ 'SKU' => '***', 'size' => '4' ],
            [ 'SKU' => '***', 'size' => '5' ],
            [ 'SKU' => '***', 'size' => '3.5' ],
            [ 'SKU' => '***', 'size' => '10.5 (Child)' ],
            [ 'SKU' => '***', 'size' => '4 (Child)' ],
            [ 'SKU' => '***', 'size' => '5 (Child)' ],
            [ 'SKU' => '***', 'size' => '3.5 (Child)' ],
        ];

        $sortedSizes = $this->sorter->sort($sizes);

        $this->assertEquals(8, count($sortedSizes));

        $this->assertEquals($sizes[7], $sortedSizes[0]);
        $this->assertEquals($sizes[5], $sortedSizes[1]);
        $this->assertEquals($sizes[6], $sortedSizes[2]);
        $this->assertEquals($sizes[4], $sortedSizes[3]);
        $this->assertEquals($sizes[3], $sortedSizes[4]);
        $this->assertEquals($sizes[1], $sortedSizes[5]);
        $this->assertEquals($sizes[2], $sortedSizes[6]);
        $this->assertEquals($sizes[0], $sortedSizes[7]);
    }
}
