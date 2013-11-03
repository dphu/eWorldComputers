<section class="main">
    <section class="nowrap">
        <p class="breadcrumbs" ><a href="<?php echo base_url(); ?>">Home</a> / <strong><?php echo urldecode($_SESSION['current_view']); ?></strong></p>
        <h3><?php echo urldecode($_SESSION['current_view']); ?></h3>

        <?php if (empty($searchResult) || $searchResult == ''): ?>
            <article class="empty">
                <p>Your Search Returned no Results</p>
            </article>
        <?php else : ?>
            <?php foreach ($searchResult as $products): ?>
                <article class="product four columns">
                    <p><a href="<?php echo base_url(); ?>main/product-focus/<?php echo $products['id']; ?>"><img src ="<?php echo base_url(); ?>assets/images/<?php echo $products['image'] ?>" alt="<?php echo htmlspecialchars($products['name_en']); ?>" title="<?php echo htmlspecialchars($products['name_en']); ?>" /></a></p>
                    <p><a href="<?php echo base_url(); ?>main/product-focus/<?php echo $products['id']; ?>"><?php echo $products['name_en'] ?></a></p>
                    <p><strong>$<?php echo $products['price'] ?></strong></p>
                </article>
                <?php
            endforeach;
        endif;
        ?>
    </section>