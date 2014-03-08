<?php get_template_part( 'templates/head' ); ?>
<body <?php body_class(); ?>>

	<!--[if lt IE 7]><div class="alert"><?php _e( 'You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots' ); ?></div><![endif]-->

	<?php
do_action( 'get_header' );
// Use Bootstrap's navbar if enabled in config.php
if ( current_theme_supports( 'bootstrap-top-navbar' ) ) {
	get_template_part( 'templates/header-top-navbar' );
} else {
	get_template_part( 'templates/header' );
}
?>

	<div class="wrap clearfix" role="document">
		<div class="content">
			<div class="main <?php echo esc_attr( mdg_main_class() ); ?>" role="main">
				<div class="row">
					<?php include mdg_template_path(); ?>
				</div> <!-- /.row -->
			</div><!-- /.main -->
			<?php if ( mdg_display_sidebar() ) : ?>
			<aside class="sidebar <?php echo esc_attr( mdg_sidebar_class() ); ?>" role="complementary">
				<?php include mdg_sidebar_path(); ?>
			</aside><!-- /.sidebar -->
			<?php endif; ?>
		</div><!-- /.content -->
	</div><!-- /.wrap -->

	<?php get_template_part( 'templates/footer' ); ?>

</body>
</html>
