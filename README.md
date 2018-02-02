directory-iterator-plus
=========================

A simple extension of the PHP `\DirectoryIterator` class

**Build Status**: [![Build Status](https://travis-ci.org/dcarbone/directory-iterator-plus.svg?branch=master)](https://travis-ci.org/dcarbone/directory-iterator-plus)

## Installation in your Composer App
```json
{
    "require": {
      "dcarbone/directory-iterator-plus" : "@stable"
    }
}
```

## Concept

I had a need to be able to, relatively quickly, create a web interface which allowed the navigation of a directory
of thousands of files.

I did not want to `glob()` my way through them, and I wanted a simple way to paginate and search through them.

This class met that need.

## Usage

This class is an extension of the base PHP class <a href="http://php.net/manual/en/class.directoryiterator.php">DirectoryIterator</a>
and as such has all the same methods available, and to a great extent it's functionality is unchanged.

### New Methods

I have provided several custom methods, most of which revolve around either getting a subset of files
or determining the existence of a file within a directory

#### File and Directory Counting

You may retrieve these values after instantiation by calling `getFileCount()` or `getDirectoryCount()` methods.

I used to do some `exec` nonsense, but now I just be lazy and use `glob`.

#### Searching

There are several options available to you:

- Determine existence by exact file / directory name
    - `containsFile($file)`
    - `containsDirectory($directory)`
- Determine existence by string search term
    - `containsFileLike($string[, $caseInsensitive = false])`
    - `containsDirectoryLike($string[, $caseInsensitive = false])`
- Get Count of files / directories by search term
    - `getFileCountLike($string)`
    - `getDirectoryCountLike($string)`

Each of the "Like" methods utilize PHP's <a href="http://php.net/manual/en/function.stripos.php">stripos</a> function
to determine if the passed value is contained wholly somewhere inside of the filename of a given file / directory.

#### File Pagination

There are currently two Pagination methods available:

- `paginateFileNames([$offset 0[, $limit = 25[, $search = null]]])`
- `paginateFiles([$offset 0[, $limit = 25[, $search = null]]])`

These methods are designed to operate similar to any other pagination code used against a database.

The `$search` term again uses the PHP <a href="http://php.net/manual/en/function.stripos.php">stripos</a> method to
determine matches.

The primary difference between these two methods is the contents of the returned array.

**`paginateFileNames()`**

This method will return an array of file names that match the input criteria

**`paginateFiles()`**

This method will return an array of `\DCarbone\DirectoryIteratorPlus` objects, each representing an individual file.

## Comments and Suggestions

If you find this library useful and have an idea of how it can be made better, please let me know!