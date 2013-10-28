<section class="main">
    <section class="twelve columns">
        <?php if (empty($invoices)): ?>
            <article class="empty">
                <p>No Invoices Available</p>
            </article>
        <?php else: ?>
            <?php foreach ($invoices as $i): ?>
                <article class="product four columns" style="height:50px;">
                    <a href="<?php echo base_url() ?>main/invoice_focus/<?php echo $i['invoice_id'] ?>"><strong><?php echo substr($i['date'], 5, 2) . "/" . substr($i['date'], 8, 2) . "/" . substr($i['date'], 0, 4); ?></strong> [<?php echo $i['time']; ?>]</a>
                </article>
            <?php endforeach; ?>


        <?php endif; ?>
    </section>