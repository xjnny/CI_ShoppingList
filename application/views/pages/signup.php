<h1>Create an Account</h1>
<?php
//error message
if ($this->session->flashdata('error')):
    ?>
    <div class="alert alert-error" role="alert"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<?php echo validation_errors('<div class="alert alert-error">', "</div>"); ?>
<fieldset>
    <legend>Personal Information</legend>
    <?php echo form_open('todos/create_user'); ?>
    <div class="field">
	<?php
	$fn_data = array(
	    'name' => 'first_name',
	    'value' => set_value('first_name'),
	    'placeholder' => 'First name'
	);
	echo form_input($fn_data);
	?>
    </div>
    <div class="field">
	<?php
	$ln_data = array(
	    'name' => 'last_name',
	    'value' => set_value('last_name'),
	    'placeholder' => 'Last name'
	);
	echo form_input($ln_data);
	?>
    </div>
    <div class="field">
	<?php
	$email_data = array(
	    'name' => 'email_address',
	    'value' => set_value('email_address'),
	    'placeholder' => 'Email'
	);
	echo form_input($email_data);
	?>
    </div>
</fieldset>

<fieldset>
    <legend>Login Info</legend>
    <div class="field">
	<?php
	$un_data = array(
	    'name' => 'username',
	    'value' => set_value('username'),
	    'placeholder' => 'Username'
	);
	echo form_input($un_data);
	?>
    </div>
    <div class="field">
	<?php
	$pw_data = array(
	    'name' => 'password',
	    'value' => set_value('password'),
	    'placeholder' => 'Password'
	);
	echo form_password($pw_data);
	?>
    </div>
    <div class="field">
	<?php
	$pw2_data = array(
	    'name' => 'password2',
	    'value' => set_value('password2'),
	    'placeholder' => 'Confirm password'
	);
	echo form_password($pw2_data);
	?>
    </div>
    <div class="wrapper">
	<?php echo form_submit('save', 'Create Account', 'class="waves-effect waves-light btn cyan lighten-2 right"'); ?>
    </div>


</fieldset>

