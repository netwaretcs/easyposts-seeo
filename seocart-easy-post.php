<?php
	global $product;
    if ($product->is_type( 'variable' )) {
      	$available_variations = $product->get_available_variations();
      	$attributes = $product->get_variation_attributes();
      	$attribute_keys  = array_keys( $attributes );
		$variations_json = wp_json_encode( $available_variations );
		$variations_attr = function_exists( 'wc_esc_json' ) ? wc_esc_json( $variations_json ) : _wp_specialchars( $variations_json, ENT_QUOTES, 'UTF-8', true );
    }
?>
<div class="oxy-post ct-div-block prodotto grid mini <?php if ($product->get_featured()){ echo 'starred'; } ?> <?php $current_tags = get_the_terms( get_the_ID(), 'product_tag' ); foreach ($current_tags as $tag) { $tag_title = $tag->name; echo $tag_title.' ';} ?>">
  <div class="ct-div-block box-prodotto">
    <div class="ct-div-block">
      <div class="oxy-product-builder oxy-woo-element">
        <div class="product product-text">
          
        <?php if ($product->is_type( 'simple' )) { ?>
          
          <div class="oxy-product-wrapper-inner oxy-inner-content">
            <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" class="ct-image">
            <div class="ct-div-block ribbon"></div>
            <div class="badge">
              <?php
              $current_terms = get_the_terms( get_the_ID(), 'product_cat' );
              foreach ($current_terms as $term) {
                // get the thumbnail id
                $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ); 
                if ($thumbnail_id) {                          
                  // get the image URL
                  $image = wp_get_attachment_url( $thumbnail_id ); 
                  // print the IMG HTML
                  echo "<img src='{$image}' alt='' />";
                }
              }
              ?>
            </div>
          </div>


          <?php } else { ?>         
          
          <div class="woocommerce-product-gallery woocommerce-product-gallery--with-images woocommerce-product-gallery--columns-4 images" data-columns="4" style="opacity: 1; transition: opacity 0.25s ease-in-out 0s;">
            <figure class="woocommerce-product-gallery__wrapper">
              <div data-thumb="" data-thumb-alt="" class="woocommerce-product-gallery__image" data-o_data-thumb="">
                <img data-opt-src="<?php echo get_the_post_thumbnail_url(); ?>" src="<?php echo get_the_post_thumbnail_url(); ?>" class="wp-post-image" alt="" title="" data-caption="" data-src="<?php echo get_the_post_thumbnail_url(); ?>" data-large_image="" data-large_image_width="600" data-large_image_height="600" data-opt-lazy-loaded="true" data-opt-otimized-width="612" data-opt-optimized-height="612" data-o_src="<?php echo get_the_post_thumbnail_url(); ?>" data-o_height="412" data-o_width="412" data-o_srcset="" data-o_sizes="" sizes="" data-o_title="" data-o_data-caption="" data-o_alt="" data-o_data-src="" data-o_data-large_image="" data-o_data-large_image_width="600" data-o_data-large_image_height="600" width="412" height="412">
              </div>
            </figure>
            <div class="ct-div-block ribbon"></div>
            <div class="badge">
              <?php
              $current_terms = get_the_terms( get_the_ID(), 'product_cat' );
              foreach ($current_terms as $term) {
                // get the thumbnail id
                $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ); 
                if ($thumbnail_id) {                          
                  // get the image URL
                  $image = wp_get_attachment_url( $thumbnail_id ); 
                  // print the IMG HTML
                  echo "<img src='{$image}' alt='' />";
                }
              }
              ?>
            </div>
          </div>
          
          <?php } ?>
          
          <div class="oxy-product-wrapper-inner oxy-inner-content">
            <div class="texts">
              <h2 class="oxy-product-title product_title entry-title oxy-woo-element invert"><?php the_title(); ?></h2>
              <article class="oxy-product-excerpt  oxy-woo-element">
                <div class="woocommerce-product-details__short-description">
                  <?php the_excerpt(); ?>
                </div>
              </article>
            </div>
            <div class="oxy-product-meta oxy-woo-element">
              <div class="product_meta">
                <span class="tagged_as">
                  <?php
                  $current_tags = get_the_terms( get_the_ID(), 'product_tag' );
                  foreach ($current_tags as $tag) {
                    $tag_title = $tag->name; // tag name
                    $tag_link = get_term_link( $tag );// tag archive link
                    echo '<a>'.$tag_title.'</a>';
                  }
                  ?>
                </span>
              </div>
            </div>
            <div class="ct-div-block FC <?php if ($product->is_type( 'simple' )) {echo 'simple';}?> <?php if ( get_post_meta( get_the_ID(), '_sale_price', true ) ) {echo 'offerta';} ?>">
                <div class="oxy-product-price oxy-woo-element">
                <?php if ( get_post_meta( get_the_ID(), '_sale_price', true ) ) { ?>
                    <div class="price"><del><span class="woocommerce-Price-amount amount"><?php $regular_price = get_post_meta( get_the_ID(), '_regular_price', true ); ?><?php echo wc_price( $regular_price ); ?></span></del><ins><span class="woocommerce-Price-amount amount"><?php $sale_price = get_post_meta( get_the_ID(), '_sale_price', true ); ?><?php echo wc_price( $sale_price ); ?></span></ins></div>
                <?php } else { ?>
                    <div class="price"><ins><span class="woocommerce-Price-amount amount"><?php $price = get_post_meta( get_the_ID(), '_regular_price', true ); ?><?php echo wc_price( $price ); ?></span></ins></div>
                <?php } ?>
            </div>
              <div class="oxy-product-cart-button oxy-woo-element">
                
                
                  <?php if ($product->is_type( 'variable' )) { ?>
                    <form class="variations_form cart" action="#" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>">
                        <?php do_action( 'woocommerce_before_variations_form' ); ?>

                        <?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
                            <p class="stock out-of-stock"><?php echo esc_html( apply_filters( 'woocommerce_out_of_stock_message', __( 'This product is currently out of stock and unavailable.', 'woocommerce' ) ) ); ?></p>
                        <?php else : ?>
                            <table class="variations" cellspacing="0">
                                <tbody>
                                    <?php foreach ( $attributes as $attributo => $opzioni ) : ?>
                                        <tr>
                                            <td class="label"><label for="<?php echo esc_attr( sanitize_title( $attributo ) ); ?>"><?php echo wc_attribute_label( $attributo ); // WPCS: XSS ok. ?></label></td>
                                            <td class="value">
                                                <?php
                                                    wc_dropdown_variation_attribute_options(
                                                        array(
                                                            'options'   => $opzioni,
                                                            'attribute' => $attributo,
                                                            'product'   => $product,
                                                        )
                                                    );
                                                    echo end( $attribute_keys ) === $attributo ? wp_kses_post( apply_filters( 'woocommerce_reset_variations_link', '<a class="reset_variations" href="#">' . esc_html__( 'Clear', 'woocommerce' ) . '</a>' ) ) : '';
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                            <div class="single_variation_wrap">
                                <?php
                                    /**
                                     * Hook: woocommerce_before_single_variation.
                                     */
                                    do_action( 'woocommerce_before_single_variation' );

                                    /**
                                     * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.
                                     *
                                     * @since 2.4.0
                                     * @hooked woocommerce_single_variation - 10 Empty div for variation data.
                                     * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
                                     */
                                    do_action( 'woocommerce_single_variation' );

                                    /**
                                     * Hook: woocommerce_after_single_variation.
                                     */
                                    do_action( 'woocommerce_after_single_variation' );
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_after_variations_form' ); ?>
                    </form>
                  <?php } else { ?>
                  <form class="cart" action="#" method="post" enctype="multipart/form-data">
                    <div class="quantity">
                      <input type="number" max="" class="input-text qty text" name="quantity" value="1" title="Qtà" size="4" placeholder="" inputmode="numeric">
                    </div>
                    <button type="submit" name="add-to-cart" value="<?php the_ID() ?>" class="single_add_to_cart_button button alt">
                    </button>
                  </form>
                <?php } ?>
                
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <a class="chiudi"></a>
</div>
