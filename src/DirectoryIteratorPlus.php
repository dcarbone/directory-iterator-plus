<?php namespace DCarbone;

/**
 * Class DirectoryIteratorPlus
 * @package DCarbone
 */
class DirectoryIteratorPlus extends \DirectoryIterator
{
    /** @var int */
    protected $fileCount = 0;

    /** @var int */
    protected $directoryCount = 0;

    /**
     * Constructor
     *
     * @param string $path
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function __construct($path)
    {
        if (!is_string($path))
            throw new \InvalidArgumentException('DirectoryIterator::__construct - Argument 1 expected to be string, '.gettype($path).' seen.');

        $realpath = realpath($path);

        if ($realpath === false)
            throw new \RuntimeException('DirectoryIterator::__construct - Could not find specified file at path "'.$path.'".');

        if (!is_dir($realpath))
            throw new \RuntimeException('DirectoryIterator::__construct - The directory name is invalid.');

        parent::__construct($realpath);

        $data = array();
        if (DIRECTORY_SEPARATOR === '/')
            exec('(find "'.$realpath.'" -maxdepth 1 -type f | wc -l) 2>&1', $data);
        else
            exec('(DIR /A-D /B "'.$realpath.'" | FIND /C /V "") 2>&1', $data);

        if (count($data) === 1 && ctype_digit($data[0]))
            $this->fileCount = (int)reset($data);

        $this->directoryCount = count(glob($realpath.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR));
    }

    /**
     * @return int
     */
    public function getFileCount()
    {
        return $this->fileCount;
    }

    /**
     * @param string $string
     * @throws \InvalidArgumentException
     * @return int
     */
    public function getFileCountLike($string)
    {
        if (!is_string($string))
            throw new \InvalidArgumentException('Argument 1 expected to be string, '.gettype($string).' seen.');

        $string = trim($string);
        if ($string === '')
            return $this->getFileCount();

        $count = 0;

        parent::rewind();

        while (parent::valid())
        {
            $current = parent::current();
            if ($current->isFile() && stripos($current->getFilename(), $string) !== false)
                $count++;

            parent::next();
        }

        parent::rewind();

        return $count;
    }

    /**
     * @return int
     */
    public function getDirectoryCount()
    {
        return $this->directoryCount;
    }

    /**
     * @param string $string
     * @throws \InvalidArgumentException
     * @return int
     */
    public function getDirectoryCountLike($string)
    {
        if (!is_string($string))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::getDirectoryCountLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        $string = trim($string);
        if ($string === '')
            return $this->getDirectoryCount();

        $count = 0;

        parent::rewind();

        while (parent::valid())
        {
            $current = parent::current();
            if ($current->isDir() && stripos($current->getFilename(), $string) !== false)
                $count++;

            parent::next();
        }
        parent::rewind();

        return $count;
    }

