<?php
/**
 * CarteBlanche - PHP framework package - Simple Viewer bundle
 * Copyleft (c) 2013 Pierre Cassat and contributors
 * <www.ateliers-pierrot.fr> - <contact@ateliers-pierrot.fr>
 * License Apache-2.0 <http://www.apache.org/licenses/LICENSE-2.0.html>
 * Sources <http://github.com/php-carteblanche/carteblanche>
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
            DirectoryHelper::ensureExists(
                DirectoryHelper::slashDirname(CarteBlanche::getPath('web_path')) . $dirindexer_web_dir
            );
        }

        $test_cfg = CarteBlanche::getContainer()->get('config')->get('dirindexer.root_dir');
    }

}

// Endfile