<h1>
    <?php if ($id):?>  
        Edit Shopping List
    <?php else: ?>
        Add new item to shopping list
    <?php endif; ?>
</h1>
<div style="color: red; font-weight: bold;">
    <?= validation_errors(); ?>
</div>
<form action="#" method="post">
    <fieldset>
        <div class="field">
            <label>Title:</label>
            <input name="item" type="text" value="<?= $todo->item; ?>"/>
        </div>
        <div class="wrapper">
            <input type="submit" class="waves-effect waves-light btn cyan lighten-2" name="save" value="<?php echo $id ? 'Edit' : 'Add'; ?>" class="submit" />
            <input type="submit" class="waves-effect waves-light btn cyan lighten-2" name="cancel" value="Cancel" />
        </div>
    </fieldset>
</form>
