<div class="quick-access twelve columns">
    <div class="login">
        <ul>
            <li>
                <a href="<?php echo base_url(); ?>main/my-account">My Account</a>
            </li>
            <li>
                <a href="<?php echo base_url(); ?>main/shopping-cart">Shopping Cart <?php
$cart = $this->cart->contents();
if (!empty($cart))
    echo '(' . count($cart) . ' item' . (count($cart) > 1 ? 's)' : ')');
?></a>
            </li>
        </ul>
    </div>