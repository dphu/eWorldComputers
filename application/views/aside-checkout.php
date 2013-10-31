</section>
<aside class="four columns">
    <h6>Your Checkout Progress</h6>
    <ul>
        <li>Billing Address
            <ul>
                <li><?php echo $_SESSION['userInfo']->fname . ' ' . $_SESSION['userInfo']->lname; ?></li>
                <li><?php echo $_SESSION['userInfo']->address . '<br />' . $_SESSION['userInfo']->city . ', ' . $_SESSION['userInfo']->state . ', ' . $_SESSION['userInfo']->zipcode; ?></li>
                <li>Tel:  <?php if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $_SESSION['userInfo']->phone, $matches))
                        echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3]; ?>
            </ul>
        <li>Shipping Address</li>
        <li>Shipping Method</li>
        <li>Payment Method</li>
    </ul>
</aside>