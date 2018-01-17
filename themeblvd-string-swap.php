<?php
/*
Plugin Name: Theme Blvd String Swap
Description: This plugin will allow you alter the standard text strings that appear on the frontend of your site when using a Theme Blvd theme.
Version: 1.0.9
Author: Theme Blvd
Author URI: http://themeblvd.com
License: GPL2

    Copyright 2016  Theme Blvd

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

define( 'TB_STRING_SWAP_PLUGIN_VERSION', '1.0.9' );
define( 'TB_STRING_SWAP_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TB_STRING_SWAP_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Register text domain for localization.
 *
 * @since 1.0.3
 */
function tb_string_swap_textdomain() {
	load_plugin_textdomain('theme-blvd-string-swap');
}
add_action( 'init', 'tb_string_swap_textdomain' );

/**
 * Display warning telling the user they must have a
 * theme with Theme Blvd framework v2.2+ installed in
 * order to run this plugin.
 *
 * @since 1.0.4
 */
function tb_string_swap_warning() {

	global $current_user;

	// DEBUG: delete_user_meta( $current_user->ID, 'tb-nag-shortcodes-no-framework' );

	if ( ! get_user_meta( $current_user->ID, 'tb-nag-string-swap-no-framework' ) ) {
		echo '<div class="updated">';
		echo '<p><strong>Theme Blvd String Swap:</strong> '.__( 'You are not using a theme with the Theme Blvd Framework v2+, and so this plugin will not do anything.', 'theme-blvd-string-swap' ).'</p>';
		echo '<p><a href="'.tb_string_swap_disable_url('string-swap-no-framework').'">'.__('Dismiss this notice', 'theme-blvd-string-swap').'</a> | <a href="http://www.themeblvd.com" target="_blank">'.__('Visit ThemeBlvd.com', 'theme-blvd-string-swap').'</a></p>';
		echo '</div>';
	}
}

/**
 * Dismiss an admin notice.
 *
 * @since 1.0.4
 */
function tb_string_swap_disable_nag() {

	global $current_user;

	if ( ! isset($_GET['nag-ignore']) ) {
		return;
	}

	if ( strpos($_GET['nag-ignore'], 'tb-nag-') !== 0 ) { // meta key must start with "tb-nag-"
		return;
	}

	if ( isset($_GET['security']) && wp_verify_nonce( $_GET['security'], 'themeblvd-string-swap-nag' ) ) {
		add_user_meta( $current_user->ID, $_GET['nag-ignore'], 'true', true );
	}
}

/**
 * Disable admin notice URL.
 *
 * @since 1.0.4
 */
function tb_string_swap_disable_url( $id ) {

	global $pagenow;

	$url = admin_url( $pagenow );

	if( ! empty( $_SERVER['QUERY_STRING'] ) ) {
		$url .= sprintf( '?%s&nag-ignore=%s', $_SERVER['QUERY_STRING'], 'tb-nag-'.$id );
	} else {
		$url .= sprintf( '?nag-ignore=%s', 'tb-nag-'.$id );
	}

	$url .= sprintf( '&security=%s', wp_create_nonce('themeblvd-string-swap-nag') );

	return $url;
}

/*-----------------------------------------------------------------------------------*/
/* Setup Default Text Strings and Options
/*-----------------------------------------------------------------------------------*/

/**
 * Get text strings
 *
 * This function only gets used if the user
 * is using a theme with Theme Blvd framework
 * prior to 2.1. So, it's essentially a fail-safe.
 */
