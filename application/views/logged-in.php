<div class="quick-access twelve columns">
    <div class="login">
        <ul>
            <li>
                <?php if (!empty($_SESSION['userID'])): ?>
                    Welcome <a href="<?php echo base_url(); ?>main/my-account"><?php echo (empty($userInfo->fname) && empty($userInfo->lname)) ? 'User' : $userInfo->fname . " " . $userInfo->lname ?></a>
                <?php else: ?>
                    <a href="<?php echo base_url(); ?>main/my-account">My Account</a>
                <?php endif ?>

            </li>
            <li>
                <a href="<?php echo base_url(); ?>main/shopping-cart">Shopping Cart <?php
                $cart = $this->cart->contents();
                if (!empty($cart)) {
                    $total = 0;
                    foreach ($cart as $item)
                        $total += $item['qty'];
                    echo '(' . $total . ' item' . ($total > 1 ? 's)' : ')');
                }
                ?></a>
            </li>
        </ul>
    </div>