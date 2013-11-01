<section class="main">
    <section class="twelve columns">
        <h3>Checkout</h3>
        <section class="accordion">
            <h5>Billing Information</h5>
            <div>
                <form  style="text-align: center" method="post" action ="<?php echo base_url() . 'main/confirmation' ?>">
                    <table class="eleven columns">
                        <tr>
                            <td><label for="fname">First Name <span class="required">*</span><br /><input id="fname" type="text" name="fname" required="required" value="<?php echo $userInfo->fname; ?>" /></label></td>
                            <td><label for="last-name">Last Name <span class="required">*</span><br /><input id="last-name" type="text" name="last-name" required="required" value="<?php echo $userInfo->lname; ?>"/></label></td>
                        </tr>
                        <tr>
                            <td><label for="company">Company<br /><input id="company" type="text" name="company" /></label></td>
                            <td><label for="email">Email Address <span class="required">*</span><br /><input id="email" type="email" name="email" required="required" value="<?php echo $userInfo->email; ?>" /></label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="address">Address <span class="required">*</span><br /><input id="address" type="text" name="address" required="required" value="<?php echo $userInfo->address; ?>"/></label></td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="text" name="addressextra" /></td>
                        </tr>
                        <tr>
                            <td><label for="city">City <span class="required">*</span><br /><input id="city" type="text" name="city" required="required" value="<?php echo $userInfo->city; ?>"/></label></td>
                            <td><label for="state">State/Province <span class="required">*</span><br /><select id="state" name="state">
                                        <?php foreach ($states as $state): ?>
                                            <option value="<?php echo $state['code']; ?>" <?php if ($_SESSION['userInfo']->state == $state['code']) echo 'selected=selected'; ?>><?php echo $state['name_en'] . ' (' . $state['code'] . ')'; ?></option>
                                        <?php endforeach; ?>
                                    </select></label></td>
                        </tr>
                        <tr>
                            <td><label for="zip">Zip/Postal Code <span class="required">*</span><br /><input id="zip" type="text" name="zip" required="required" value="<?php echo $userInfo->zipcode; ?>"/></label></td>
                            <td><label for="country">Country <span class="required">*</span><br /><select id="country" name="country"><option value="USA">United States</option></select></label></td>
                        </tr>
                        <tr>
                            <td><label for="phone">Telephone <span class="required">*</span><br /><input id="phone" class="phone" type="tel" name="telephone" required="required" value="<?php echo $userInfo->phone; ?>"/></label></td>
                            <td><label for="fax">Fax<br /><input id="fax" class="phone" type="tel" name="fax" /></label></td>
                        </tr>
                    </table>
                </form>
            </div>
            <h5>Shipping Information</h5>
            <div>
                
            </div>
            <h5>Shipping Method</h5>
            <div>
                <form method="post" action ="<?php echo base_url() . 'main/confirmation' ?>">
                    <label for="shipUPS">
                        <input id="shipUPS" type="radio" name="ship" value="ups" checked="checked" />UPS</label>
                    <label for="shipFedEx"><input id="shipFedEx" type="radio" name="ship" value="fedex" />FedEx</label>
                </form>
            </div>
            <h5>Payment Information</h5>
            <div>
                
            </div>
            <h5>Order Review</h5>
            <div>
                
            </div>
            <input type="submit" value="Confirm Purchase!" />
        </section>
    </section>