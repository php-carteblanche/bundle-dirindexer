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

namespace DirIndexer;

use \CarteBlanche\CarteBlanche;
use \CarteBlanche\Abstracts\AbstractBundle;
use \Library\Helper\Directory as DirectoryHelper;

class DirIndexerBundle
    extends AbstractBundle
{

    public function init(array $options = array())
    {
        parent::init($options);
        $cfg = $this->getOptions();

        $dirindexer_web_dir = isset($cfg['root_dir']) ? $cfg['root_dir'] : null;
        if (!empty($dirindexer_web_dir)) {
            $indexer_path = DirectoryHelper::slashDirname(CarteBlanche::getPath('web_path')) . $dirindexer_web_dir;
            @DirectoryHelper::ensureExists($indexer_path);
            if (!file_exists($indexer_path) || !is_dir($indexer_path)) {
                CarteBlanche::getKernel()->addBootError(
                    sprintf("Can't create web directory '%s' for directory indexer bundle!", $dirindexer_web_dir)
                );
            }
        }

        $test_cfg = CarteBlanche::getContainer()->get('config')->get('dirindexer.root_dir');
    }

}

// Endfile