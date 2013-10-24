<div class="createarea four eight columns">
    <h3>Create Account</h3>
    <form class="contact_form" method="post" action ="<?php echo base_url(); ?>main/validateCreateAccount">
        <fieldset>
            <ul>
                <li>
                    <label for="email">Email
                    </label>
                    <input type="email" name="email" id="email" autofocus="autofocus" required="required" />
                </li>

                <li>
                    <label for="password">Password (6-15 alphanumeric)
                    </label>
                    <input type="password" name="password" id="password" required="required" minlength="6" maxlength="15" />

                </li>

                <li>
                    <label for="confirm-password">Confirm Password
                    </label>
                    <input type="password" name="confirm-password" id="confirm-password" required="required" equa/>
                </li>

                <li>
                    <input type="submit" name="submit" id="submit" value="Submit" />
                </li>
            </ul>
        </fieldset>
    </form>
</div>

<div>
    <p>
        By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.
    </p>

</div>