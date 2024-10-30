<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://boostools.app/wp/
 * @since      1.0.0
 *
 * @package    boostools
 * @subpackage boostools/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
	<div class="wrap">
	    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
		<?php if(get_option( 'boostools_option_subdomain' ) == "Domain not found!"): ?>
		<div>
			<h3>Domain you provided is not valid. Maybe yoy haven't added your site at you account dashboard?</h3>
		</div>
		<?php endif; ?>
		<div>
			In order to use all  <a href="https://boostools.app/account/" target="_blank">Boostools</a> tools, you need to install Boostools plugin on your Wordpress site. When it’s installed you need only check Checkbox input «Boostools script ON» and Save changes.  After this, your added site on Boostools will be automatically synchronized with your WP site.
		</div>
		<form action="options.php" method="post">
	        <?php
	            settings_fields( $this->plugin_name );
	            do_settings_sections( $this->plugin_name );
	            submit_button();
	        ?>
	    </form>
		
	</div>