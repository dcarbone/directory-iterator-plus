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
        $dirIterator = new \DCarbone\DirectoryIteratorPlus(__DIR__.'/../misc/couple-of-files');

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $dirIterator);

        return $dirIterator;
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenNonStringValuePassedToConstructor()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus(1000000);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenInvalidDirectoryValuePassedToConstructor()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus('hello there.');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfFilesInDirectory(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $fileCount = $dirIterator->getFileCount();

        $this->assertEquals(11, $fileCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfDirectoriesInDirectory(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $dirCount = $dirIterator->getDirectoryCount();

        $this->assertEquals(10, $dirCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileWithValidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile('single-file-0.txt');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownFromMethodContainsFileWithNonStringParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeWithValidFilenameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.txt', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeWithValidFilenameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.TXT', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeWithInvalidCaseFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.TXT', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \InvalidArgumentException
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsFileLikeWithNonStringFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsFileLikeWithNonBoolSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.txt', 'super true');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryWithValidDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectory('directory-0');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryWithInvalidDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectory('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsDirectoryWithNonStringParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectory(array('haha'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ory-0', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ORY-9', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeWithInvalidCaseDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ORY-0', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonStringFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike(42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonBoolSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ory-0', 'no way, bro');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames();

        $this->assertCount(11, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(5);

        $this->assertCount(6, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(0, 5);

        $this->assertCount(5, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithIncreasedOffsetAndDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(3, 5);

        $this->assertCount(5, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetEmptyArrayFromPaginateFilenamesWithLargerThanCountOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(9000);

        $this->assertTrue(is_array($list));
        $this->assertCount(0, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithDefaultOffsetLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(0, 25, 'single-file');

        $this->assertCount(10, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(5, 25, 'single-file');

        $this->assertCount(5, $list);

        $this->assertContains('single-file-5.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('index.html', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesWithIncreasedOffsetAndDecreasedLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(5, 3, 'single-file');

        $this->assertCount(3, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilenamesWithInvalidIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(-7);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilenamesWithNonIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames('forty seven');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilenamesWithNonIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(0, 'seventy 2');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilenamesWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(0, -42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles();

        $this->assertCount(11, $list);

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
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(5);

        $this->assertCount(6, $list);

        $this->assertInstanceOf(
            '\\DCarbone\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[5]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(0, 5);

        $this->assertCount(5, $list);
        
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedOffsetAndDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(3, 5);

        $this->assertCount(5, $list);

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetEmptyArrayFromPaginateFilesWithLargerThanCountOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(9000);

        $this->assertTrue(is_array($list));
        $this->assertCount(0, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithDefaultOffsetLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(0, 25, 'single-file');

        $this->assertCount(10, $list);

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[9]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(5, 25, 'single-file');

        $this->assertCount(5, $list);

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndDecreasedLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(5, 3, 'single-file');

        $this->assertCount(3, $list);

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[2]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilesWithInvalidIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(-7);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilesWithNonIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles('forty seven');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilesWithNonIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(0, 'seventy 2');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilesWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(0, -42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountSearch
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfFilesWithValidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountSearch('index');

        $this->assertEquals(1, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountSearch
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetZeroResponseFromFileCountWithInvalidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountSearch('i don\'t exist!');

        $this->assertEquals(0, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountSearch
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfAllFilesIfEmptyStringPassedToFileCountSearch(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $count = $dirIterator->getFileCount();
        $searchCount = $dirIterator->getFileCountSearch('');

        $this->assertEquals($count, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountSearch
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByGetFileCountSearchWhenNonStringTermUsed(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountSearch(array('nope'));
    }
}