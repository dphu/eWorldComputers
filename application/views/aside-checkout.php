</section>

<aside class="four columns">
    <h5>Your Checkout Progress</h5>
    <section class="accordion">
        <h6>Billing Address</h6>
        <div>
            <ul>
                <h6><?php echo $_SESSION['userInfo']->fname . ' ' . $_SESSION['userInfo']->lname; ?></h6>
                <h6><?php echo $_SESSION['userInfo']->address . '<br />' . $_SESSION['userInfo']->city . ', ' . $_SESSION['userInfo']->state . ', ' . $_SESSION['userInfo']->zipcode; ?></h6>
                <h6>Tel:  <?php
if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $_SESSION['userInfo']->phone, $matches))
    echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3];
?>
            </ul>
        </div>
        <h6>Shipping Address</h6>
        <div>
            <ul>
                <h6><?php echo $_SESSION['userInfo']->fname . ' ' . $_SESSION['userInfo']->lname; ?></h6>
                <h6><?php echo $_SESSION['userInfo']->address . '<br />' . $_SESSION['userInfo']->city . ', ' . $_SESSION['userInfo']->state . ', ' . $_SESSION['userInfo']->zipcode; ?></h6>
                <h6>Tel:  <?php
if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $_SESSION['userInfo']->phone, $matches))
    echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3];
?>
            </ul>
        </div>
        <h6>Shipping Method</h6>
        <div>
            <ul>
                <h6><?php echo $_SESSION['userInfo']->fname . ' ' . $_SESSION['userInfo']->lname; ?></h6>
                <h6><?php echo $_SESSION['userInfo']->address . '<br />' . $_SESSION['userInfo']->city . ', ' . $_SESSION['userInfo']->state . ', ' . $_SESSION['userInfo']->zipcode; ?></h6>
                <h6>Tel:  <?php
                    if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $_SESSION['userInfo']->phone, $matches))
                        echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3];
?>
            </ul>
        </div>
        <h6>Payment Method</h6>
        <div>
            <ul>
                <h6><?php echo $_SESSION['userInfo']->fname . ' ' . $_SESSION['userInfo']->lname; ?></h6>
                <h6><?php echo $_SESSION['userInfo']->address . '<br />' . $_SESSION['userInfo']->city . ', ' . $_SESSION['userInfo']->state . ', ' . $_SESSION['userInfo']->zipcode; ?></h6>
                <h6>Tel:  <?php
                    if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $_SESSION['userInfo']->phone, $matches))
                        echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3];
?>
            </ul>
        </div>
    </section>
</aside>