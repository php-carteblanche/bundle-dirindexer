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
use \Library\Helper\Directory as DirectoryHelper;

class DirIndexerBundle
{

    protected static $bundle_config_file = 'dirindexer_config.ini';

    public function __construct()
    {
        $cfgfile = \CarteBlanche\App\Locator::locateConfig(self::$bundle_config_file);
        if (!file_exists($cfgfile)) {
            throw new ErrorException( 
                sprintf('Dirindex bundle configuration file not found in "%s" [%s]!', $this->getPath('config_dir'), $cfgfile)
            );
        }
        $cfg = CarteBlanche::getContainer()->get('config')
            ->load($cfgfile, true, 'dirindexer')
            ->get('dirindexer');
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