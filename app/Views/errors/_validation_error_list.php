<?php if ($errors): ?>
<div class="alert alert-danger" role="alert">
	<h6><i class="icon fa fa-ban"></i> Error</h6>
    <ul>
    <?php foreach ($errors as $error) : ?>
        <li><?= esc($error) ?></li>
    <?php endforeach ?>
    </ul>
</div>
<?php endif ?>
