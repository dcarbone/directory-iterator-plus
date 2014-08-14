<?php

require __DIR__.'/../misc/file-generator.php';

/**
 * Class DirectoryIteratorPlus
 */
class DirectoryIteratorPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @return \DCarbone\DirectoryIteratorPlus
     */
    public function testCanConstructDirectoryIteratorPlusWithValidParameter()
    {
        $dirCollection = new \DCarbone\DirectoryIteratorPlus(__DIR__.'/../misc/couple-of-files');

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $dirCollection);

        return $dirCollection;
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenNonStringValuePassedToConstructor()
    {
        $dirCollection = new \DCarbone\DirectoryIteratorPlus(1000000);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenInvalidDirectoryValuePassedToConstructor()
    {
        $dirCollection = new \DCarbone\DirectoryIteratorPlus('hello there.');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanGetCountOfFilesInDirectory(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $fileCount = $dirCollection->getFileCount();

        $this->assertEquals(11, $fileCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanGetCountOfDirectoriesInDirectory(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $dirCount = $dirCollection->getDirectoryCount();

        $this->assertEquals(10, $dirCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileWithValidFilename(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile('single-file-0.txt');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownFromMethodContainsFileWithNonStringParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileLikeWithValidFilenameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.txt', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileLikeWithValidFilenameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.TXT', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileLikeWithInvalidCaseFilename(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.TXT', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsFileLikeWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \InvalidArgumentException
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByContainsFileLikeWithNonStringFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByContainsFileLikeWithNonBoolSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.txt', 'super true');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsDirectoryWithValidDirName(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory('directory-0');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsDirectoryWithInvalidDirName(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryWithNonStringParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory(array('haha'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ory-0', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ORY-9', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithInvalidCaseDirName(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ORY-0', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonStringFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike(42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonBoolSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ory-0', 'no way, bro');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames();

        $this->assertEquals(11, count($list));
        $this->assertContains('index.html', $list);
        $this->assertContains('single-file-9.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(5);

        $this->assertEquals(7, count($list));
        $this->assertContains('single-file-3.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('single-file-2.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesInDirectoryWithDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(0, 5);

        $this->assertEquals(5, count($list));
        $this->assertContains('single-file-0.txt', $list);
        $this->assertNotContains('single-file-4.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesInDirectoryWithIncreasedOffsetAndDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(3, 5);

        $this->assertEquals(5, count($list));
        $this->assertContains('single-file-3.txt', $list);
        $this->assertContains('single-file-5.txt', $list);
        $this->assertNotContains('index.html', $list);
        $this->assertNotContains('single-file-6.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanGetEmptyArrayFromPaginateFilenamesWithLargerThanCountOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(9000);

        $this->assertTrue(is_array($list));
        $this->assertEquals(0, count($list));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesInDirectoryWithDefaultOffsetLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(0, 25, 'single-file');

        $this->assertEquals(10, count($list));
        $this->assertContains('single-file-2.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('index.html', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(5, 25, 'single-file');

        $this->assertEquals(6, count($list));
        $this->assertContains('single-file-5.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('index.html', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilenamesWithIncreasedOffsetAndDecreasedLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(5, 3, 'single-file');

        $this->assertEquals(3, count($list));
        $this->assertContains('single-file-4.txt', $list);
        $this->assertContains('single-file-6.txt', $list);
        $this->assertNotContains('single-file-3.txt', $list);
        $this->assertNotContains('single-file-7.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilenamesWithInvalidIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(-7);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilenamesWithNonIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames('forty seven');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilenamesWithNonIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(0, 'seventy 2');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilenamesWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFilenames(0, -42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles();

        $this->assertEquals(11, count($list));

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[10]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(5);

        $this->assertEquals(7, count($list));
        $this->assertInstanceOf(
            '\\DCarbone\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[6]);

        $this->assertEquals('single-file-3.txt', $list[0]->getFilename());
        $this->assertEquals('single-file-9.txt', $list[6]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(0, 5);

        $this->assertEquals(5, count($list));
        
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);
        
        $this->assertEquals('index.html', $list[0]->getFilename());
        $this->assertEquals('single-file-3.txt', $list[4]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedOffsetAndDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(3, 5);

        $this->assertEquals(5, count($list));

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);

        $this->assertEquals('single-file-1.txt', $list[0]->getFilename());
        $this->assertEquals('single-file-5.txt', $list[4]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanGetEmptyArrayFromPaginateFilesWithLargerThanCountOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(9000);

        $this->assertTrue(is_array($list));
        $this->assertEquals(0, count($list));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDefaultOffsetLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(0, 25, 'single-file');

        $this->assertEquals(10, count($list));

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[9]);

        $this->assertEquals('single-file-0.txt', $list[0]->getFilename());
        $this->assertEquals('single-file-9.txt', $list[9]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(5, 25, 'single-file');

        $this->assertEquals(6, count($list));

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[5]);

        $this->assertEquals('single-file-4.txt', $list[0]->getFilename());
        $this->assertEquals('single-file-9.txt', $list[5]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndDecreasedLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(5, 3, 'single-file');

        $this->assertEquals(3, count($list));

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[2]);

        $this->assertEquals('single-file-4.txt', $list[0]->getFilename());
        $this->assertEquals('single-file-6.txt', $list[2]->getFilename());
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilesWithInvalidIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(-7);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilesWithNonIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles('forty seven');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilesWithNonIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(0, 'seventy 2');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFilesWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFiles(0, -42);
    }
}