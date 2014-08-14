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

        if (!is_dir($path))
            throw new \RuntimeException('DirectoryIterator::__construct - Argument 1 expected to be valid file path');

        parent::__construct($path);

        $realpath = realpath($path);

        if ($realpath !== false)
        {
            if (DIRECTORY_SEPARATOR === '/')
                $this->fileCount = (int)trim(shell_exec('ls -1 "'.$realpath.'" | wc -l'));
            else
                $this->fileCount = (int)trim(shell_exec('DIR /A-D /B "'.$realpath.'" | FIND /C /V ""'));

            $this->directoryCount = count(glob($realpath.DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR));
        }
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
    public function getFileCountSearch($string)
    {
        if (!is_string($string))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::getFileCountSearch - Argument 1 expected to be string, '.gettype($string).' seen.');

        $string = trim($string);
        if ($string === '')
            return $this->getFileCount();

        $count = 0;
        while ($this->valid())
        {
            $current = $this->current();
            if ($current->isFile() && stripos($current->getFilename(), $string) !== false)
                $count++;

            $this->next();
        }
        $this->rewind();

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
     * @param string $file
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function containsFile($file)
    {
        if (!is_string($file))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFile - Argument 1 expected to be string, '.gettype($file).' seen.');

        $found = false;
        $this->rewind();
        while ($this->valid())
        {
            $current = $this->current();
            if ($current->isFile() && $current->getFilename() === $file)
            {
                $found = true;
                break;
            }
            $this->next();
        }
        $this->rewind();
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
        $this->rewind();
        if ($caseInsensitive)
        {
            while ($this->valid())
            {
                $current = $this->current();
                if ($current->isFile() && stripos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                $this->next();
            }
        }
        else
        {
            while ($this->valid())
            {
                $current = $this->current();
                if ($current->isFile() && strpos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                $this->next();
            }
        }

        $this->rewind();
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
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFile - Argument 1 expected to be string, '.gettype($directory).' seen.');

        $found = false;
        $this->rewind();
        while ($this->valid())
        {
            $current = $this->current();
            if ($current->isDir() && $current->getFilename() === $directory)
            {
                $found = true;
                break;
            }
            $this->next();
        }
        $this->rewind();
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
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFileLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        if (!is_bool($caseInsensitive))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::containsFileLike - Argument 2 expected to be bool, '.gettype($caseInsensitive).' seen.');

        $found = false;
        $this->rewind();
        if ($caseInsensitive)
        {
            while ($this->valid())
            {
                $current = $this->current();
                if ($current->isDir() && stripos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                $this->next();
            }
        }
        else
        {
            while ($this->valid())
            {
                $current = $this->current();
                if ($current->isDir() && strpos($current->getFilename(), $string) !== false)
                {
                    $found = true;
                    break;
                }
                $this->next();
            }
        }

        $this->rewind();
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
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFileNames - Argument 1 expected to be integer, '.gettype($offset).' seen.');
        if ($offset < 0)
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFileNames - Argument 1 expected to be >= 0, "'.$offset.'" seen.');

        if (!is_int($limit))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFileNames - Argument 2 expected to be integer, '.gettype($limit).' seen.');
        if ($limit < -1)
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFileNames - Argument 2 must be >= -1, "'.$limit.'" seen.');

        if ($search !== null && !is_scalar($search))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFileNames - Argument 3 expected to be scalar value or null, '.gettype($search).' seen.');

        $filei = 0;

        if ($offset === 0)
            $offset = -1;

        if ($limit === -1)
            $limit = $this->fileCount;

        $listTotal = 0;
        $list = array();
        if ($search === null)
        {
            $this->rewind();
            while($this->valid())
            {
                if ($listTotal === $limit)
                    break;

                $current = $this->current();
                if ($current->isFile())
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = $current->getFilename();
                        $listTotal++;
                    }
                }
                $this->next();
            }
        }
        else
        {
            $search = (string)$search;

            $this->rewind();
            while($this->valid())
            {
                if ($listTotal === $limit)
                    break;

                $current = $this->current();
                if ($current->isFile() && stripos($current->getFilename(), $search) !== false)
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = $current->getFilename();
                        $listTotal++;
                    }
                }
                $this->next();
            }
        }

        $this->rewind();

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
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFiles - Argument 1 expected to be integer, '.gettype($offset).' seen.');
        if ($offset < 0)
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFiles - Argument 1 expected to be >= 0, "'.$offset.'" seen.');

        if (!is_int($limit))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFiles - Argument 2 expected to be integer, '.gettype($limit).' seen.');
        if ($limit < -1)
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFiles - Argument 2 must be >= -1, "'.$limit.'" seen.');

        if ($search !== null && !is_scalar($search))
            throw new \InvalidArgumentException('DirectoryIteratorPlus::paginateFiles - Argument 3 expected to be scalar value or null, '.gettype($search).' seen.');

        $filei = 0;

        if ($limit === -1)
            $limit = $this->fileCount;

        if ($offset === 0)
            $offset = -1;

        $listTotal = 0;
        $list = array();
        if ($search === null)
        {
            $this->rewind();
            while($this->valid())
            {
                if ($listTotal === $limit)
                    break;

                $current = $this->current();
                if ($current->isFile())
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = clone $current;
                        $listTotal++;
                    }
                }
                $this->next();
            }
        }
        else
        {
            $search = (string)$search;

            $this->rewind();
            while($this->valid())
            {
                if ($listTotal === $limit)
                    break;

                $current = $this->current();
                if ($current->isFile() && stripos($current->getFilename(), $search) !== false)
                {
                    if ($filei++ >= $offset)
                    {
                        $list[] = clone $current;
                        $listTotal++;
                    }
                }
                $this->next();
            }
        }

        $this->rewind();

        return $list;
    }
}