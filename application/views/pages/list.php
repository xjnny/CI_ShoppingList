<?php if ($this->session->flashdata('success')): ?>
    <div style="color: green; font-weight: bold;"><?= ($this->session->flashdata('success')); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div style="color: red; font-weight: bold;"><?= ($this->session->flashdata('error')); ?></div>
<?php endif; ?>

<?php if (!isset($_SESSION['is_logged_in'])): ?>
    <h4>You gotta log in to add to your shopping list!</h4>
<?php endif; ?>  

<?php if (isset($_SESSION['is_logged_in'])): ?>      
    <div class="todo-container">
        <?php foreach ($todos as $todo): ?>
            <div class="todo-item">
                <?php if ($this->db->select('id')->where('status', 'complete')->get('items')->row()): ?>
                    <?php if ($todo->id === $this->db->select('id')->where('status', 'complete')->get('items')->row()->id): ?>
                        <span class="complete"><?= $todo->item; ?></span> &nbsp<?= anchor('todos/add_edit/' . $todo->id, 'Edit'); ?>&nbsp|&nbsp<?= anchor('todos/delete/' . $todo->id, 'Delete'); ?>
                    <?php endif ?>
                <?php endif ?>
                <?php if ($this->db->select('id')->where('status', 'pending')->get('items')->row()): ?>
                    <?php if ($todo->id === $this->db->select('id')->where('status', 'pending')->get('items')->row()->id): ?>
                        <span class="pending"><?= $todo->item; ?></span>&nbsp<?= anchor('todos/complete/' . $todo->id, 'Complete'); ?>&nbsp|&nbsp<?= anchor('todos/add_edit/' . $todo->id, 'Edit'); ?>&nbsp|&nbsp<?= anchor('todos/delete/' . $todo->id, 'Delete'); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-white cyan"><?= anchor('todos/add_edit', 'Add A New Item To Your Shopping List'); ?></div>
<?php endif; ?>   




