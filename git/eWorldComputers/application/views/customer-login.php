<div class="loginarea four eight columns">
    <h3>Login</h3>
    <form id="login-form" method="post" action="<?php echo base_url(); ?>main/login-validation">
        <fieldset>
            <ul>
                <li><input type="email" name="login-email" id="login-email" placeholder="Email" required="required" autofocus="true" /></li>
                <li><input type="password" name="login-password" id="login-password" placeholder="Password" required="required" /></li>
                <li><input type="submit" name="submit" id="submit" value="Login" /></li>
                <li><a href="#">Forgot Your Password?</a></li>
            </ul>
        </fieldset>
    </form>
</div>