<?php 

/*
Plugin Name: HeroWP Custom Login Image
Description: Change your wordpress login image/logo with your own
Version: 1.0
Author: HeroWP
Author URI: https://herowp.com
*/

/**
*
* We define the path and dir of plugin
*
*/
if(!defined('HEROWP_ABS_PATH')) define( 'HEROWP_ABS_PATH', plugin_dir_path(__FILE__) );
if(!defined('HEROWP_ABS_DIR')) define( 'HEROWP_ABS_DIR', plugin_dir_url(__FILE__) );

/**
*
* Begining of class herowp_change_login_logo 
*
*/
class HeroWP_Login_Page_Options{

	
	function __construct(){
	
		add_action( 'admin_menu', array(&$this,'herowp_register_menu_page'));
		add_action( 'login_enqueue_scripts', array(&$this,'herowp_custom_login_logo'));
		add_action( 'admin_enqueue_scripts', array(&$this,'herowp_admin_add_scripts'));
		add_action( 'admin_init', array(&$this,'herowp_register_options_group'));
		
	}


	/**
	*
	* We register the page in the menu
	*
	*/
	function herowp_register_menu_page(){
	
		add_menu_page( 'Change Admin Login Logo', 'Admin Logo', 'manage_options', 'change_login_logo', array(&$this,'herowp_create_settings_page'), HEROWP_ABS_DIR.'images/icon.png', 99 );
	
	}
	
	
	/**
	*
	* We enqueue the required scripts
	*
	*/	
	function herowp_admin_add_scripts() {
	
		wp_enqueue_media();
        wp_register_script( 'uploader', HEROWP_ABS_DIR.'js/uploader.js', array('jquery'));
        wp_enqueue_script( 'uploader' );
		
	}
	
	
	/**
	*
	* We register the options
	*
	*/	
	function herowp_register_options_group() {
		
		register_setting( 'herowp-login-options-group', 'herowp_login_image');
		register_setting( 'herowp-login-options-group', 'herowp_bg_width');
		register_setting( 'herowp-login-options-group', 'herowp_bg_height');
		
	}


	/**
	*
	* We create the settings page
	*
	*/
	function herowp_create_settings_page(){?>
			
			<form method="post" action="options.php"><!--START THE FORM-->
				
				<?php settings_fields( 'herowp-login-options-group' ); ?>
				
				<h2><?php _e( 'Change Admin Logo', 'customize-login-image' ); ?></h2>
				
				<?php if( isset($_GET['settings-updated']) ) { ?>
					<div id="message" class="updated">
						<p><strong><?php _e('Settings saved.') ?></strong></p>
					</div>
				<?php } ?>
				
				<table class="form-table"><!--START TABLE-->
				
					<tr valign="top">
						<th scope="row"><?php _e( 'Admin logo', 'herowp-custom-login-image' ); ?></th>
							<td>
								<label for="upload_image">
									<input id="upload_image" type="text" size="36" name="herowp_login_image" value="<?php echo get_option('herowp_login_image'); ?>" /> 
									<input id="upload_image_button" class="button" type="button" value="Upload Image" />
									<br />Enter a URL or upload an image
								</label>
							</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><?php _e( 'Logo width.', 'herowp-custom-login-image' ); ?></th>
						<td><label for="herowp_bg_width">
							<input type="text" id="herowp_bg_width" size="36" name="herowp_bg_width" value="<?php echo get_option( 'herowp_bg_width' ); ?>" />
							<p class="description"><?php _e( 'Add only numbers, and no pixels. Please note that maximum width is 320px', 'herowp-custom-login-image' ); ?></p>
							</label>
						</td>
					</tr>	

					<tr valign="top">
						<th scope="row"><?php _e( 'Logo height.', 'herowp-custom-login-image' ); ?></th>
						<td><label for="herowp_bg_height">
							<input type="text" id="herowp_bg_height" size="36" name="herowp_bg_height" value="<?php echo get_option( 'herowp_bg_height' ); ?>" />
							<p class="description"><?php _e( 'Add only numbers, and no pixels.', 'herowp-custom-login-image' ); ?></p>
							</label>
						</td>
					</tr>

					<tr valign="top">
						<td>
							<a href="https://herowp.com/?ref=hero-custom-login-image" target="_blank"><img src="<?php echo HEROWP_ABS_DIR.'images/promo.png'; ?>" alt="Advertisement"></a>
						</td>
					</tr>
					
				</table>
				
				<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'herowp-custom-login-image' ); ?>" />
				</p>
			
			</form><!--END TABLE-->
			
	<?php }
	

	/**
	*
	* The function which change the logo with your own
	*
	*/
	function herowp_custom_login_logo() { ?>
		
		<?php
			
			//if no custom width is defined we add the default width value
			$width = get_option('herowp_bg_width');
			if ($width == ''){
				$width = 84; 
			}
			
			//if no custom height is defined we add the default height value
			$height = get_option('herowp_bg_height');
			if ($height == ''){
				$height = 84;
			}
			
		?>
		
		<?php if (get_option('herowp_login_image') != '') : ?>
			<style type="text/css">
				body.login div#login h1 a {
					background-image: url(<?php echo get_option('herowp_login_image'); ?>);
					padding-bottom: 30px;
					background-size: cover;
					width:<?php echo $width; ?>px;
					height:<?php echo $height; ?>px;
				}
			</style>
		<?php endif; ?>
		
	<?php }

}

global $call_class_hero;
$call_class_hero = new HeroWP_Login_Page_Options;

?>