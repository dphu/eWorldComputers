<section class="main">
    <section class="nowrap">
        <p class="breadcrumbs" ><a href="<?php echo base_url(); ?>">Home</a> / <strong><?php echo ucwords(urldecode($_SESSION['current_view'])); ?></strong></p>

        <?php if (empty($product)): ?>
            <article class="empty">
                <p>There are no <?php echo urldecode($_SESSION['current_view']) ?> available</p>
            </article>
        <?php endif; ?>
        <?php foreach ($product as $item): ?>
            <article class="product four columns">
                <p><a href="<?php echo base_url(); ?>main/product-focus/<?php echo $item['id']; ?>"><img src ="<?php echo base_url(); ?>assets/images/<?php echo $item['image'] ?>" alt="<?php echo htmlspecialchars($item['product_name_en']); ?>" title="<?php echo htmlspecialchars($item['product_name_en']); ?>" /></a></p>
                <p><a href="<?php echo base_url(); ?>main/product-focus/<?php echo $item['id']; ?>"><?php echo $item['product_name_en'] ?></a></p>
                <p><strong>$<?php echo number_format($item['price'], 2, '.', ',') ?></strong></p>
            </article>
        <?php endforeach; ?>

        <?php echo $links; ?>
    </section>