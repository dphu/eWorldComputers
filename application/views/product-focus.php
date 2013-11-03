<section class="main">
    <article class="product-focus nowrap">
        <p class="breadcrumbs" >
            <a href="<?php echo base_url(); ?>">Home</a> / <a href="<?php echo $_SESSION['page']; ?>"><?php echo $_SESSION['current_view']; ?></a> / <strong><?php echo $product['name_en']; ?></strong>
        </p>
        <?php if (empty($product)): ?>
            <p><?php echo $_SESSION['current_view'] ?> is not available</p>

        <?php else: ?>
            <div class="six columns">
                <p>
                    <img src="<?php echo base_url(); ?>assets/images/<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name_en']); ?>" title="<?php echo htmlspecialchars($product['name_en']); ?>"
                         </img>
                </p>

                <p>                 E-World Computer supplies electronics and accessories to an authorized dealers across Orange Country, California. To see our electronics and accessories in person, please visit your local authorized E-World Computer dealer.
                </p>
                <form method="post" action="<?php echo base_url() . 'main/our-location'; ?>">
                    <input type="submit" value="Our Location" />
                </form>

            </div>
            <div class="six columns">
                <ul>

                    <li><?php
        echo $product['name_en'] . ' (';
        echo!empty($product['quantity']) ? '<span class="available">' . $product['quantity'] . ' In Stock' : '<span class="unavailable">Out of Stock';
        echo '</span>'
            ?>)</li>
                    <li class="bottom"><?php echo $product['code']; ?></li>
                    <li><strong>Price:  $<?php echo number_format($product['price'], 2, '.', ',') ?></strong></li>
                    <li><strong>Description:</strong>  <br /><?php echo $product['desc_en'] ?></li>
                </ul>


            <?php endif; ?>
        </div>