<?php

if (empty($page)) $page=array();

/*
echo '<pre>';
//var_export($object);
var_export($page);
var_export($breadcrumbs);
echo '</pre>';
*/

if (!isset($no_tools) || $no_tools!==true) {
    echo view(
        \DirIndexer\Controller\DirIndexer::$views_dir.'tools',
        array(
            'breadcrumb'=>$breadcrumb,
            'page'=>$page,
        )
    );
}
?>
<div class="content" id="object_content">
	<?php echo $content; ?>
</div>

<br class="clear" />

<div class="small_infos_right">
<?php if (!empty($page['size'])) : ?>
	File size: <?php echo $page['size']; ?>
<?php endif; ?>
<?php if (!empty($page['mtime'])) : ?>
	&nbsp;|&nbsp;
	Last update on <?php echo $page['mtime']->format('d-m-Y H:i:s'); ?>
<?php endif; ?>
</div>

<br class="clear" />