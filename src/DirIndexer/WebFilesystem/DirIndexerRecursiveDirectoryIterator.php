<?php
/**
 * This file is part of the CarteBlanche PHP framework.
 *
 * (c) Pierre Cassat <me@e-piwi.fr> and contributors
 *
 * License Apache-2.0 <http://github.com/php-carteblanche/carteblanche/blob/master/LICENSE>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DirIndexer\WebFilesystem;

use \DirIndexer\Helper;
use \WebFilesystem\FilesystemIterator;
use \WebFilesystem\WebRecursiveDirectoryIterator;

/**
 */
class DirIndexerRecursiveDirectoryIterator
    extends WebRecursiveDirectoryIterator
{

    public function __construct(
        $path, $flags = 16432,
        $file_validation_callback = "DirIndexer\\WebFilesystem\\DirIndexerRecursiveDirectoryIterator::fileValidation",
        $directory_validation_callback = "DirIndexer\\WebFilesystem\\DirIndexerRecursiveDirectoryIterator::dirValidation"
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
