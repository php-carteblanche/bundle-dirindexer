<?php
/**
 * CarteBlanche - PHP framework package - Simple Viewer bundle
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License GPL-3.0 <http://www.opensource.org/licenses/gpl-3.0.html>
 * Sources <https://github.com/atelierspierrot/carte-blanche>
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