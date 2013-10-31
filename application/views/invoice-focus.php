<section class="main">
    <section class="sixteen columns">
        <p>
            Thank you for your purchase!
        </p>
        <table class="invoice">
            <tr>
                <td colspan="2" align="left">
                    <?php echo!empty($invoice) ? date('l, m/d/Y', strtotime($invoice[0]['date'])) . ', ' . date('g:i A', strtotime($invoice[0]['time'])) : "" ?>
                </td>
                <td colspan="2" align="right">
                    <?php echo!empty($invoice) ? "Invoice # " . $invoice[0]['invoice_id'] : "" ?>
                </td>
            </tr>
            <tr>
                <td>
                    E-World Computer<br />
                    9896 Katella Ave Suite A<br />
                    Anaheim, CA, 92804<br />
                    (714) 539 - 9199<br />
                </td>
                <td colspan="3"><?php echo $customer->lname . ", " . $customer->fname; ?><br />
                    <?php echo $customer->address; ?><br />
                    <?php echo $customer->city . ", " . $customer->state . ", " . $customer->zipcode; ?><br />
                    <?php
                    if (preg_match('/(\d{3})(\d{3})(\d{4})$/', $customer->phone, $matches))
                        echo '(' . $matches[1] . ') ' . $matches[2] . ' - ' . $matches[3];
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Item</strong>
                </td>
                <td align="right">
                    <strong>Quantity</strong>
                </td>
                <td align="right">
                    <strong>Price</strong>
                </td>
                <td align="right">
                    <strong>Total</strong>
                </td>
            </tr>
            <?php $total = 0 ?>
<?php foreach ($invoice as $i): ?>
                <tr>
                    <td>
    <?php echo $i['name_en']; ?>
                    </td>
                    <td align="right">
    <?php echo $i['qty']; ?>
                    </td>
                    <td align="right">
    <?php echo '$' . number_format($i['price'], 2); ?>
                    </td>
                    <td align="right">
                        <?php
                        echo '$' . number_format($i['price'] * $i['qty'], 2);
                        $total += $i['price'] * $i['qty'];
                        ?>
                    </td>
                </tr>
<?php endforeach; ?>
            <tr>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan = "3" align="right">
                    <strong>Subtotal:</strong>
                </td>
                <td align="right">
<?php echo '$' . number_format($total, 2); ?>
                </td>
            </tr>
            <tr>
                <td colspan = "3" align="right">
                    <strong>Tax:</strong>
                </td>
                <td align="right">
<?php echo number_format(7.75, 2) . "%"; ?>
                </td>
            </tr>
            <tr>
                <td colspan = "3" align="right">
                    <strong>Total:</strong>
                </td>
                <td align="right">
<?php echo '$' . number_format(($total * 0.0775) + $total, 2); ?>
                </td>
            </tr>
        </table>
        <form method="post" action="<?php echo base_url(); ?>">
            <input type="submit" value="Return Home" />
        </form>
    </section>