function tb_string_swap_get_strings() {
	$locals = array (
		'404'						=> 'Apologies, but the page you\'re looking for can\'t be found.',
		'404_title'					=> '404 Error',
		'archive_no_posts'			=> 'Apologies, but there are no posts to display.',
		'archive'					=> 'Archive',
		'cancel_reply_link'			=> 'Cancel reply',
		'categories'				=> 'Categories',
		'category'					=> 'Category',
		'comment_navigation'		=> 'Comment navigation',
		'comments'					=> 'Comments',
		'comments_closed'			=> 'Comments are closed.',
		'comments_newer'			=> 'Newer Comments &rarr;',
		'comments_no_password'		=> 'This post is password protected. Enter the password to view any comments.',
		'comments_older'			=> '&larr; Older Comments',
		'comments_title_single'		=> 'One comment on &ldquo;%2$s&rdquo;',
		'comments_title_multiple'	=> '%1$s comments on &ldquo;%2$s&rdquo;',
		'contact_us'				=> 'Contact Us',
		'crumb_404'					=> 'Error 404',
		'crumb_author'				=> 'Articles posted by',
		'crumb_search'				=> 'Search results for',
		'crumb_tag'					=> 'Posts tagged',
		'edit_page'					=> 'Edit Page',
		'email'						=> 'Email',
		'home'						=> 'Home',
		'invalid_layout'			=> 'Invalid Layout ID',
		'label_submit'				=> 'Post Comment',
		'last_30'					=> 'The Last 30 Posts',
		'monthly_archives'			=> 'Monthly Archives',
		'name'						=> 'Name',
		'page'						=> 'Page',
		'pages'						=> 'Pages',
		'page_num'					=> 'Page %s',
		'posts_per_category'		=> 'Posts per category',
		'navigation' 				=> 'Navigation',
		'no_slider' 				=> 'Slider does not exist.',
		'no_slider_selected' 		=> 'Oops! You have not selected a slider in your layout.',
		'no_video'					=> 'The video url could not retrieve a video.',
		'read_more'					=> 'Read More',
		'search'					=> 'Search the site...',
		'search_no_results'			=> 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.',
		'tag'						=> 'Tag',
		'title_reply'				=> 'Leave a Reply',
		'title_reply_to'			=> 'Leave a Reply to %s',
		'website'					=> 'Website'
	);
	return $locals;
}

/**
 * Get Options to pass into Option Framework's
 * function to generate form.
 */
function tb_string_swap_get_options() {

	// Retrieve current local text strings -- This will also
	// be modified later to tell the user they need to
	// update their theme.
	if ( function_exists('themeblvd_get_all_locals') ) {

		// Dynamically pull from theme with
		// filters applied.
		$locals = themeblvd_get_all_locals();

	} else {

		// Old method for people using Theme Blvd
		// framework prior to 2.1
		$locals = tb_string_swap_get_strings();

	}

	// Configure options array
	$options[] = array(
		'name'	=> __( 'Standard Text Strings', 'theme-blvd-string-swap' ),
		'desc'	=> __( 'Here you can find most of the text strings that you will typically find on the frontend of your site when using a Theme Blvd theme. Simply enter in a new value for each one that you want to change.<br><br>Note: This is a general plugin aimed at working with all Theme Blvd themes, however it\'s impossible to guarantee that this will effect every theme in the exact same way.', 'theme-blvd-string-swap' ),
		'type' 	=> 'section_start'
	);

	foreach( $locals as $id => $string ) {
		$options[] = array(
			'desc' 	=> '<strong>'.__( 'Internal ID', 'theme-blvd-string-swap' ).':</strong> '.$id.'<br><strong>'.__( 'Original String', 'theme-blvd-string-swap' ).':</strong> '.$string,
			'id' 	=> $id,
			'std' 	=> $string,
			'type' 	=> 'textarea'
		);
	}

	$options[] = array(
		'type' => 'section_end'
	);

	$options[] = array(
		'name'	=> __( 'Blog Meta', 'theme-blvd-string-swap' ),
		'desc'	=> null,
		'type' 	=> 'section_start'
	);

	$options[] = array(
		'desc' 	=> __( 'Designate how you\'d like the meta info to display in your blog. This typically will show below the title of blog posts in most theme designs.<br><br>You can use the following macros:<br><strong>%date%</strong> - Date post was published.<br><strong>%author%</strong> - Author that wrote the post.<br><strong>%categories%</strong> - Categories post belongs to.<br><br><em>Note: Save this option as blank to allow the theme to show its normal meta info.</em>', 'theme-blvd-string-swap' ),
		'id' 	=> 'blog_meta',
		'std' 	=> __( 'Posted on %date% by %author% in %categories%', 'theme-blvd-string-swap' ),
		'type' 	=> 'textarea'
	);

	if ( version_compare(TB_FRAMEWORK_VERSION, '2.5.0', '>=') ) { // Having this ommitted in older themes is for the "closer" bug!
		$options[] = array(
			'type' => 'section_end'
		);
	}

	return $options;
}

/*-----------------------------------------------------------------------------------*/
/* Setup Admin Page
/*-----------------------------------------------------------------------------------*/

