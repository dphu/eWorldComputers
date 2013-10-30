<div class="my-account four container sixteen columns">
    <h3>Yay!  I logged in!!!!!!!</h3>
    <div id="loginarea">
        <form method="post" action="<?php echo base_url() . 'main/edit-profile'; ?>">
            <input type="submit" value="Edit Profile" />
        </form>
        <form method="post" action="<?php echo base_url() . 'main/service-status'; ?>">
            <input type="submit" value="Service Status" />
        </form>
        <form method="post" action="<?php echo base_url() . 'main/invoice'; ?>">
            <input type="submit" value="Invoices" />
        </form>
        <form id="logout-form" method="post" action="<?php echo base_url(); ?>main/logout">
            <input type="submit" name="submit" id="submit" value="Logout" />
        </form>
    </div>
</div>