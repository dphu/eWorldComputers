<div class="block block-subscribe">
    <div class="block-title">
        <strong><span>Sign Up for our Newsletter</span></strong>
    </div>
    <form action="<?php echo base_url() . 'main/subscribe'; ?>" method="post" id="newsletter-validate-detail">
        <div class="block-content">
            <div class="form-subscribe-header">
                <label for="newsletter">Join us for the latest promotions we have to offer.  Get access to exclusive discounts!</label>
            </div>
            <div class="input-box">
                <input type="email" name="email" id="newsletter" required="required" placeholder="Enter Your Email..." title="Sign up for our newsletter" class="input-text required-entry validate-email" />
            </div>
            <div class="actions">
                <button type="submit" title="Subscribe" class="button">Subscribe</button>
            </div>
        </div>
    </form>
</div>