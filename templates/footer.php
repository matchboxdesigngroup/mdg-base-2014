<footer class="content-info container clear" role="contentinfo">
	<div class="row">
		<div class="col-lg-12">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		</div>
	</div>
</footer>

<div title = 'Back to Top' class = 'page-top-link back-to-top'><a href = '#'>Return to top</a></div>
<?php wp_footer(); ?>
