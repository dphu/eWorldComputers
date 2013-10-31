<section class="main">
    <section class="sixteen columns">
        <?php if (empty($invoices)): ?>
            <article class="empty">
                <p>No Invoices Available</p>
            </article>
        <?php else: ?>
            <?php foreach ($invoices as $i): ?>
                <article class="product four columns" style="height:50px;">
                    <a href="<?php echo base_url() ?>main/invoice_focus/<?php echo $i['invoice_id'] ?>"><strong><?php echo date('m/d/Y', strtotime($i['date'])); ?></strong> [<?php echo date('g:i A', strtotime($i['time'])); ?>]</a>
                </article>
            <?php endforeach; ?>

        <?php endif; ?>
    </section>