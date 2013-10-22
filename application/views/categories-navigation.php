<section class="sidebar four columns">
    <section class="category-nav">
        <ul>
            <li><span>Products</span>
                <ul>
                    <?php foreach ($categories as $item): ?>
                        <?php if ($item['parent_id'] == 74) : ?>
                            <li>
                                <a href="<?php echo base_url(); ?>main/products/<?php echo $item['id']; ?>">
                                    <?php echo ucwords($item['name_en']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>

            <li><span>Accessories</span>
                <ul>
                    <?php foreach ($categories as $item): ?>
                        <?php if ($item['parent_id'] == 75) : ?>
                            <li>
                                <a href="<?php echo base_url(); ?>main/products/<?php echo $item['id']; ?>">
                                    <?php echo ucwords($item['name_en']); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>

            <li><span>Services</span>
                <ul>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/computer-upgrades">Computer Upgrades</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/memory-upgrades">Memory Upgrades</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/hard-drive-upgrades">Hard Drive Upgrades</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/laptop-not-charging">Laptop Not Charging</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/broken-lcd" >Broken LCD</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>main/services/data-recovery">Data Recovery</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>