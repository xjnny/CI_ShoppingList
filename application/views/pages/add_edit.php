<h1>
    <?php if ($id):?>  
        Edit TODO
    <?php else: ?>
        Add new TODO
    <?php endif; ?>
</h1>
<div style="color: red; font-weight: bold;">
    <?= validation_errors(); ?>
</div>
<form action="#" method="post">
    <fieldset>
        <div class="field">
            <label>Title:</label>
            <input name="title" type="text" value="<?= $todo->title; ?>"/>
        </div>
        <div class="wrapper">
            <input type="submit" name="save" value="<?php echo $id ? 'Edit' : 'Add'; ?>" class="submit" />
            <input type="submit" name="cancel" value="Cancel" />
        </div>
    </fieldset>
</form>
