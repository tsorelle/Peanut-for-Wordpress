<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package philips
 */
?>

<div class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="copyright">
                    <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'philips' ) ); ?>"><?php printf( esc_html__( 'Powered by %s', 'philips' ), 'WordPress' ); ?></a>
                    <?php printf( esc_html__( 'Base theme: %1$s by %2$s.', 'philips' ), 'philips', 'Themepoints' ); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php wp_footer(); ?>

</body>
<?php
    \Peanut\sys\ViewModelManager::RenderStartScript();
?>
</html>
