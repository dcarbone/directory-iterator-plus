<?php namespace DCarbone;

/**
 * Class DirectoryCollectionPlus
 * @package DCarbone
 */
class DirectoryCollectionPlus extends \DirectoryIterator
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
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFile - Argument 1 expected to be string, '.gettype($file).' seen.');

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
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFileLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        if (!is_bool($caseInsensitive))
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFileLike - Argument 2 expected to be bool, '.gettype($caseInsensitive).' seen.');

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
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFile - Argument 1 expected to be string, '.gettype($directory).' seen.');

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
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFileLike - Argument 1 expected to be string, '.gettype($string).' seen.');

        if (!is_bool($caseInsensitive))
            throw new \InvalidArgumentException('DirectoryCollectionPlus::containsFileLike - Argument 2 expected to be bool, '.gettype($caseInsensitive).' seen.');

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
}