<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package shizzo
 */

?>
		</div><!-- .container -->
	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				$copyright 		= get_theme_mod( 'copyright_textbox', 'Proudly Powered by WordPress' );
				$copyright_flag = get_theme_mod( 'copyright_flag' );
				$copyright_link	= get_theme_mod( 'copyright_link' );
				if( $copyright_flag ) {
					printf( '<a href="%s">%s</a>', esc_url( $copyright_link ), $copyright );
				}else{
					echo $copyright;
				}
			?>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'shizzo' ), 'shizzo', '<a href="http://tidyhive.com/" rel="designer">Tidyhive</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
<?php
    \Tops\ui\TViewModelManager::RenderStartScript();
?>
</html>
