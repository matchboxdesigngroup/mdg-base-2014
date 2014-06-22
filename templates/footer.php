<footer class="content-info container clear" role="contentinfo">
	<div class="row">
		<div class="col-lg-12">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		</div>
	</div>
</footer>

<div title="Back to Top" class="css3pie page-top-link back-to-top">
	<a href="#" class="css3pie">Return to top</a>
</div> <!-- /.back-to-top -->
<?php wp_footer(); ?>