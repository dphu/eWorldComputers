<section class="cart six columns">
    <?php
    $rowID;

    foreach ($this->cart->contents() as $item)
        if ($item['id'] == $product['id']) {
            $rowID = $item['rowid'];
            $qty = $item['qty'];
            break;
        }
    ?>
    <?php if (!empty($product['quantity'])): ?>

        <form method="post" action="<?php echo base_url(); ?>main/addToCart/">
            <ul>
                <li>
                    <input type="number" min="0" max="<?php echo $product['quantity'] ?>" name="qty" id="qty" value="0" maxlength="3" size="3" />  <input type="submit" name="add_to_cart" id="submit" value="Add To Cart" />
                </li>
                <li><input type="hidden" name="id" value="<?php echo $product['id'] ?>"/></li>
                <?php if (!empty($rowID)): ?>
                    <li><input type="hidden" name="rowid" value="<?php echo $rowID ?>"/></li>
                <?php endif; ?>
            </ul>
        </form>
    <?php endif; ?>
</section>
</article>