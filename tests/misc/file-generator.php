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

/*
 * The directory tests/misc/couple-of-files should have come with this package.
 * The below logic populates that directory with 10 files and 10 directories, giving a total of 11 files
 * and 10 directories.
 *
 * It also creates a symlink to the couple-of-files directory for symlink unit testing.
 */
if (is_dir(__DIR__.'/couple-of-files') && count(glob(__DIR__.'/couple-of-files/*.txt', GLOB_NOSORT)) === 0)
{
    for ($i = 0; $i < 10; $i++)
    {
        file_put_contents(__DIR__.'/couple-of-files/single-file-'.$i.'.txt', generateRandomString(100));

        mkdir(__DIR__.'/couple-of-files/directory-'.$i);
    }


    symlink(__DIR__.'/couple-of-files', __DIR__.'/couple-of-files-link');
}