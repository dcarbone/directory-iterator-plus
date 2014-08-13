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

if (is_dir(__DIR__.'/couple-of-files') && count(glob(__DIR__.'/couple-of-files/*.txt', GLOB_NOSORT)) === 0)
{
    for ($i = 0; $i < 10; $i++)
    {
        file_put_contents(__DIR__.'/couple-of-files/single-file-'.$i.'.txt', generateRandomString(100));

        mkdir(__DIR__.'/couple-of-files/directory-'.$i);
    }
}