<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Fredo
 */

?>
<!-- FOOTER -->
			<div class="row footer">
				<div class="column">
					Copyright <?php echo date_i18n( 'Y' ); ?> @ <?php bloginfo( 'name' ); ?>
				</div>
			</div>

		</div>

	</div>
	<?php wp_footer(); ?>

<?php if ( get_theme_mod( 'fredo_tracking_code' ) ) : ?>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php esc_attr_e( get_theme_mod( 'fredo_tracking_code' ) ); ?>', 'auto');
	ga('send', 'pageview');

	</script>
<?php endif; ?>

</body>
</html>
