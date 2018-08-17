<?php

use PHPUnit\Framework\TestCase;

use App\SizeSorter\ShoeUKSorter;
use App\SizeSorter\NumericSorter;
use App\SizeSorter\ClothingShortSorter;
use App\ProductsCsvToJson;

class ProductsCsvToJsonTest extends TestCase {
    public $testFile;
    public $shoeUKSorter;
    public $numericSorter;
    public $clothingShortSorter;
    public $converter;

    protected function setUp() {
        $this->testFile = __DIR__ . '/data/test.csv';

        $this->shoeUKSorter = Mockery::spy(ShoeUKSorter::class);
        $this->numericSorter = Mockery::spy(NumericSorter::class);
        $this->clothingShortSorter = Mockery::spy(ClothingShortSorter::class);

        $this->shoeUKSorter->shouldReceive('sort')->andReturn('sortedShoeUKSizes');
        $this->numericSorter->shouldReceive('sort')->andReturn('sortedNumericSizes');
        $this->clothingShortSorter->shouldReceive('sort')->andReturn('sortedClothingShortSizes');

        $this->converter = new ProductsCsvToJson(
            $this->shoeUKSorter,
            $this->numericSorter,
            $this->clothingShortSorter
        );
    }

    public function getUnsortedSizes(int $productIndex) {
        $csvRows = array_map('str_getcsv', file($this->testFile));
        $sizes = [];

        $pluList = [ 'AAA', 'AAB', 'AAC', 'AAD', 'AAE' ];
        
        foreach ($csvRows as $row) {
            if (trim($row[1]) === $pluList[$productIndex]) {
                $sizes[] = [ 'SKU' => trim($row[0]), 'size' => trim($row[3]) ];
            }
        }

        return $sizes;
    }

    public function testConvertsTheCsvFileToAJsonString() {
        $products = json_decode($this->converter->convert($this->testFile), 1);
        
        $this->assertEquals(5, count($products));
    }

    public function testGroupsProductsByPLU() {

        $products = json_decode($this->converter->convert($this->testFile), 1);

        $this->assertEquals('AAA', $products[0]['PLU']);
        $this->assertEquals('Random product AAA.', $products[0]['name']);

        $this->assertEquals('AAB', $products[1]['PLU']);
        $this->assertEquals('Random product AAB.', $products[1]['name']);

        $this->assertEquals('AAC', $products[2]['PLU']);
        $this->assertEquals('Random product AAC.', $products[2]['name']);

        $this->assertEquals('AAD', $products[3]['PLU']);
        $this->assertEquals('Random product AAD.', $products[3]['name']);

        $this->assertEquals('AAE', $products[4]['PLU']);
        $this->assertEquals('Random product AAE.', $products[4]['name']);
    }

    public function testSortsSizesByCorrectMethod() {
        
        $products = json_decode($this->converter->convert($this->testFile), 1);

        $this->numericSorter->shouldHaveReceived('sort')->with($this->getUnsortedSizes(0));
        $this->numericSorter->shouldHaveReceived('sort')->with($this->getUnsortedSizes(1));
        $this->numericSorter->shouldHaveReceived('sort')->with($this->getUnsortedSizes(3));
        $this->assertEquals('sortedNumericSizes', $products[0]['sizes']);
        $this->assertEquals('sortedNumericSizes', $products[1]['sizes']);
        $this->assertEquals('sortedNumericSizes', $products[3]['sizes']);

        $this->clothingShortSorter->shouldHaveReceived('sort')->with($this->getUnsortedSizes(2));
        $this->assertEquals('sortedClothingShortSizes', $products[2]['sizes']);

        $this->shoeUKSorter->shouldHaveReceived('sort')->with($this->getUnsortedSizes(4));
        $this->assertEquals('sortedShoeUKSizes', $products[4]['sizes']);
    }
}
