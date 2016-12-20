<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */
?>

<?php /*  quitantole el comentario a la siguiente linea el footer vuelve a la normalidad */ ?>
<?php //if ( 'widget' == wpmedium_footer_sidebar_display() || 'both' == wpmedium_footer_sidebar_display() ) { get_sidebar(); } ?>


<div class="footer_start">

	<!-- BEGIN SMOWTION TAG - 728x90 - DO NOT MODIFY -->
	<script type="text/javascript">
	    smowtion_size = "728x90";
	    smowtion_ad_client = "SMWT-1-00004729-122-01-140831-2";
	</script>
	<script type="text/javascript" src="http://ads.smowtion.com/ad.js?spid=SMWT-1-00004729-122-01-140831-2&amp;z=728x90">
	</script>
	<!-- END SMOWTION TAG - 728x90 - DO NOT MODIFY -->

</div>

<div class="footer_start_two">

	<script type="text/javascript">
	  ( function() {
	    if (window.CHITIKA === undefined) { window.CHITIKA = { 'units' : [] }; };
	    var unit = {"calltype":"async[2]","publisher":"jansanchez","width":728,"height":90,"sid":"flabs","color_site_link":"5765ad","color_button":"5765ad","color_button_text":"ffffff"};
	    var placement_id = window.CHITIKA.units.length;
	    window.CHITIKA.units.push(unit);
	    document.write('<div id="chitikaAdBlock-' + placement_id + '"></div>');
	}());
	</script>
	<script type="text/javascript" src="//cdn.chitika.net/getads.js" async></script>

</div>

<?php /*
<div class="footer_start_three">
</div>
*/ ?>



<?php /*esta linea fue agregada para activar los widgets de footer manualmente --malazo  */ ?>
<?php get_sidebar(); ?>


<?php if ( 'copyright' == wpmedium_footer_sidebar_display() || 'both' == wpmedium_footer_sidebar_display() ) : ?>
			<footer id="mastfoot" class="site-footer">

				<div class="footer-inner">

					<div class="footer-copyright">
						<span class="copyright"><?php wpmedium_copyright(); ?></span>
					</div>

					<div class="footer-credit">
						<span class="credit">
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'jansanchez');" href="https://frontendlabs.io/author/jansanchez" title="Jan Sanchez" target="_blank">Jan Sanchez</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'anareyna');" href="https://frontendlabs.io/author/anareyna" title="Ana Reyna" target="_blank">Ana Reyna</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'andru255');" href="https://frontendlabs.io/author/andru255" title="Andres Muñoz" target="_blank">Andres Muñoz</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'erikfloresq');" href="https://frontendlabs.io/author/erikfloresq" title="Erik Flores" target="_blank">Erik Flores</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'VictorJSV');" href="https://frontendlabs.io/author/VictorJSV" title="Victor Sandoval" target="_blank">Victor Sandoval</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'Xio-Caro');" href="https://frontendlabs.io/author/Xio-Caro" title="Xio Caro" target="_blank">Xio Caro</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'Carlos-Huamani');" href="https://frontendlabs.io/author/Carlos-Huamani" title="Carlos Huamaní" target="_blank">Carlos Huamaní</a>, 
							<a onClick="ga('send', 'event', 'footer_autor', 'click', 'jjhoncv');" href="https://frontendlabs.io/author/jjhoncv" title="Jhonnatan Castro" target="_blank">Jhonnatan Castro</a>.
							<?php //wpmedium_credits(); ?>
						</span>
					</div>

				</div>

			</footer><!-- #footer -->
<?php endif; ?>

		</div><!-- .site -->

<?php wp_footer(); ?>
		<?php if (!isset($_REQUEST['preview'])) {
		?>
		<!-- Google Analytics  -->
		<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-52967407-1', 'auto');
		ga('require', 'displayfeatures');
		ga('send', 'pageview');
		</script>
		<?php
		} ?>
	</body>
</html>
