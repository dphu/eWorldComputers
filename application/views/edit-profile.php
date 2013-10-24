
<section class="mainContent">
    <h3>Edit Profile<span>[All fields are required]</span></h3>
    <form class="contact_form" method="post" action ="<?php echo base_url(); ?>main/validateEditProfile">
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

        <fieldset>
            <input type="submit" name="save" id="save" value="Save" />
        </fieldset>
    </form>
</section>