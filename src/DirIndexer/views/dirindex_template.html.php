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

echo view(
    \DirIndexer\Controller\DirIndexer::$views_dir.'tools',
    array(
        'breadcrumbs'=>$breadcrumbs,
        'page'=>$page,
    )
);

?>
<div class="row-fluid">
    <div class="span1"></div>
    <div class="span10">
    <section>
    <table class="indextable">
    <thead>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Last update</th>
            <th>Size</th>
            <th>Description</th>
        </tr>
    </thead>
    <tbody>
<?php foreach ($content['dirscan'] as $_path): ?>
        <tr>
            <td><a href="<?php echo build_url(array(
	    		'controller'=>'dirindexer','path'=>$_path['route']
    		)); ?>" title="See this content">
                <i class="
                <?php if ($_path['type'] == 'dir'): ?>
                    icon-folder-open
                <?php elseif ($_path['type'] == 'img'): ?>
                    icon-picture
                <?php elseif ($_path['type'] == 'md'): ?>
                    icon-file
                <?php else: ?>
                    icon-fullscreen
                <?php endif; ?>
                "></i>
            </a></td>
            <td>
                <a href="<?php echo build_url(array(
	        		'controller'=>'dirindexer','path'=>$_path['route']
        		)); ?>" title="See this content"><?php echo $_path['name']; ?></a>
            </td>
            <td><small><?php echo $_path['mtime']->format('d-m-Y H:i:s'); ?></small></td>
            <td><small><?php echo $_path['size']; ?></small></td>
            <td><small>
    <?php if ($_path['type'] != 'dir' && $_path['extension'] != 'md'): ?>
            <?php echo $_path['extension']; ?>
        <?php if (!empty($_path['description'])): ?>
                &nbsp;-&nbsp;
        <?php endif; ?>
    <?php endif; ?>
                <?php echo isset($_path['description']) ? $_path['description'] : ''; ?>
            </small></td>
        </tr>
<?php endforeach; ?>
<?php if ($content['dir_has_wip']): ?>
        <tr>
            <td><a href="<?php echo build_url(array(
	    		'controller'=>'dirindexer','path'=>$_path['route'].'/wip'
    		)); ?>" title="See the work-in-progress of this chapter">
                <i class="icon-edit"></i>
            </a></td>
            <td colspan="4"><small><em>This folder has a "wip" section</em></small></td>
        </tr>
<?php endif; ?>
<?php if ($content['dir_is_clone']): ?>
        <tr>
    <?php if (!empty($content['clone_remote'])): ?>
            <td><a href="<?php echo $content['clone_remote']; ?>" title="See distant repository: <?php echo $content['clone_remote']; ?>">
                <i class="icon-calendar"></i>
            </a></td>
    <?php else: ?>
            <td><i class="icon-calendar"></i></td>
    <?php endif; ?>
            <td colspan="4"><small><em>This folder is a "GIT" clone of a remote repository.</em></small></td>
        </tr>
<?php endif; ?>
    </tbody>
    </table>
    </section>
    </div>
    <div class="span1"></div>
</div>

<?php if (!empty($readme)): ?>
<?php
echo view(
    \DirIndexer\Controller\DirIndexer::$views_dir.'md_template',
    array(
        'content'=>$readme,
        'no_tools'=>true,
    )
);
?>
<?php endif; ?>