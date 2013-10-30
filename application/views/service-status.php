<article class="product-focus twelve columns">
    <?php echo $_SESSION['current_view'] ?>
    <?php if (empty($services)): ?>
        <p> You have no items being serviced</p>

    <?php else: ?>
        <table border="1">
            <tr>
                <th>Item</th>
                <th>Service Type</th>
                <th>Status</th>
            </tr>
            <?php foreach ($services as $s): ?>
                <tr <?php
        if ($s['status'] == "Ready for Pickup") {
            echo "style='background-color:#77ff77;'";
        } elseif ($s['status'] == "Being Serviced") {
            echo "style='background-color:#eeee99;'";
        } elseif ($s['status'] == "Pending Service") {
            echo "style='background-color:#aaaaff;'";
        }
                ?>>
                    <td><?php echo $s['item'] ?></td>
                    <td><?php echo $s['sertype'] ?></td>
                    <td><?php echo $s['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</article>