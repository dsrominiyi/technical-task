<?php
namespace Test;

use PHPUnit\Framework\TestCase;
use App\SizeSorter\NumericSorter;

class NumericSorterTest extends TestCase {
    public $sorter;

    protected function setUp() {
        $this->sorter = new NumericSorter();
    }

    public function testSortNumericSizes() {
        $sizes = [
            [ 'SKU' => '***', 'size' => '6' ],
            [ 'SKU' => '***', 'size' => '4' ],
            [ 'SKU' => '***', 'size' => '5' ],
            [ 'SKU' => '***', 'size' => '3' ],
        ];

        $sortedSizes = $this->sorter->sort($sizes);

        $this->assertEquals(4, count($sortedSizes));

        $this->assertEquals($sizes[3], $sortedSizes[0]);
        $this->assertEquals($sizes[1], $sortedSizes[1]);
        $this->assertEquals($sizes[2], $sortedSizes[2]);
        $this->assertEquals($sizes[0], $sortedSizes[3]);
    }
}
