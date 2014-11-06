<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */

if ( is_dynamic_sidebar( 'footer-sidebar' ) ) : ?>
			<div id="footer-sidebar" class="footer-sidebar">

				<div class="footer-inner">

					<ul>
						<?php dynamic_sidebar( 'footer-sidebar' ); ?>
					</ul>

				</div>

			</div><!-- #footer-sidebar -->
<?php endif; ?>