    /**
     * @param string $file
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function containsFile($file)
    {
        if (!is_string($file))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFile - Argument 1 expected to be string, '.gettype($file).' seen.');

        $found = false;

        parent::rewind();

        while (parent::valid())
        {
            $current = parent::current();
            if ($current->isFile() && $current->getFilename() === $file)
            {
                $found = true;
                break;
            }

            parent::next();
        }

        parent::rewind();

        return $found;
    }

    /**
     * @param string $string
     * @param bool $caseInsensitive
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function containsFileLike($string, $caseInsensitive = false)
    {
        if (!is_string($string))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFileLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        if (!is_bool($caseInsensitive))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFileLike - Argument 2 expected to be bool, '.gettype($caseInsensitive).' seen.');

        $found = false;

        parent::rewind();

        if ($caseInsensitive)
        {
            while (parent::valid())
            {
                $current = parent::current();
                if ($current->isFile() && stripos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                parent::next();
            }
        }
        else
        {
            while (parent::valid())
            {
                $current = parent::current();
                if ($current->isFile() && strpos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                parent::next();
            }
        }

        parent::rewind();
        
        return $found;
    }

    /**
     * @param string $directory
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function containsDirectory($directory)
    {
        if (!is_string($directory))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsDirectory - Argument 1 expected to be string, '.gettype($directory).' seen.');

        $found = false;
        parent::rewind();
        while (parent::valid())
        {
            $current = parent::current();
            if ($current->isDir() && $current->getFilename() === $directory)
            {
                $found = true;
                break;
            }
            parent::next();
        }
        parent::rewind();
        return $found;
    }

    /**
     * @param string $string
     * @param bool $caseInsensitive
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function containsDirectoryLike($string, $caseInsensitive = false)
    {
        if (!is_string($string))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsDirectoryLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        if (!is_bool($caseInsensitive))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsDirectoryLike - Argument 2 expected to be bool, '.gettype($caseInsensitive).' seen.');

        $found = false;
        parent::rewind();
        if ($caseInsensitive)
        {
            while (parent::valid())
            {
                $current = parent::current();
                if ($current->isDir() && stripos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                parent::next();
            }
        }
        else
        {
            while (parent::valid())
            {
                $current = parent::current();
                if ($current->isDir() && strpos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                parent::next();
            }
        }

        parent::rewind();
        return $found;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param mixed $search
     * @return array
     * @throws \InvalidArgumentException
     */
    public function paginateFileNames($offset = 0, $limit = 25, $search = null)
    {
        if (!is_int($offset))
            throw new \InvalidArgumentException('Argument 1 expected to be integer, '.gettype($offset).' seen.');
        if ($offset < 0)
            throw new \InvalidArgumentException('Argument 1 expected to be >= 0, "'.$offset.'" seen.');

        if (!is_int($limit))
            throw new \InvalidArgumentException('Argument 2 expected to be integer, '.gettype($limit).' seen.');
        if ($limit < -1)
            throw new \InvalidArgumentException('Argument 2 must be >= -1, "'.$limit.'" seen.');

        if ($search !== null && !is_scalar($search))
            throw new \InvalidArgumentException('Argument 3 expected to be scalar value or null, '.gettype($search).' seen.');

        $filei = 0;

        if ($offset === 0)
            $offset = -1;

        if ($limit === -1)
            $limit = $this->fileCount;

        parent::rewind();

        $listTotal = 0;
        $list = array();
        if (null === $search)
        {
            while(parent::valid() && $listTotal < $limit)
            {
                $current = parent::current();
                if ($current->isFile())
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = $current->getFilename();
                        $listTotal++;
                    }
                }
                parent::next();
            }
        }
        else
        {
            $search = (string)$search;

            while(parent::valid() && $listTotal < $limit)
            {
                $current = parent::current();
                if ($current->isFile() && stripos($current->getFilename(), $search) !== false)
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = $current->getFilename();
                        $listTotal++;
                    }
                }
                parent::next();
            }
        }

        parent::rewind();

        return $list;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param mixed $search
     * @throws \InvalidArgumentException
     * @return array
     */
    public function paginateFiles($offset = 0, $limit = 25, $search = null)
    {
        if (!is_int($offset))
            throw new \InvalidArgumentException('Argument 1 expected to be integer, '.gettype($offset).' seen.');
        if ($offset < 0)
            throw new \InvalidArgumentException('Argument 1 expected to be >= 0, "'.$offset.'" seen.');

        if (!is_int($limit))
            throw new \InvalidArgumentException('Argument 2 expected to be integer, '.gettype($limit).' seen.');
        if ($limit < -1)
            throw new \InvalidArgumentException('Argument 2 must be >= -1, "'.$limit.'" seen.');

        if ($search !== null && !is_scalar($search))
            throw new \InvalidArgumentException('Argument 3 expected to be scalar value or null, '.gettype($search).' seen.');

        if ($limit === -1)
            $limit = $this->fileCount;

        if (null === $search)
            return $this->paginateFilesNoSearch($offset, $limit);

        return $this->paginateFilesSearch($offset, $limit, $search);
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return array
     */
    protected function paginateFilesNoSearch($offset, $limit)
    {
        $filei = 0;
        $listTotal = 0;
        $list = array();

        parent::rewind();

        if ($offset === 0)
            $offset = -1;
        else
            $filei = 1;

        while(parent::valid() && $listTotal < $limit)
        {
            $current = parent::current();
            if ($current->isFile() && $filei++ > $offset)
            {
                $list[] = clone $current;
                $listTotal++;
            }

            parent::next();
        }

        parent::rewind();

        return $list;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @param int|string|float $search
     * @return array
     */
    protected function paginateFilesSearch($offset, $limit, $search)
    {
        $filei = 0;
        $listTotal = 0;
        $list = array();

        if ($offset === 0)
            $offset = -1;
        else
            $filei = 1;

        $search = (string)$search;

        while(parent::valid() && $listTotal < $limit)
        {
            $current = parent::current();
            if ($current->isFile() && stripos($current->getFilename(), $search) !== false && $filei++ > $offset)
            {
                $list[] = clone $current;
                $listTotal++;
            }

            parent::next();
        }

        parent::rewind();

        return $list;
    }
}