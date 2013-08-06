<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 */
?>
	</div><!-- #main .wrapper -->
    <?php if ( is_active_sidebar( 'lower-left' )
    	|| is_active_sidebar( 'lower-middle' )
    	|| is_active_sidebar( 'lower-right' )) : ?>
		<div class="container" id="column-widgets">
			<div class="row">
				<?php if (is_active_sidebar( 'lower-left' )): ?>
					<div class="col-lg-4 left-column">
						<?php dynamic_sidebar( 'lower-left' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'lower-middle' ) ):
					if ( is_active_sidebar( 'lower-left' ) ): ?>
						<div class="col-lg-4 center-column">
					<?php else: ?>
						<div class="col-lg-4 col-offset-4 center-column">
					<?php endif; ?>
						<?php dynamic_sidebar( 'lower-middle' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'lower-right' ) ): ?>
					<?php if ( is_active_sidebar( 'lower-middle' ) ): ?>
						<div class="col-lg-4 right-column">
					<?php elseif (is_active_sidebar( 'lower_left')
					&& !is_active_sidebar( 'lower_middle') ): ?>
						<div class="col-lg4 col-offset-4 right-column">
					<?php else: ?>
						<div class="col-lg-4 col-offset-8 right-column">
					<?php endif; ?>
						<?php dynamic_sidebar( 'lower-right' ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- .first -->
	<?php endif; ?>
	<footer role="contentinfo">

		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php do_action( 'fup_credits' ); ?>
					<a href="<?php
						echo esc_url( __( 'http://wordpress.org/', 'fup' ) );
						?>" title="<?php
						esc_attr_e(
								'Semantic Personal Publishing Platform',
								'fup'
								); ?>"><?php
						printf( __(
									'Proudly powered by %s',
									'fup' ),
									'WordPress'
									); ?></a>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>
