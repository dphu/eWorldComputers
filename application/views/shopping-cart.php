<section class="main">
    <section class="twelve columns">
        <h3>Shopping Cart <?php
$var = $this->cart->contents();
if (empty($var)):
   ?>is Empty</h3>
            <?php if (!empty($_SESSION['product_name'])): ?>
                <p class="product"><?php echo $_SESSION['product_name']; ?></p>
            <?php endif; ?>
            <p>
                Your shopping cart is empty...<img src="<?php echo base_url() . 'assets/images/cry.ico'; ?>" alt="Crying" title="Crying"/>
            </p>
            <form action="<?php echo empty($_SESSION['page']) || $_SESSION['page'] == base_url() . 'main/shopping-cart' ? base_url() : $_SESSION['page']; ?>">
                <input type="submit" value="Continue Shopping"/>
            </form>
        <?php else: ?>
            </h3>
            <?php if (!empty($_SESSION['product_name'])): ?>
                <p class="product">INFORMATION:  <?php echo $_SESSION['product_name']; ?></p>
            <?php endif; ?>
            <form method="post" action="<?php echo base_url() . 'main/update-cart'; ?>">
                <table summary="My Shopping Cart">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Unit Price</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Subtotal</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <td colspan="2"><a href="<?php echo empty($_SESSION['page']) || $_SESSION['page'] == base_url() . 'main/shopping-cart' ? base_url() : $_SESSION['page']; ?>">Continue Shopping</a></td>
                            <td colspan="4"><input type="submit" name="update_cart" value="Update Shopping Cart" /></td>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($this->cart->contents() as $item): ?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url() . 'main/remove-item/' . $item['rowid']; ?>">
                                        <img src="<?php echo base_url() . 'assets/images/cart_remove.png'; ?>" title="Remove <?php echo htmlspecialchars($item['name']) . ' from shopping cart.' ?>" alt="Remove <?php echo htmlspecialchars($item['name']) . ' from shopping cart.' ?>"/>
                                    </a>
                                </td>
                                <td>
                                    <a href="<?php echo base_url() . 'main/product-focus/' . $item['id']; ?>"><img src="<?php echo base_url() . 'assets/images/' . $item['img']; ?>" alt="<?php echo $item['name']; ?>" title="<?php echo $item['name']; ?>" /></a>
                                </td>
                                <td>
                                    <section><a href="<?php echo base_url() . 'main/product-focus/' . $item['id']; ?>"><?php echo $item['name']; ?></a></section>
                                </td>
                                <td><?php echo '$' . number_format($item['price'], 2, '.', ','); ?></td>
                                <td>
                                    <input type="number" min="0" max="999" size="3" maxlength="3" name="item[<?php echo $item['rowid']; ?>]" value="<?php echo $item['qty']; ?>"/>
                                </td>
                                <td><?php echo '$' . number_format($item['subtotal'], 2, '.', ','); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </form>
            <?php $_SESSION['page'] = base_url() . 'main/shopping-cart' ?>

            <form method="post" action="<?php echo base_url() . 'main/checkout'; ?>">
                <input type="submit" value="Proceed to Checkout" />
            </form>
        <?php endif; ?>
    </section>

