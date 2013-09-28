<?php
/**
 * PHP/Apache/Markdown DirIndexer
 * @package     DirIndexer
 * @license     GPL-v3
 * @link        https://github.com/atelierspierrot/docbook
 */

namespace DirIndexer\WebFilesystem;

use DirIndexer\Helper;

use WebFilesystem\FilesystemIterator,
    WebFilesystem\WebRecursiveDirectoryIterator;

/**
 */
class DirIndexerRecursiveDirectoryIterator extends WebRecursiveDirectoryIterator
{

    public function __construct(
        $path, $flags = 16432,
        $file_validation_callback = "DirIndexer\WebFilesystem\DirIndexerRecursiveDirectoryIterator::fileValidation",
        $directory_validation_callback = "DirIndexer\WebFilesystem\DirIndexerRecursiveDirectoryIterator::dirValidation"
    ) {
        parent::__construct($path, $flags, $file_validation_callback, $directory_validation_callback);
    }

    public static function fileValidation($file_path)
    {
        return Helper::isFileValid($file_path);
        $name = basename($file_path);
        return (
            $name!==FrontController::DOCBOOK_INTERFACE && 
            $name!==FrontController::README_FILE
        );
    }
    
    public static function dirValidation($file_path)
    {
        return Helper::isDirValid($file_path);
        $name = basename($file_path);
        return (
            $name!==FrontController::DOCBOOK_ASSETS
        );
    }

}

// Endfile
