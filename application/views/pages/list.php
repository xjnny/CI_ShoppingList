
<?php if (!isset($_SESSION['is_logged_in'])): ?>
    <h5 class="center-align">You gotta <?= anchor('items/login', 'Log In'); ?> to add to your shopping list!</h5>
<?php endif; ?> 
<?php if (isset($_SESSION['is_logged_in'])): ?> 
    <ul class="collection with-header">
        <li class="collection-header"><h5>Shopping List</h5></li>
        <div class="btn-floating btn waves-effect waves-light text-white cyan lighten-2"><?= anchor('items/add_edit', '<i class="material-icons">add</i>'); ?></div>  
        <?php
        $complete_query = $this->db->select('id')->where('status', 'complete')->get('items');
        $pending_query = $this->db->select('id')->where('status', 'pending')->get('items');
        ?>
        <?php foreach ($items as $item): ?> <?php if ($complete_query): ?>
                <?php foreach ($complete_query->result_array() as $complete_row): ?>
                    <?php if ($item->id === $complete_row['id']): ?>
                        <li class="collection-item">  
                            <?= anchor('items/uncomplete/' . $item->id, '<i class="red-text text-lighten-1 material-icons">cancel</i>'); ?> 
                            <span class="complete"><?= $item->item; ?></span> 
                            <span class="right"><?= anchor('items/add_edit/' . $item->id, '<i class="grey-text material-icons">edit</i>'); ?>    <?= anchor('items/delete/' . $item->id, '<i class="grey-text material-icons">delete</i>'); ?>
                            </span>
                         </li>
                    <?php endif ?>
                <?php endforeach; ?>
            <?php endif ?><?php if ($pending_query): ?>
                <?php foreach ($pending_query->result_array() as $pending_row): ?>
                    <?php if ($item->id === $pending_row['id']): ?>
                        <li class="collection-item">
                            <?php $checkdata = array('id' => 'check'); ?>
                            <!--ITEM fix onclick function-->
                            <?php $checkjs = array('onClick' => 'items/complete/'); ?>
                            <?php // echo form_checkbox($checkdata, $checkjs['onClick']); ?>
                            <!--<label for="check">--> 
                            <?= anchor('items/complete/' . $item->id, '<i class="green-text text-lighten-1 material-icons">check_circle</i>'); ?> 
                            <span class="pending"><?= $item->item; ?>
                            </span>
                            <!--</label>-->
                            <span class="right">
                                <?= anchor('items/add_edit/' . $item->id, '<i class="grey-text material-icons">edit</i>'); ?>
                                <?= anchor('items/delete/' . $item->id, '<i class="grey-text material-icons">delete</i>'); ?>
                            </span>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>   
</ul>
    
    <?php if ($this->session->flashdata('success')): ?>
    <div class="center " style="padding: 10px 0;color: #66bb6a;"><?= ($this->session->flashdata('success')); ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="center" style="padding: 10px 0; color: #ef5350;"><?= ($this->session->flashdata('error')); ?></div>
<?php endif; ?>