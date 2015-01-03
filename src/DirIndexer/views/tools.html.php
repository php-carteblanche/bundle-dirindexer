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

