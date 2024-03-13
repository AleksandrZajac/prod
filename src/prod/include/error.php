<?php if (isset($errors)):?>
<span class="custom-table__title">
<?php foreach ($errors as $value):?>
    <div class="main-menu__item active">
    <?=$value?>
    </div>
<?php endforeach;?>
</span>
<?php endif;?>

