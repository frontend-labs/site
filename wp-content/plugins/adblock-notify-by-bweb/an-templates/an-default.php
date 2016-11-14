<?php
/**
	The default template
 *
 * @package adblock-notify-pro
 */
?>
<div class="<?php echo an_get_random_selector( 'reveal-modal' ); ?>-default">
	<h1 style="<?php an_template_heading_style();?>"><?php an_template_title();?></h1>
	<?php an_template_content();?>
</div>
<?php an_template_extra();?>
<?php an_template_footer();?>
