<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
$prev_page = ($pager->hasPreviousPage() ? "&page=" . (explode('page=', $pager->getPreviousPage())[1] ?? null) : null);
$next_page = ($pager->hasNextPage() ? "&page=" . (explode('page=', $pager->getNextPage())[1] ?? null) : null);
?> 
<div class="btn-group" aria-label="<?= lang('Pager.pageNavigation') ?>">
    <a href="<?= $pager->getPreviousPage() ?? '#' ?>" aria-label="<?= lang('Pager.previous') ?>" class="btn btn-default btn-sm mail-loader<?= $pager->hasPreviousPage() ? '' : ' disabled' ?>" data-page="<?= $prev_page ?>">
    	<i class="fas fa-chevron-left"></i> 
    </a> 

    <a href="<?= $pager->getNextPage() ?? '#' ?>" aria-label="<?= lang('Pager.previous') ?>" class="btn btn-default btn-sm mail-loader<?= $pager->hasNextPage() ? '' : ' disabled' ?>" data-page="<?= $next_page ?>">
    	<i class="fas fa-chevron-right"></i> 
    </a>  	
</div> 