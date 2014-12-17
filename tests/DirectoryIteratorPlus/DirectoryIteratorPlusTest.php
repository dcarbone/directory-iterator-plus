<?php

if (!function_exists('generateRandomString'))
{
    /**
     * @param int $length
     * @return string
     */
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}

if (!is_dir(__DIR__.'/../misc/couple-of-files'))
    mkdir(__DIR__.'/../misc/couple-of-files');
if (!is_dir(__DIR__.'/../misc/empty-directory'))
    mkdir(__DIR__.'/../misc/empty-directory');

/*
 * The directory tests/misc/couple-of-files should have come with this package.
 * The below logic populates that directory with 10 files and 10 directories, giving a total of 11 files
 * and 10 directories.
 *
 * It also creates a symlink to the couple-of-files directory for symlink unit testing.
 */
if (is_dir(__DIR__.'/../misc/couple-of-files') && count(glob(__DIR__.'/../misc/couple-of-files/*.txt', GLOB_NOSORT)) === 0)
{
    for ($i = 0; $i < 10; $i++)
    {
        file_put_contents(__DIR__.'/../misc/couple-of-files/single-file-'.$i.'.txt', generateRandomString(100));

        mkdir(__DIR__.'/../misc/couple-of-files/directory-'.$i);
    }
}


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
    public function testCanConstructDirectoryIteratorPlusWithValidDirectoryPath()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus(__DIR__.'/../misc/couple-of-files');

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $dirIterator);

        return $dirIterator;
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::count
     * @covers \DCarbone\DirectoryIteratorPlus::getItemCount
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @uses \Countable
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCountableInterface(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $this->assertInstanceOf('\\Countable', $dirIterator);
        $this->assertCount(20, $dirIterator);
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
    public function testExceptionThrownWhenNonExistentPathValuePassedToConstructor()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus('hello there.');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenValidNonDirectoryPathPassedToConstructor()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus(__FILE__);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfFilesInDirectory(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $fileCount = $dirIterator->getFileCount();

        $this->assertEquals(10, $fileCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileReturnsTrueWithValidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile('single-file-0.txt');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileReturnsFalseWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFile
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsFileWhenNonStringParameterPassed(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFile(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeReturnsTrueWithValidFilenameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.txt', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeReturnsTrueWithValidFilenameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.TXT', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeReturnsFalseWithInvalidCaseFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('0.TXT', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsFileLikeReturnsFalseWithInvalidFilename(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @expectedException \InvalidArgumentException
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByContainsFileLikeWithNonStringFirstArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsFileLike(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsFileLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryReturnsTrueWithValidDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectory('directory-0');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryReturnsFalseWithInvalidDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectory('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectory
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeReturnsTrueWithValidDirNameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ory-0', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeReturnsTrueWithValidDirNameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ORY-9', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testContainsDirectoryLikeReturnsFalseWithInvalidCaseDirName(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $contains = $dirIterator->containsDirectoryLike('ORY-0', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames();

        $this->assertCount(10, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(5);

        $this->assertCount(5, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilenamesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFilenames(5, 25, 'single-file');

        $this->assertCount(5, $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFilenames
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles();

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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(5);

        $this->assertCount(5, $list);

        $this->assertInstanceOf(
            '\\DCarbone\DirectoryIteratorPlus',
            $list[0]);
        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryIteratorPlus',
            $list[4]);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFiles
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
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
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByPaginateFilesWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $list = $dirIterator->paginateFiles(0, -42);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfFilesWithValidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountLike('single-file-1');

        $this->assertEquals(1, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetZeroResponseFromFileCountWithInvalidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountLike('i don\'t exist!');

        $this->assertEquals(0, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfAllFilesIfEmptyStringPassedToFileCountSearch(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $count = $dirIterator->getFileCount();
        $searchCount = $dirIterator->getFileCountLike('');

        $this->assertEquals($count, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByGetFileCountSearchWhenNonStringTermUsed(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getFileCountLike(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfDirsWithValidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getDirectoryCountLike('ory-1');

        $this->assertEquals(1, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCountLike
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetZeroResponseFromDirCountWithInvalidSearchTerm(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getDirectoryCountLike('hellow there!');

        $this->assertEquals(0, $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCountLike
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testCanGetCountOfAllDirsIfEmptyStringPassedToDirSearch(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getDirectoryCount('');

        $this->assertEquals($dirIterator->getDirectoryCount(), $searchCount);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCountLike
     * @covers \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidDirectoryPath
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testExceptionThrownByDirCountSearchIfNonStringValuePassed(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $searchCount = $dirIterator->getDirectoryCountLike(array('hi'));
    }



    /*
     *
     *
     *
     *
     * Empty Directory Tests
     *
     *
     *
     *
     */

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::__construct
     * @uses \DCarbone\DirectoryIteratorPlus
     * @returns \DCarbone\DirectoryIteratorPlus
     */
    public function testCanConstructObjectWithEmptyDirectory()
    {
        $dirIterator = new \DCarbone\DirectoryIteratorPlus(__DIR__.'/../misc/empty-directory');

        $this->assertInstanceOf('\\DCarbone\\DirectoryIteratorPlus', $dirIterator);

        return $dirIterator;
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getFileCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructObjectWithEmptyDirectory
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testFileCountOfEmptyDirectory(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $count = $dirIterator->getFileCount();

        $this->assertEquals(0, $count);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructObjectWithEmptyDirectory
     * @param \DCarbone\DirectoryIteratorPlus $dirIterator
     */
    public function testSubDirectoryCountOfEmptyDirectory(\DCarbone\DirectoryIteratorPlus $dirIterator)
    {
        $count = $dirIterator->getDirectoryCount();

        $this->assertEquals(0, $count);
    }
}