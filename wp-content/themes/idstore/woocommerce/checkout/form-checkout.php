

<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


global $woocommerce; $woocommerce_checkout = $woocommerce->checkout();
$isAccordion = etheme_get_option('checkout_accordion');

wc_print_notices();

woocommerce_checkout_coupon_form(); ?>

<div class="<?php if($isAccordion): ?>tabs accordion checkout-accordion<?php else: ?>checkout-default<?php endif; ?>">
	<?php if(!is_user_logged_in()): ?>
		<!-- ----------------------------------------------- -->
		<!-- ------------------- LOGIN --------------------- -->
		<!-- ----------------------------------------------- -->
		<?php if($isAccordion): ?><a class="tab-title checkout-accordion-title" id="tab_1"><span><?php _e('Checkout Method', ETHEME_DOMAIN) ?></span></a><?php endif; ?>
		<div class="tab-content tab-login" id="content_tab_1">
			<div class="col2-set">
				<div class="col-1 checkout-login">
					<div class="checkout-methods">

						<?php if (get_option('woocommerce_enable_signup_and_login_from_checkout') != 'no'): ?>
							<div class="method-radio">

								<!-- ----------------------------------------------- -->
								<!-- ------ -- Existing Account -- ----------------- -->
								<!-- ----------------------------------------------- -->
								<label>Login for Returning Customers
									<input type="radio" name="method" value="0" checked="checked"></input>
								</label>
								<div class="checkout-customers existingCustomerBox shiftRight">
									<?php do_action( 'woocommerce_before_checkout_form', $checkout );
									// If checkout registration is disabled and not logged in, the user cannot checkout
									if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) :
										echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', ETHEME_DOMAIN));
										return;
									endif;
									?>
								</div>

								<!-- ----------------------------------------------- -->
								<!-- ----------- -- New Account -- ----------------- -->
								<!-- ----------------------------------------------- -->

								<label>Create an Account
									<input type="radio" id="method2" name="method" value="2" />
								</label>
								<div class="createAccountInfo startHidden shiftRight">
									<label>Email Address: <abbr class="required" title="required">*</abbr>
										<div class="newPEmailBox form-row form-row-first validate-required validate-email woocommerce-invalid woocommerce-invalid-required-field"><input type="text" class="mirrorEmailBox" /></div>
									</label>

									<label>Password: <abbr class="required" title="required">*</abbr>
										<div class="newPasswordBox form-row validate-required woocommerce-invalid woocommerce-invalid-required-field"><input type="password" class="mirrorPwBox" /></div>
									</label>

									<label>Password Confirmation: <abbr class="required" title="required">*</abbr>
										<div class="newPasswordBox2 form-row validate-required woocommerce-invalid woocommerce-invalid-required-field"><input type="password" class="mirrorPwBox" /></div>
									</label>
									<div class='passwordStatus'>&nbsp</div>
									<a class="button continueCreateAccunt leaveTab1"><span>Continue</span></a>
								</div>


								<!-- ----------------------------------------------- -->
								<!-- -------- -- Guest Checkout -- ----------------- -->
								<!-- ----------------------------------------------- -->
								<?php if ($checkout->enable_guest_checkout): ?>
									<label>Checkout as Guest
										<input type="radio" id="method1" name="method" value="1" />
									</label>
									<span class="continueAsGuest startHidden" >You will not be able to check the status of your order if you do not create an account.</span>


									<div class="continueAsGuest startHidden shiftRight"><a class="button  leaveTab1"style="display:inline-block;"><span>Continue</span></a></div>
								<?php endif ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>


	<form id='checkoutForm' name="checkout" method="post" class="checkout checkout-form" action="<?php echo esc_url( $get_checkout_url ); ?>">

		<?php if(!is_user_logged_in()): ?>
			<?php if (get_option('woocommerce_enable_signup_and_login_from_checkout')=="yes") : ?>
				<!-- ----------------------------------------------- -->
				<!-- -------------- -- REGISTER -- ----------------- -->
				<!-- ----------------------------------------------- -->
				<div class='hiddenInOurTheme'>
					<?php if($isAccordion): ?><a class="tab-title checkout-accordion-title" id="tab-register"><span><?php _e('Create an Account', ETHEME_DOMAIN) ?></span></a><?php endif; ?>
					<div class="tab-content register-tab-content" id="content_tab-register">

						<?php if (get_option('woocommerce_enable_guest_checkout')=='yes') : ?>

							<p class="form-row">
								<input class="input-checkbox" id="createaccount" <?php checked($woocommerce_checkout->get_value('createaccount'), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e('Create an account?', ETHEME_DOMAIN); ?></label>
							</p>

						<?php endif; ?>

						<?php do_action( 'woocommerce_before_checkout_registration_form', $woocommerce_checkout ); ?>

						<div class="create-account-form">

							<!--<p><?php _e('Create an account by entering the information below. If you are a returning customer please login with your username at the top of the page.', ETHEME_DOMAIN); ?></p>-->

							<?php foreach ($woocommerce_checkout->checkout_fields['account'] as $key => $field) : ?>

								<?php woocommerce_form_field( $key, $field, $woocommerce_checkout->get_value( $key ) ); ?>

							<?php endforeach; ?>
						</div>

						<?php do_action( 'woocommerce_after_checkout_registration_form', $woocommerce_checkout ); ?>

						<?php if($isAccordion): ?><a class="button checkout-cont checkout-cont2 leaveTab2"><span><?php _e('Continue', ETHEME_DOMAIN) ?></span></a><?php endif; ?>

					</div>
				</div>
			<?php endif; ?>

		<?php endif; ?>


		<?php
		// filter hook for include new pages inside the payment method
		$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', $woocommerce->cart->get_checkout_url() ); ?>

		<?php if (sizeof($woocommerce_checkout->checkout_fields)>0) : ?>

			<!-- ----------------------------------------------- -->
			<!-- ----------------- BILLING --------------------- -->
			<!-- ----------------------------------------------- -->
			<?php if($isAccordion): ?><a class="tab-title checkout-accordion-title" id="tab_3"><span><?php _e('Billing Address', ETHEME_DOMAIN) ?></span></a><?php endif; ?>
			<div class="tab-content tab-billing" id="content_tab_3">
				<?php do_action('woocommerce_checkout_billing'); ?>

				<?php if($isAccordion): ?>
					<div class='woocommerce-billing-fields'><p class="theContinueParagraph"><a class="button checkout-cont leaveTab3"><span><?php _e('Continue', ETHEME_DOMAIN) ?></span></a></p></div>
				<?php endif; ?>
			</div>




			<!-- ----------------------------------------------- -->
			<!-- ----------------- SHIPPING -------------------- -->
			<!-- ----------------------------------------------- -->
			<?php if($isAccordion): ?><a href="javascript:void(0)" class="tab-title checkout-accordion-title" id="tab_4"><span><?php _e('Shipping Address, Notes & Pickup Time', ETHEME_DOMAIN) ?></span></a><?php endif; ?>
			<div class="tab-content tab-shipping" id="content_tab_4">
				<?php
				$free_shipping_coupon_exists = false;
				$couponfree = "";
				foreach($woocommerce->cart->coupons as $index => $coupon){
					if($coupon->enable_free_shipping()){
						$free_shipping_coupon_exists = true;
						$couponfree = $coupon;
					}
				}
//				if(!$free_shipping_coupon_exists): ?>
				<?php do_action('woocommerce_before_checkout_shipping'); do_action('woocommerce_checkout_shipping'); ?>
				<?php if($isAccordion): ?>
					<div class='woocommerce-billing-fields'style="width:100%;">
					<div class='warningBlock'>
						<p style="height:100%;width:95%;">If you selected a pickup time and date that is less than 2 days from now we will do our best to fill your order completely, however we cannot guarantee that all of your selections will be immediately available. We will call or email you if we are unable to complete your order.  If you selected a pickup time or date more than 2 days out, we will have everything ready for you!</p>
					</div>
					<p><a class="button checkout-cont  leaveTab4"><span><?php _e('Continue', ETHEME_DOMAIN) ?></span></a></p>
					</div><?php endif; ?>
<!--				--><?php //else :
//					if( $post = get_post($couponfree->id)){
//						if(!empty($post->post_excerpt)){
//							echo "<p class='coupon-description'>$post->post_excerpt</p>";
//						}
//					}
//					endif;
//				?>


			</div>
			<!-- ----------------------------------------------- -->
			<!-- ------------------ ORDER ---------------------- -->
			<!-- ----------------------------------------------- -->
		<?php endif; ?>

		<?php if($isAccordion): ?><a class="tab-title checkout-accordion-title" id="tab_5">
			<span><?php _e('Confirm Order & Pick Shipping Option', ETHEME_DOMAIN) ?></span></a><?php endif; ?>
		<div class="tab-content tab-order" id="content_tab_5">
			<h3 id="order_review_heading"><?php _e('Your order', ETHEME_DOMAIN); ?></h3>
			<?php do_action('woocommerce_checkout_order_review'); ?>
			<a class="button" id="fakeSubmitOrder">Place Order</a>

		</div>

	</form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
