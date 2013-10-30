
<section class="main">
    <section class ="twelve columns">
        <h3>Edit Profile<span>[All fields are required]</span></h3>
        <form class="contact_form" method="post" action ="<?php echo base_url(); ?>main/validateEditProfile">
            <table>
                <tr>
                    <td><label for="fname">First Name <span class="required">*</span><br /><input type="text" name="fname" required="required" value="<?php echo $userInfo->fname; ?>" /></label></td>
                    <td><label for="last-name">Last Name <span class="required">*</span><br /><input type="text" name="last-name" required="required" value="<?php echo $userInfo->lname; ?>"/></label></td>
                </tr>
                <tr>
                    <td><label for="company">Company<br /><input type="text" name="company" /></label></td>
                    <td><label for="email">Email Address <span class="required">*</span><br /><input type="email" name="email" required="required" value="<?php echo $userInfo->email; ?>"/></label></td>
                </tr>
                <tr>
                    <td colspan="2"><label for="address">Address <span class="required">*</span><br /><input type="text" name="address" required="required" value="<?php echo $userInfo->address; ?>"/></label></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="text" name="addressextra" /></td>
                </tr>
                <tr>
                    <td><label for="city">City <span class="required">*</span><br /><input type="text" name="city" required="required" value="<?php echo $userInfo->city; ?>"/></label></td>
                    <td><label for="state">State/Province <span class="required">*</span><br /><select name="state"><option value="CA" <?php if ($userInfo->state == 'CA') echo 'selected=selected'; ?>>CA</option></select></label></td>
                </tr>
                <tr>
                    <td><label for="zip">Zip/Postal Code <span class="required">*</span><br /><input type="text" name="zip" required="required" value="<?php echo $userInfo->zipcode; ?>"/></label></td>
                    <td><label for="country">Country <span class="required">*</span><br /><select name="country"><option value="USA">United States</option></select></label></td>
                </tr>
                <tr>
                    <td><label for="phone">Telephone <span class="required">*</span><br /><input type="tel" name="telephone" required="required" value="<?php echo $userInfo->phone; ?>"/></label></td>
                    <td><label for="fax">Fax<br /><input type="tel" name="fax" /></label></td>
                </tr>
            </table>
            <!--
            <fieldset>
                <legend>Basic Information</legend>
                <ul>
                    <li>
                        <label for="first-name">First Name</label>
                        <input type="text" name="first-name" id="first-name" required="required" autofocus="autofocus" value="<?php echo!empty($userInfo) ? $userInfo->fname : ""; ?>" />

                    </li>

                    <li>
                        <label for="last-name">Last Name</label>
                        <input type="text" name="last-name" id="last-name" required="required" value="<?php echo!empty($userInfo) ? $userInfo->lname : ""; ?>"/>
                    </li>
                </ul>
            </fieldset>

            <fieldset>
                <legend>Contact Information</legend>
                <ul>
                    <li>
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" required="required" value="<?php echo!empty($userInfo) ? $userInfo->address : ""; ?>" />
                    </li>

                    <li>
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" required="required" value="<?php echo!empty($userInfo) ? $userInfo->city : ""; ?>"/>
                    </li>
                    <li>
                        <label for="state">State</label>
                        <input type="text" name="state" id="state" required="required" value="<?php echo!empty($userInfo) ? $userInfo->state : ""; ?>"/>
                    </li>
                    <li>
                        <label for="zipcode">Zip Code</label>
                        <input type="text" name="zipcode" id="zipcode" required="required" value="<?php echo!empty($userInfo) ? $userInfo->zipcode : ""; ?>"/>
                    </li>
                    <li>
                        <label for="phone">Phone</label>
                        <input type="tel" name="phone" id="phone" required="required" value="<?php echo!empty($userInfo) ? $userInfo->phone : ""; ?>"/>
                    </li>
                </ul>
            </fieldset>
            -->
            <fieldset>
                <input type="submit" name="save" id="save" value="Save" />
            </fieldset>
        </form>
    </section>