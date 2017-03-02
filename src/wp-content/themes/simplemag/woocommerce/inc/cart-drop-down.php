<?php
// Check if WooCommerce is installed & activated
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
?>

		<!-- Link into the Shopping Cart page -->
		<a href="<?php //echo esc_url( $woocommerce->cart->get_cart_url() ); ?>"><?php _e('Shopping Bag', 'themetext'); ?></a>

		<!-- Cart Overview -->
		<?php echo $woocommerce->cart->get_cart_total(); ?> <span class="minicart_items">/ <?php echo $woocommerce->cart->cart_contents_count; ?> <?php _e('item(s)', 'themetext'); ?></span>

		<!-- Items Quanity -->
		<?php echo $woocommerce->cart->cart_contents_count; ?>


		<?php                                    
		echo '<ul class="cart_list">';                                        
			
			if (sizeof($woocommerce->cart->cart_contents)>0) : 
				foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
				    $_product = $cart_item['data'];                                            
				    if ($_product->exists() && $cart_item['quantity']>0) :                                            
				        echo '<li class="cart_list_product">';                                                
				            echo '<a class="cart_list_product_img" href="'.get_permalink($cart_item['product_id']).'">' . $_product->get_image().'</a>';                                                    
				            echo '<div class="cart_list_product_title">';
				                $gbtr_product_title = $_product->get_title();
				                //$gbtr_short_product_title = (strlen($gbtr_product_title) > 28) ? substr($gbtr_product_title, 0, 25) . '...' : $gbtr_product_title;
				                echo '<a href="'.get_permalink($cart_item['product_id']).'">' . apply_filters('woocommerce_cart_widget_product_title', $gbtr_product_title, $_product) . '</a>';
				                echo '<div class="cart_list_product_quantity">'.__('Quantity:', 'themetext').' '.$cart_item['quantity'].'</div>';
				            echo '</div>';
				            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s"><i class="icomoon-trash-o"></i></a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'themetext') ), $cart_item_key );
				            echo '<div class="cart_list_product_price">'.woocommerce_price($_product->get_price()).'</div>';
				            echo '<div class="clr"></div>';                                                
				        echo '</li>';                                         
				    endif;                                        
				endforeach;
			?>

			    <div class="minicart_total_checkout">                                        
			        <?php _e('Cart subtotal', 'themetext'); ?><?php echo $woocommerce->cart->get_cart_total(); ?>                                   
			    </div>
			    
			    <a href="<?php //echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button gbtr_minicart_cart_but"><?php _e('View Shopping Bag', 'themetext'); ?></a>   
			    
			    <a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button gbtr_minicart_checkout_but"><?php _e('Proceed to Checkout', 'themetext'); ?></a>
		    
		    <?php                                        
		    else: 
		    	echo '<li class="empty">'.__('No products in the shopping bag.','themetext').'</li>'; 
		    endif;                                    
		echo '</ul>';                                    
		?>      

		 <a href="<?php //echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="gbtr_little_shopping_bag_wrapper_mobiles"><?php echo $woocommerce->cart->cart_contents_count; ?></a>

<?php } ?>