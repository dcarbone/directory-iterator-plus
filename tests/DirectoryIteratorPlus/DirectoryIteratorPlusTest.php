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
    public function testContainsFileWithValidFileName(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
    public function testContainsFileWithInvalidFileName(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
    public function testContainsFileLikeWithValidFileNameCaseSensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
    public function testContainsFileLikeWithValidFileNameCaseInsensitive(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
    public function testContainsFileLikeWithInvalidCaseFileName(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
    public function testContainsFileLikeWithInvalidFileName(\DCarbone\DirectoryIteratorPlus $dirCollection)
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
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDefaultValues(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList();

        $this->assertEquals(11, count($list));
        $this->assertContains('index.html', $list);
        $this->assertContains('single-file-9.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedValidOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(5);

        $this->assertEquals(7, count($list));
        $this->assertContains('single-file-3.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('single-file-2.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(0, 5);

        $this->assertEquals(5, count($list));
        $this->assertContains('single-file-0.txt', $list);
        $this->assertNotContains('single-file-4.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithIncreasedOffsetAndDecreasedLimit(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(3, 5);

        $this->assertEquals(5, count($list));
        $this->assertContains('single-file-3.txt', $list);
        $this->assertContains('single-file-5.txt', $list);
        $this->assertNotContains('index.html', $list);
        $this->assertNotContains('single-file-6.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanGetEmptyArrayFromPaginateFileNameListWithLargerThanCountOffset(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(9000);

        $this->assertTrue(is_array($list));
        $this->assertEquals(0, count($list));
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesInDirectoryWithDefaultOffsetLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(0, 25, 'single-file');

        $this->assertEquals(10, count($list));
        $this->assertContains('single-file-2.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('index.html', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(5, 25, 'single-file');

        $this->assertEquals(6, count($list));
        $this->assertContains('single-file-5.txt', $list);
        $this->assertContains('single-file-9.txt', $list);
        $this->assertNotContains('index.html', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testCanPaginateFilesWithIncreasedOffsetAndDecreasedLimitAndValidSearchParameter(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(5, 3, 'single-file');

        $this->assertEquals(3, count($list));
        $this->assertContains('single-file-4.txt', $list);
        $this->assertContains('single-file-6.txt', $list);
        $this->assertNotContains('single-file-3.txt', $list);
        $this->assertNotContains('single-file-7.txt', $list);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFileNamesWithInvalidIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(-7);
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFileNamesWithNonIntegerFirstArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList('forty seven');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFileNameListWithNonIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(0, 'seventy 2');
    }

    /**
     * @covers \DCarbone\DirectoryIteratorPlus::paginateFileNameList
     * @uses \DCarbone\DirectoryIteratorPlus
     * @depends testCanConstructDirectoryIteratorPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryIteratorPlus $dirCollection
     */
    public function testExceptionThrownByPaginateFileNameListWithInvalidIntegerSecondArgument(\DCarbone\DirectoryIteratorPlus $dirCollection)
    {
        $list = $dirCollection->paginateFileNameList(0, -42);
    }
}