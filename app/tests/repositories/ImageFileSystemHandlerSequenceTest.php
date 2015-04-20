<?php namespace Tests\Repositories;

use Tests\TestCase as TestCase;

use Models\Filesystem\Image as Image;
use Repositories\Filesystem\DiskFilesystem as DiskFilesystem;
use Repositories\Date\Carbon as Carbon;
use Repositories\ImageHandler\ImageFilesystemHandler as ImageFilesystemHandler;

class ImageFilesystemHandlerSequenceTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->imageFilesystemHandler = new ImageFilesystemHandler(new DiskFilesystem, new Carbon);
    }

    public function createImage($key)
    {
        $image = new Image();
        $image->parse($key);
        return $image;
    }

    public function testEmptyListOfImages()
    {
        $images = [];

        $page = "1";
        $maxTimeBetweenTwoImages = "12";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page1));

        $page = "2";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page2));
    }

    public function testValidSequenceOfOneImage()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(1, count($page1));

        $page = "2";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page2));
    }

    public function testSequenceOfTwoImagesByOnePage()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page1));

        $page = "2";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page2));
    }

    public function testSequenceOfTwoImagesByTwoPages()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            
            $this->createImage("1417696350_0.jpg"), // 13:32:30
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(1, count($page1));

        $page = "2";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(1, count($page2));

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }

    public function testSequenceOfThreeImagesDevidedInTwoPagesByTwoAndOne()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 

            $this->createImage("1417696350_0.jpg"), // 13:32:30
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);

        // ---------------------
        // Move to the next page

        $page = "2";
        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);
        $this->assertEquals(1, count($page2));
        $this->assertEquals($images[2], $page2[2]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }

    public function testSequenceOfFourImagesDevidedInTwoPagesByTwoAndTwo()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);

        // ---------------------
        // Move to the next page

        $page = "2";
        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);
        $this->assertEquals(2, count($page2));
        $this->assertEquals($images[2], $page2[2]);
        $this->assertEquals($images[3], $page2[3]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }

    public function testSequenceOfFourImagesDevidedInTwoPagesByThreeAndOne()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            $this->createImage("1417695952_0.jpg"), // 13:25:52

            $this->createImage("1417696350_0.jpg"), // 13:32:30
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        $this->assertEquals($images[2], $page1[2]);

        // ---------------------
        // Move to the next page

        $page = "2";
        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);
        $this->assertEquals(1, count($page2));
        $this->assertEquals($images[3], $page2[3]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }

    public function testSequenceOfFiveImagesDevidedInTwoPagesByThreeAndTwo()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            $this->createImage("1417695952_0.jpg"), // 13:25:52

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        $this->assertEquals($images[2], $page1[2]);

        // ---------------------
        // Move to the next page

        $page = "2";

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page2));
        $this->assertEquals($images[3], $page2[3]);
        $this->assertEquals($images[4], $page2[4]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }

    public function testSequenceOfSixImagesDevidedInThreePagesByThreeOneAndTwo()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            $this->createImage("1417695952_0.jpg"), // 13:25:52

            $this->createImage("1417696012_0.jpg"), // 13:26:52

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        $this->assertEquals($images[2], $page1[2]);

        // ---------------------
        // Move to the next page

        $page = "2";

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(1, count($page2));
        
        $this->assertEquals($images[3], $page2[3]);

        // ---------------------
        // Move to the next page

        $page = "3";

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page3));

        $this->assertEquals($images[4], $page3[4]);
        $this->assertEquals($images[5], $page3[5]);

        // ---------------------
        // Move to the next page

        $page = "4";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page4 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page4));
    }


    public function testSequenceOfSixImagesDevidedInThreePagesByTwoTwoAndTwo()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            
            $this->createImage("1417696012_0.jpg"), // 13:26:52
            $this->createImage("1417696013_0.jpg"), // 13:25:53

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        
        // ---------------------
        // Move to the next page

        $page = "2";

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page2));
        
        $this->assertEquals($images[2], $page2[2]);
        $this->assertEquals($images[3], $page2[3]);

        // ---------------------
        // Move to the next page

        $page = "3";

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(2, count($page2));

        $this->assertEquals($images[4], $page3[4]);
        $this->assertEquals($images[5], $page3[5]);

        // ---------------------
        // Move to the next page

        $page = "4";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page4 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page4));
    }

    public function testSequenceOfSixImagesDevidedInTwoPagesByThreeAndThree()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            $this->createImage("1417695952_0.jpg"), // 13:25:52

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
            $this->createImage("1417696352_0.jpg"), // 13:32:32
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds
        
        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        $this->assertEquals($images[2], $page1[2]);

        // ---------------------
        // Move to the next page

        $page = "2";

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page2));
        $this->assertEquals($images[3], $page2[3]);
        $this->assertEquals($images[4], $page2[4]);
        $this->assertEquals($images[5], $page2[5]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }


    public function testSequenceOfSevenImagesDevidedInTwoPagesByFourAndThree()
    {
        $images = [
            $this->createImage("1417695950_0.jpg"), // 13:25:50
            $this->createImage("1417695951_0.jpg"), // 13:25:51 
            $this->createImage("1417695952_0.jpg"), // 13:25:52
            $this->createImage("1417695953_0.jpg"), // 13:25:53

            $this->createImage("1417696350_0.jpg"), // 13:32:30
            $this->createImage("1417696351_0.jpg"), // 13:32:31
            $this->createImage("1417696352_0.jpg"), // 13:32:32
        ];

        $page = "1";
        $maxTimeBetweenTwoImages = "12"; // seconds
        
        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page1 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(4, count($page1));

        $this->assertEquals($images[0], $page1[0]);
        $this->assertEquals($images[1], $page1[1]);
        $this->assertEquals($images[2], $page1[2]);
        $this->assertEquals($images[3], $page1[3]);
        
        // ---------------------
        // Move to the next page

        $page = "2";

        $page2 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(3, count($page2));
        $this->assertEquals($images[4], $page2[4]);
        $this->assertEquals($images[5], $page2[5]);
        $this->assertEquals($images[6], $page2[6]);

        // ---------------------
        // Move to the next page

        $page = "3";

        // -----------------------------------------------------------
        // Process the images according the parameters specified above

        $page3 = $this->imageFilesystemHandler->getSequence($images, $page, $maxTimeBetweenTwoImages);

        $this->assertEquals(0, count($page3));
    }
}