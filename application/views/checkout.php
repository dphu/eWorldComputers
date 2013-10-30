<section class="main">
    <section class="twelve columns">
        <h3>Checkout</h3>
        <form method="post" action ="<?php echo base_url() . 'main/confirmation' ?>">
            <fieldset>
                <legend>Billing Information</legend>
                <table>
                    <tr>
                        <td><label for="fname">First Name <span class="required">*</span><br /><input type="text" name="fname" required="required" value="<?php echo $info->fname; ?>" /></label></td>
                        <td><label for="last-name">Last Name <span class="required">*</span><br /><input type="text" name="last-name" required="required" value="<?php echo $info->lname; ?>"/></label></td>
                    </tr>
                    <tr>
                        <td><label for="company">Company<br /><input type="text" name="company" /></label></td>
                        <td><label for="email">Email Address <span class="required">*</span><br /><input type="email" name="email" required="required" value="<?php echo $info->email; ?>"/></label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label for="address">Address <span class="required">*</span><br /><input type="text" name="address" required="required" value="<?php echo $info->address; ?>"/></label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" name="addressextra" /></td>
                    </tr>
                    <tr>
                        <td><label for="city">City <span class="required">*</span><br /><input type="text" name="city" required="required" value="<?php echo $info->city; ?>"/></label></td>
                        <td><label for="state">State/Province <span class="required">*</span><br /><select name="state"><option value="CA" <?php if ($info->state == 'CA') echo 'selected=selected'; ?>>CA</option></select></label></td>
                    </tr>
                    <tr>
                        <td><label for="zip">Zip/Postal Code <span class="required">*</span><br /><input type="text" name="zip" required="required" value="<?php echo $info->zipcode; ?>"/></label></td>
                        <td><label for="country">Country <span class="required">*</span><br /><select name="country"><option value="USA">United States</option></select></label></td>
                    </tr>
                    <tr>
                        <td><label for="phone">Telephone <span class="required">*</span><br /><input type="tel" name="telephone" required="required" value="<?php echo $info->phone; ?>"/></label></td>
                        <td><label for="fax">Fax<br /><input type="tel" name="fax" /></label></td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend>Shipping Information</legend>
                <!--
                <table>
                    <tr>
                        <td><label for="fname">First Name <span class="required">*</span><br /><input type="text" name="fname" required="required" /></label></td>
                        <td><label for="last-name">Last Name <span class="required">*</span><br /><input type="text" name="last-name" required="required" /></label></td>
                    </tr>
                    <tr>
                        <td><label for="company">Company<br /><input type="text" name="company" /></label></td>
                        <td><label for="email">Email Address <span class="required">*</span><br /><input type="email" name="email" required="required" /></label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><label for="address">Address <span class="required">*</span><br /><input type="text" name="address" required="required" /></label></td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="text" name="addressextra" /></td>
                    </tr>
                    <tr>
                        <td><label for="city">City <span class="required">*</span><br /><input type="text" name="city" required="required" /></label></td>
                        <td><label for="state">State/Province <span class="required">*</span><br /><select name="state"><option value="CA">CA</option></select></label></td>
                    </tr>
                    <tr>
                        <td><label for="zip">Zip/Postal Code <span class="required">*</span><br /><input type="text" name="zip" required="required" /></label></td>
                        <td><label for="country">Country <span class="required">*</span><br /><select name="country"><option value="USA">United States</option></select></label></td>
                    </tr>
                    <tr>
                        <td><label for="phone">Telephone <span class="required">*</span><br /><input type="tel" name="telephone" required="required" /></label></td>
                        <td><label for="fax">Fax<br /><input type="tel" name="fax" /></label></td>
                    </tr>
                </table>
                -->
            </fieldset>
            <fieldset>
                <legend>Shipping Method</legend>
            </fieldset>
            <fieldset>
                <legend>Payment Information</legend>
            </fieldset>
            <fieldset>
                <legend>Order Review</legend>
            </fieldset>
            <input type="submit" value="Confirm Purchase!" />
        </form>
    </section>