<?php
/**
 * Cart Page
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version 2.3.8
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


wc_print_notices();

do_action('woocommerce_before_cart'); ?>

<form action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>
    <table class="cart table checkout_cart shop_table" cellspacing="0" style="margin-bottom: 20px;">
        <thead>
        <tr>
            <th class="product-thumbnail cart_del_column">&nbsp;</th>
            <th class="product-name"><?php _e('Product', ETHEME_DOMAIN); ?></th>
            <th class="product-price cart_del_column"><?php _e('Price', ETHEME_DOMAIN); ?></th>
            <th class="product-quantity"><?php _e('Qty', ETHEME_DOMAIN); ?></th>
            <th class="product-subtotal"><?php _e('Total', ETHEME_DOMAIN); ?></th>
            <th class="product-remove cart_del_column">&nbsp;</th>
        </tr>
        </thead>
	<tbody>
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        if (sizeof(WC()->cart->get_cart()) > 0) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                    ?>
                    <tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">


                        <!-- The thumbnail -->
                        <td class="product-thumbnail cart-del-column">
                            <?php
                            $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                            if ( ! $_product->is_visible() ) {
                                echo $thumbnail;
                            } else {
                                printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
                            }
                            ?>
                        </td>

                        <!-- Product Name -->
                        <td class="product-name">
                            <?php
                            if ( ! $_product->is_visible() ) {
                                echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
                            } else {
                                if(isset($cart_item['composite_parent'])){
                                    echo apply_filters( 'woocommerce_cart_item_name', sprintf( '%s', $_product->get_title() ), $cart_item, $cart_item_key );
                                }else{
                                    echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
                                }

                            }

                            // Meta data
                            echo WC()->cart->get_item_data( $cart_item );

                            // Backorder notification
                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
                            }
                            ?>
                        </td>

                        <!-- Product price -->
<!--                        <td class="product-price cart_del_column">-->
<!--                            --><?php
//                            echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
//                            ?>
<!--                        </td>-->
                        <td class="product-price cart_del_column">
                            <?php

                            $product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || WC()->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
                            if (is_a($_product, 'WC_Product_Composite')) {
                                $sum = 0;
                                foreach($cart_item['composite_data'] as $compositeId => $compositeItem){
                                    $compositePrice = get_post_meta($compositeItem['variation_id'], '_price', true);
                                    $sum += floatval($compositePrice);
                                }
                                $product_price = $sum;
                            }
                            echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price($product_price), $cart_item, $cart_item_key);
                            ?>
                        </td>

<!--                         Quantity inputs -->
                        <td class="product-quantity" id="cart-quantity">
                            <?php
                            if ($_product->is_sold_individually()) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                            } else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
                            }

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                            ?>
                        </td>

                        <!-- Product subtotal -->
                        <td class="product-subtotal">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                            ?>
                        </td>
                        <!-- Remove from cart link -->
                        <td class="product-remove cart_del_column">
                            <?php
                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                                '<a href="%s" class="delete-btn" title="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                                __( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ), $cart_item_key );
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        }

        do_action('woocommerce_cart_contents');
        ?>
        <tr>
            <td colspan="6" class="actions">

				<?php if ( WC()->cart->coupons_enabled() ) { ?>
                    <div class="coupon">

                        <label for="coupon_code"><?php _e('Coupon', ETHEME_DOMAIN); ?>:</label> <input
                            name="coupon_code" class="input-text" id="coupon_code" value=""/> <input type="submit"
                                                                                                     class="button apply-coupon"
                                                                                                     name="apply_coupon"
                                                                                                     value="<?php _e('Apply Coupon', ETHEME_DOMAIN); ?>"/>

                        <?php do_action('woocommerce_cart_coupon'); ?>

                    </div>
                <?php } ?>

                <input type="submit" class="button update-button" name="update_cart"
                       value="<?php _e('Update Cart', ETHEME_DOMAIN); ?>"/>

                <?php do_action('woocommerce_cart_actions'); ?>

                <?php wp_nonce_field('woocommerce-cart') ?>
            </td>
        </tr>

        <?php do_action('woocommerce_after_cart_contents'); ?>
	</tbody>
    </table>
    <?php do_action('woocommerce_after_cart_table'); ?>
</form>
<div class="cart-collaterals">

    <?php do_action('woocommerce_cart_collaterals'); ?>

</div>

<?php do_action('woocommerce_after_cart'); ?>
