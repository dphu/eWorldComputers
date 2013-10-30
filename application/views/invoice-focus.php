<section class="main">
    <section class="sixteen columns">
        <p>
            Thank you for your purchase!
        </p>
        <table class="invoice">
            <tr>
                <td colspan="2" align="left">
                    <?php echo!empty($invoice) ? $invoice[0]['date'] . " " . $invoice[0]['time'] : "" ?>
                </td>
                <td colspan="2" align="right">
                    <?php echo!empty($invoice) ? "Invoice # " . $invoice[0]['invoice_id'] : "" ?>
                </td>
            </tr>
            <tr>
                <td>
                    <ul>
                        <li>E-World Computer</li>
                        <li>9896 Katella Ave Suite A</li>
                        <li>Anaheim, CA, 92804</li>
                        <li>(714)539-9199</li>
                    </ul>
                </td>
                <td colspan="3">
                    <ul>
                        <li><?php echo $customer->fname . ", " . $customer->lname; ?></li>
                        <li><?php echo $customer->address; ?></li>
                        <li><?php echo $customer->city . ", " . $customer->state . ", " . $customer->zipcode; ?></li>
                        <li><?php echo $customer->phone; ?></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    Item
                </td>
                <td>
                    Quantity
                </td>
                <td>
                    Price
                </td>
                <td>
                    Total
                </td>
            </tr>
            <?php $total = 0 ?>
            <?php foreach ($invoice as $i): ?>
                <tr>
                    <td>
                        <?php echo $i['name_en']; ?>
                    </td>
                    <td>
                        <?php echo $i['qty']; ?>
                    </td>
                    <td>
                        <?php echo number_format($i['price'], 2); ?>
                    </td>
                    <td>
                        <?php
                        echo number_format($i['price'] * $i['qty'], 2);
                        $total+=$i['price'] * $i['qty'];
                        ?>
                    </td>
                </tr>
<?php endforeach; ?>
            <tr>
                <td colspan = "3" align="right">
                    Subtotal:
                </td>
                <td>
<?php echo number_format($total, 2); ?>
                </td>
            </tr>
            <tr>
                <td colspan = "3" align="right">
                    Tax:
                </td>
                <td>
<?php echo number_format(7.75, 2) . "%"; ?>
                </td>
            </tr>
            <tr>
                <td colspan = "3" align="right">
                    Total:
                </td>
                <td>
<?php echo number_format(($total * 0.0775) + $total, 2); ?>
                </td>
            </tr>
        </table>
        <form method="post" action="<?php echo base_url(); ?>">
            <input type="submit" value="Return Home" />
        </form>
    </section>