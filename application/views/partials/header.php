<nav>
    <div class="blue-grey darken-1 nav-wrapper">
        <a href="/CI_ShoppingList/index.php/items" class="brand-logo">CI_ShoppingList</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <?php if (!isset($_SESSION['is_logged_in'])): ?>
                <li><?= anchor('items/signup', 'Sign Up'); ?>&nbsp</li>
                <li><?= anchor('items/login', 'Log In'); ?>&nbsp</li>
            <?php endif; ?>
            <li><?php if (isset($_SESSION['is_logged_in'])): ?></li>
                <?= $log = anchor('items/logout', 'Log Out'); ?>
            <?php endif; ?>  
        </ul>
    </div>
</nav>
