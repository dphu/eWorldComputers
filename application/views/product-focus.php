<section class="main">
    <article class="product-focus twelve columns">
        <p class="breadcrumbs" >
            <a href="<?php echo base_url(); ?>">Home</a> / <a href="<?php echo $_SESSION['page']; ?>"><?php echo $_SESSION['current_view']; ?></a> / <strong><?php echo $product['name_en']; ?></strong>
        </p>
        <?php if (empty($product)): ?>
            <p><?php echo $_SESSION['current_view'] ?> is not available</p>

        <?php else: ?>
            <p>
                <img src="<?php echo base_url(); ?>assets/images/<?php echo $product['image'] ?>" alt="<?php echo htmlspecialchars($product['name_en']); ?>" title="<?php echo htmlspecialchars($product['name_en']); ?>"
                     </img>
            </p>

            <p><?php
        echo $product['name_en'] . ' (';
        echo!empty($product['quantity']) ? '<span class="available">' . $product['quantity'] . ' In Stock' : '<span class="unavailable">Out of Stock';
        echo '</span>'
            ?>)</p>

            <p><strong>Price:  $<?php echo number_format($product['price'], 2, '.', ',') ?></strong></p>
            <p><strong>Description:  <br /><?php echo $product['desc_en'] ?></strong></p>
        <?php endif; ?>
