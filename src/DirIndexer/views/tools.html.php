<?php
if (!isset($breadcrumb)) $breadcrumb=array();
if (!isset($page)) $page=array();
$i=0;
?>
<div class="content-tools">

<?php if (!empty($breadcrumb)): ?>
    <div class="float-left">
        <?php echo @$breadcrumb; ?>
    </div>
<?php endif; ?>

<?php if (!empty($page['previous']) || !empty($page['next'])): ?>
    <div class="float-right">
    <?php if (!empty($page['previous'])): ?>
        <a href="<?php echo build_url(array(
            'controller'=>'dirindexer','path'=>$page['previous']
        )); ?>" title="See this content">
        &lt; Previous
        </a>
    <?php endif; ?>

    <?php if (!empty($page['previous']) && !empty($page['next'])): ?>
    &nbsp;|&nbsp;
    <?php endif; ?>

    <?php if (!empty($page['next'])): ?>
        <a href="<?php echo build_url(array(
            'controller'=>'dirindexer','path'=>$page['next']
        )); ?>" title="See this content">
        Next &gt;
        </a>
    <?php endif; ?>
    </div>
<?php endif; ?>

</div>
<br class="clear" />

