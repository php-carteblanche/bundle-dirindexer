<?php
/**
 * CarteBlanche - PHP framework package - Simple Viewer bundle
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License Apache-2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 * Sources <http://github.com/php-carteblanche/carteblanche>
 */

namespace DirIndexer;

class DirIndexerBundle
{

    public function __construct()
    {
        define('_DIRINDEXER', 'indexer/');
        define('_DIRINDEXER_INDEX', 'INDEX.md');
        define('_DIRINDEXER_README', 'README.md');
        define('_DIRINDEXER_WIPDIR', 'wip');
    }

}

// Endfile