/**
 * Hook everything in to being the process only if the user can
 * edit theme options, or else no use running this plugin.
 */
function tb_string_swap_admin() {

	// Check to make sure Theme Blvd Framework 2.0+ is running
	if ( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.0.0', '<' ) ) {
		add_action( 'admin_notices', 'tb_string_swap_warning' );
		add_action( 'admin_init', 'tb_string_swap_disable_nag' );
		return;
	}

	// If using framework v2.2+, we can use the framework's
	// internal options system and if not, we can do it the
	// old-fashioned way.

	if ( class_exists( 'Theme_Blvd_Options_Page' ) ) {

		// Use new options system incorporated in v2.2.

		global $_tb_string_swap_admin;

		$options = tb_string_swap_get_options();

		$args = array(
			'parent'		=> 'themes.php', // only used prior to framework 2.5.2
			'page_title' 	=> __( 'Theme Text Strings', 'theme-blvd-string-swap' ),
			'menu_title' 	=> __( 'Theme Text Strings', 'theme-blvd-string-swap' ),
			'cap'			=> apply_filters( 'tb_string_swap_cap', 'edit_theme_options' )
		);

		$_tb_string_swap_admin = new Theme_Blvd_Options_Page( 'tb_string_swap', $options, $args );

	} else {

		// Initiate old-school method for framewok v2.0-2.1
		add_action( 'init', 'tb_string_swap_rolescheck' );

	}
}
add_action( 'after_setup_theme', 'tb_string_swap_admin' );

/**
 * Hook everything in to being the process only if the user can
 * edit theme options, or else no use running this plugin.
 *
 * NOTE: This only is used if we're using framework v2.0-2.1.
 */
function tb_string_swap_rolescheck() {
	if ( current_user_can( 'edit_theme_options' ) ) {
		add_action( 'admin_init', 'tb_string_swap_init' );
		add_action( 'admin_menu', 'tb_string_swap_add_page');
	}
}

/**
 * Add a menu page for this plugin.
 *
 * NOTE: This only is used if we're using framework v2.0-2.1.
 */
function tb_string_swap_add_page() {
	// Create sub menu page
	$string_swap_page = add_submenu_page( 'themes.php', __('Theme Text Strings', 'theme-blvd-string-swap'), __('Theme Text Strings', 'theme-blvd-string-swap'), 'administrator', 'tb_string_swap', 'tb_string_swap_page' );
	// Adds actions to hook in the required css and javascript
	add_action( "admin_print_styles-$string_swap_page", 'optionsframework_load_styles' );
	add_action( "admin_print_scripts-$string_swap_page", 'optionsframework_load_scripts' );
	add_action( "admin_print_styles-$string_swap_page", 'optionsframework_mlu_css', 0 );
	add_action( "admin_print_scripts-$string_swap_page", 'optionsframework_mlu_js', 0 );
}

/**
 * Inititate anything needed for the plugin.
 *
 * NOTE: This only is used if we're using framework v2.0-2.1.
 */
function tb_string_swap_init() {
	// Register settings
	register_setting( 'tb_string_swap_settings', 'tb_string_swap', 'tb_string_swap_validate' );
}

/**
 * Validate settings when updated.
 *
 * Note: This function realistically has more than it needs.
 * In this specific plugin, we're only working with one kind
 * of option, which is the "textarea" type of option, however
 * I'm keeping all validation types in this plugin as to setup
 * a nice model for making more plugins in the future that
 * may also include different kinds of options.
 *
 * NOTE: This only is used if we're using framework v2.0-2.1.
 */
