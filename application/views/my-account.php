<div class="my-account four container sixteen columns">
    <h3>Yay!  I logged in!!!!!!!</h3>
    <div id="loginarea">
        <ul>
            <li><input type="button" id="create" value="Edit Profile" onclick="location.href='<?php echo base_url(); ?>main/edit-profile'" /></li>
        </ul>
        <form id="logout-form" method="post" action="<?php echo base_url(); ?>main/logout">
            <ul>
                <li><input type="submit" name="submit" id="submit" value="Logout" /></li>
            </ul>
        </form>
    </div>
</div>