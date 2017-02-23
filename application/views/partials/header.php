<?php if (!isset($_SESSION['is_logged_in'])): ?>
<?= anchor('todos/signup', 'Sign Up'); ?>&nbsp
<?= anchor('todos/login', 'Log In'); ?>&nbsp
<?php endif; ?>
<?php if (isset($_SESSION['is_logged_in'])): ?>
<?= anchor('todos/logout', 'Log Out'); ?>
<?php endif; ?>
<header>This is the header.</header>