<?php

require __DIR__.'/../misc/file-generator.php';

/**
 * Class DirectoryCollectionPlusTest
 */
class DirectoryCollectionPlusTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers \DCarbone\DirectoryCollectionPlus::__construct
     * @uses \DCarbone\DirectoryCollectionPlus
     * @return \DCarbone\DirectoryCollectionPlus
     */
    public function testCanConstructDirectoryCollectionPlusWithValidParameter()
    {
        $dirCollection = new \DCarbone\DirectoryCollectionPlus(__DIR__.'/../misc/couple-of-files');

        $this->assertInstanceOf(
            '\\DCarbone\\DirectoryCollectionPlus',
            $dirCollection);

        return $dirCollection;
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::__construct
     * @uses \DCarbone\DirectoryCollectionPlus
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionThrownWhenNonStringValuePassedToConstructor()
    {
        $dirCollection = new \DCarbone\DirectoryCollectionPlus(1000000);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::__construct
     * @uses \DCarbone\DirectoryCollectionPlus
     * @expectedException \RuntimeException
     */
    public function testExceptionThrownWhenInvalidDirectoryValuePassedToConstructor()
    {
        $dirCollection = new \DCarbone\DirectoryCollectionPlus('hello there.');
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::getFileCount
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testCanGetCountOfFilesInDirectory(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $fileCount = $dirCollection->getFileCount();

        $this->assertEquals(11, $fileCount);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::getDirectoryCount
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testCanGetCountOfDirectoriesInDirectory(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $dirCount = $dirCollection->getDirectoryCount();

        $this->assertEquals(10, $dirCount);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFile
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileWithValidFileName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile('single-file-0.txt');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFile
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileWithInvalidFileName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFile
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownFromMethodContainsFileWithNonStringParameter(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFile(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileLikeWithValidFileNameCaseSensitive(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.txt', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileLikeWithValidFileNameCaseInsensitive(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.TXT', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileLikeWithInvalidCaseFileName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.TXT', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsFileLikeWithInvalidFileName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @expectedException \InvalidArgumentException
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownByContainsFileLikeWithNonStringFirstArgument(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike(array('nope'));
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsFileLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownByContainsFileLikeWithNonBoolSecondArgument(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsFileLike('0.txt', 'super true');
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectory
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsDirectoryWithValidDirName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory('directory-0');

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectory
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsDirectoryWithInvalidDirName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory('sandwiches');

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectory
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryWithNonStringParameter(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectory(array('haha'));
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseSensitive(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ory-0', false);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithValidDirNameCaseInsensitive(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ORY-9', true);

        $this->assertTrue($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testContainsDirectoryLikeWithInvalidCaseDirName(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ORY-0', false);

        $this->assertFalse($contains);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonStringFirstArgument(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike(42);
    }

    /**
     * @covers \DCarbone\DirectoryCollectionPlus::containsDirectoryLike
     * @uses \DCarbone\DirectoryCollectionPlus
     * @depends testCanConstructDirectoryCollectionPlusWithValidParameter
     * @expectedException \InvalidArgumentException
     * @param \DCarbone\DirectoryCollectionPlus $dirCollection
     */
    public function testExceptionThrownByContainsDirectoryLikeWithNonBoolSecondArgument(\DCarbone\DirectoryCollectionPlus $dirCollection)
    {
        $contains = $dirCollection->containsDirectoryLike('ory-0', 'no way, bro');
    }
}