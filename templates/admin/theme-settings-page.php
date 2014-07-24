<?php global $mdg_settings; ?>
<div>
	<h2>Theme Settings</h2>
	<form action="options.php" method="post">
		<?php settings_fields( $mdg_settings->option_group ); ?>
		<?php do_settings_sections( $mdg_settings->page_slug ); ?>
		<input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Settings' ); ?>">
	</form>
</div>