function tb_string_swap_validate( $input ) {

	// Reset Settings
	if ( isset( $_POST['reset'] ) ) {
		$empty = array();
		add_settings_error( 'tb_string_swap', 'restore_defaults', __( 'Default options restored.', 'theme-blvd-string-swap' ), 'updated fade' );
		return $empty;
	}

	// Save Options
	if ( isset( $_POST['update'] ) && isset( $_POST['options'] ) ) {

		$clean = array();
		$options = tb_string_swap_get_options();

		foreach ( $options as $option ) {

			// Verify we have what need from options
			if ( ! isset( $option['id'] ) ) continue;
			if ( ! isset( $option['type'] ) ) continue;

			$id = preg_replace( '/\W/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST['options']
			if ( 'checkbox' == $option['type'] && ! isset( $_POST['options'][$id] ) ) {
				$_POST['options'][$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST['options']
			if ( 'multicheck' == $option['type'] && ! isset( $_POST['options'][$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$_POST['options'][$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $_POST['options'][$id], $option );
			}
		}

		add_settings_error( 'tb_string_swap', 'save_options', __( 'Options saved.', 'theme-blvd-string-swap' ), 'updated fade' );

		return $clean;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Display Admin Page
/*-----------------------------------------------------------------------------------*/

/**
 * Builds out the full admin page.
 *
 * NOTE: This only is used if we're using framework v2.0-2.1.
 */
function tb_string_swap_page() {

	// DEBUG
	// $settings = get_option('tb_string_swap');
	// echo '<pre>'; print_r($settings); echo '</pre>';

	// Build form
	$options = tb_string_swap_get_options();
	$settings = get_option('tb_string_swap');
	$form = optionsframework_fields( 'options', $options, $settings, false );
	settings_errors();
	?>
	<div id="tb_string_swap">
		<div id="optionsframework" class="wrap">
		    <h2><?php _e( 'Theme Blvd String Swap', 'theme-blvd-string-swap' ); ?></h2>
			<div class="metabox-holder">
				<form id="tb_string_swap_form" action="options.php" method="post">
					<?php settings_fields('tb_string_swap_settings'); ?>
					<div class="inner-group">
						<?php echo $form[0]; ?>
					</div><!-- .group (end) -->
					 <div id="optionsframework-submit">
						<input type="submit" class="button-primary" name="update" value="<?php esc_attr_e( __( 'Save Options', 'theme-blvd-string-swap' ) ); ?>" />
			            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults' ); ?>" onclick="return confirm( '<?php print esc_js( __( 'Click OK to reset. Any theme settings will be lost!', 'theme-blvd-string-swap' ) ); ?>' );" />
			            <div class="clear"></div>
					</div>
				</form><!-- #tb_string_swap_form (end) -->
			</div><!-- .metabox-holder (end) -->
		</div> <!-- #optionsframework (end) -->
	</div><!-- #tb_string_swap (end) -->
	<?php
}

/*-----------------------------------------------------------------------------------*/
/* Filter changes on frontend
/*-----------------------------------------------------------------------------------*/

/**
 * Primary Filter
 *
 * This is the actual function that is used to add
 * the filter to "themeblvd_frontend_locals" of the
 * theme framework. Frontend only!
 */
function tb_string_swap_apply_changes( $locals ) {

	if ( ! is_admin() || ( defined('DOING_AJAX') && DOING_AJAX ) ) {

		$new_locals = get_option('tb_string_swap');

		foreach ( $locals as $id => $string ) {
			if ( isset( $new_locals[$id] ) ) {
				$locals[$id] = $new_locals[$id];
			}
		}
	}

	return $locals;
}
add_filter( 'themeblvd_frontend_locals', 'tb_string_swap_apply_changes', 999 );

/**
 * Blog Meta action
 */
function tb_string_swap_blog_meta() {

	// Grab parts
	$new_locals = get_option('tb_string_swap');
	$meta = $new_locals['blog_meta'];
	$author_string = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" rel="author">'.get_the_author().'</a>';

	// Macro replacements
	$meta = str_replace( '%date%', get_the_time( get_option('date_format') ), $meta );
	$meta = str_replace( '%author%', $author_string, $meta );
	$meta = str_replace( '%categories%', get_the_category_list(', '), $meta );

	// Display it
	echo '<div class="entry-meta">'.$meta.'</div><!-- .entry-meta (end) -->';
}

/**
 * Add/Remove actions
 *
 * Only if the user inputted something for the blog
 * meta option and after theme has been setup,
 * remove all current actions on the themeblvd_blog_meta
 * hook, and add in this one.
 */
function tb_string_swap_add_actions() {

	$new_locals = get_option('tb_string_swap');

	if ( isset( $new_locals['blog_meta'] ) && $new_locals['blog_meta'] ) {
		remove_all_actions( 'themeblvd_blog_meta' );
		add_action( 'themeblvd_blog_meta', 'tb_string_swap_blog_meta' );
	}
}
add_action( 'after_setup_theme', 'tb_string_swap_add_actions', 999 );
