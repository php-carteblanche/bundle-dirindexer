<?php
/**
 * PHP/Apache/Markdown DirIndexer
 * @package     DirIndexer
 * @license     GPL-v3
 * @link        https://github.com/atelierspierrot/docbook
 */

namespace DirIndexer\Controller;

use \CarteBlanche\CarteBlanche;
use \CarteBlanche\App\Container;
use \CarteBlanche\Abstracts\AbstractController;
use \CarteBlanche\Exception\NotFoundException;

use DirIndexer\WebFilesystem\DirIndexerFile,
    DirIndexer\WebFilesystem\DirIndexerRecursiveDirectoryIterator,
    DirIndexer\Helper;
/*
use DirIndexer\FrontController,
    DirIndexer\Helper,
    DirIndexer\Locator,
    DirIndexer\Abstracts\AbstractController;
*/
use Library\Helper\Directory as DirectoryHelper;

use Markdown\Parser,
    Markdown\ExtraParser;

/**
 */
class DirIndexer extends AbstractController
{

    protected $path;

	/**
	 * The directory where to search the views files
	 */
	static $views_dir = 'DirIndexer/views/';

	/**
	 */
	public function indexAction($path = '', $offset = 0)
	{
	    $path = urldecode($path);
		$_mod = $this->getContainer()->get('request')->getUrlArg('model');
        $_path = DirectoryHelper::slashDirname(Helper::getBaseDirHttp()).$path;
        if (@is_dir($_path))
            return self::directoryAction($_path, $offset);
        else
            return self::fileAction($_path);
	}

	public function emptyAction($altdb = null)
	{
		$this->getContainer()->get('router')->redirect();
	}

    public function fileAction($path)
    {
        $this->setPath($path);
        $dbfile = new DirIndexerFile($this->getpath());
        $file_content = file_get_contents($dbfile->getRealpath());
        $_txt = new \Tool\Text(array(
            'original_str'=>$file_content,
            'markdown'=>$dbfile->getExtension()==='md'
        ));
        $tpl_params = array(
            'page' => $dbfile->getDirIndexerStack(),
            'breadcrumbs' => Helper::getBreadcrumbs($this->getPath()),
            'content'=>$_txt,
        );

        $tpl_params['title'] = Helper::buildPageTitle($this->getPath());
        if (empty($tpl_params['title'])) {
            if (!empty($tpl_params['breadcrumbs'])) {
                $tpl_params['title'] = Helper::buildPageTitle(end($tpl_params['breadcrumbs']));
            } else {
                $tpl_params['title'] = _T('Home');
            }
        }

		return array(self::$views_dir.'md_template.html', $tpl_params);
/*
        $md_parser = $this->docbook->getMarkdownParser();
        $md_content = $md_parser->transformSource($this->getPath());
        $content = $this->docbook->display(
            $md_content->getBody(),
            'content',
            array(
                'page'=>$dbfile->getDirIndexerStack(),
                'page_notes'=>$md_content->getNotesToString()
            )
        );
        return array('default', $content, $tpl_params);
*/
    }

    public function directoryAction($path)
    {
        $this->setPath($path);
        $dbfile = new DirIndexerFile($this->getpath());
        $readme_content = $dir_content = '';

        $index = $dbfile->findIndex();
        if (file_exists($index)) {
            return $this->fileAction($index);
        }

        $tpl_params = array(
            'page' => $dbfile->getDirIndexerStack(),
            'breadcrumbs' => Helper::getBreadcrumbs($this->getPath()),
            'content'=>$dbfile->getDirIndexerScanStack()
        );

        $readme = $dbfile->findReadme();
        if (file_exists($readme)) {
            $readme_dbfile = new DirIndexerFile($readme);
            $readme_content = file_get_contents($readme_dbfile->getRealpath());
            $_txt = new \Tool\Text(array(
                'original_str'=>$readme_content,
                'markdown'=>$readme_dbfile->getExtension()==='md'
            ));
            $tpl_params['readme'] = $_txt;
/*
//            $md_parser = $this->docbook->getMarkdownParser();
//            $md_content = $md_parser->transformSource($readme);
            $readme_content = $this->docbook->display(
                $md_content->getBody(),
                'content',
                array(
                    'page'=>$readme_dbfile->getDirIndexerStack(),
                    'page_notes'=>$md_content->getNotesToString()
                )
            );
*/
        }

        $tpl_params['title'] = Helper::buildPageTitle($this->getPath());
        if (empty($tpl_params['title'])) {
            if (!empty($tpl_params['breadcrumbs'])) {
                $tpl_params['title'] = Helper::buildPageTitle(end($tpl_params['breadcrumbs']));
            } else {
                $tpl_params['title'] = _T('Home');
            }
        }

		return array(self::$views_dir.'dirindex_template.html', $tpl_params);
/*
        $dir_content = $this->docbook->display($dbfile->getDirIndexerScanStack(), 'dirindex');

        return array('default', $dir_content.$readme_content, $tpl_params);
*/
    }

    public function htmlOnlyAction($path)
    {
        $this->setPath($path);
        $md_parser = $this->docbook->getMarkdownParser();
        $md_content = $md_parser->transformSource($this->getPath());
        return array('layout_empty_html', 
            $md_content->getBody(),
            array('page_notes'=>$md_content->getNotesToString())
        );
    }

    public function plainTextAction($path)
    {
        $this->setPath($path);
        $ctt = $this->docbook->getResponse()->flush(file_get_contents($this->getPath()));
        return array('layout_empty_txt', $ctt);
    }

    public function downloadAction($path)
    {
        $this->setPath($path);
        $this->docbook->getResponse()->download($path, 'text/plain');
        exit;
    }

    public function searchAction($path)
    {
        $this->setPath($path);
        $search = $this->docbook->getRequest()->getGet('s');
        if (empty($search)) return $this->indexAction($path);

        $_s = Helper::processDirIndexerSearch($search, $this->getPath());

        $dbfile = new DirIndexerFile($this->getpath());
        $tpl_params = array(
            'page' => $dbfile->getDirIndexerStack(),
            'breadcrumbs' => Helper::getBreadcrumbs($this->getPath()),
            'title' => _T('Search for "%search_str%"', array('search_str'=>$search))
        );

        $search_content = $this->docbook->display($_s, 'search', array(
            'search_str' => $search,
            'path' => Helper::buildPageTitle($this->getPath()),
        ));
        return array('default', $search_content, $tpl_params);
    }

// ------------------
// Path management
// ------------------

    public function setPath($path)
    {
        if (file_exists($path) || file_exists(Helper::getBaseDirHttp().$path)) {
            $this->path = $path;
        } else {
            throw new NotFoundException(
                sprintf('The requested page was not found (searching "%s")!', $path)
            );
        }
        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }


}

// Endfile
