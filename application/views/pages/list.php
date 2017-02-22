<?php if ($this->session->flashdata('success')): ?>
    <div style="color: green; font-weight: bold;"><?= ($this->session->flashdata('success')); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div style="color: red; font-weight: bold;"><?= ($this->session->flashdata('error')); ?></div>
<?php endif; ?>

<?= anchor('todos/add_edit', 'Add'); ?>
<?php foreach ($todos as $todo): ?>
    <div>
        <span><?= $todo->item; ?></span>&nbsp<?= anchor('todos/add_edit/' . $todo->id, 'Edit'); ?>&nbsp|&nbsp<?= anchor('todos/delete/' . $todo->id, 'Delete'); ?>
    </div>
<?php endforeach; ?>