<?php 
/**
 * 
 * @package simply-contact
 * @version 0.2
 */
/*
Plugin Name: Simply Contact
Plugin URI:  http://www.cthreelabs.com/simply-contact.php
Tags : contact form, reCaptcha, mail form
Description: A simple and sleek contact form for your wordpress site, Powered by google reCaptcha . 
Version: 0.2
Author URI: http://www.cthreelabs.com/
license: GNU General Public License v2
*/


// Register Hook
register_activation_hook(__FILE__, 'simply_contact_plugin_activate');

// get option on activation 
function simplyContact_activate() {
	if (get_option('SimplyContact_Options') === false)
	{
	$options['to_email'] = '';
	$options['g_key_pub']='';
	$options['g_key_pri']='';
	$options['f_mail'] = '';
	$options['f_name'] = '';
	update_option('SimplyContact_Options', $options);
	}
}

// Add styles to site footer .
add_action('wp_enqueue_scripts', 'simplyContactStyle');
function simplyContactStyle() {
    wp_enqueue_style( 'Simply Contact Stylesheet', plugins_url( 'simply-contact-clean.css' , __FILE__ )); 
}

// Add Admin Menu
add_action('admin_menu', 'simplyContact_admin_menu');
function simplyContact_admin_menu() {
	global $pagehooktop;
	$pagehooktop = add_menu_page( 'Simply Contact
	General Options', 'Simply Contact', 'manage_options', 'simply-contact', 'simplyContact_show_admin');//', 
}

// Show admin
function simplyContact_show_admin() {
	 
	$options = get_option('SimplyContact_Options');

	if(isset($_POST['submit_data'])){
		check_admin_referer('simplyContact');
		$options['to_email'] = htmlspecialchars($_POST['to_email']);
		$options['g_key_pub'] = htmlspecialchars($_POST['g_key_pub'])." ";
		$options['g_key_pri'] = htmlspecialchars($_POST['g_key_pri'])." ";
		
		
		$options['g_key_pub'] = trim($options['g_key_pub']);
		$options['g_key_pri'] = trim($options['g_key_pri']);
		
		
		update_option('SimplyContact_Options', $options);
	}

	?>
	
	<h1>Simply Contact Plugin</h1>
	<hr>
		<form name="user_input" method="post" action="<?php plugins_url('contact.php',__FILE__);?>">
			<?php wp_nonce_field('simplyContact'); ?>
			
			<table>
				<tr>
					<td>
						<strong>To Mail :  </strong>
					</td>
					<td>
						<input type="text" name="to_email" value="<?php echo (isset($options['to_email']))?$options['to_email']:' ' ; ?>"/>
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<p>Enter the mail id to which the messages to be sent  </p>
						<hr>
					</td>
				</tr>
				
				
				<tr>
					<td colspan="2">
						<h4> Enter Google reCaptcha Keys</h4>
					</td>
				</tr>
				
				<tr>
					<td>
						 <strong> Public Key : </strong>
					</td>
					<td>
						<input type="text" name="g_key_pub" value="<?php echo (isset($options['g_key_pub']))?$options['g_key_pub']:' ' ;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						<strong>Private Key :  </strong>
					</td>
					<td>
						<input type="text" name="g_key_pri" value="<?php echo (isset($options['g_key_pri']))? $options['g_key_pri']:' ' ;?>"/>
						
					</td>
				</tr>
				
				
				<tr>
					<td>
						<strong>Theme : </strong>
					</td>
					<td>
						<p>Clean (Default)</p>
					</td>
				</tr>
				
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="submit" name="submit_data" value="Submit" />
					</td>
					
				</tr>
				
			</table>
			
		</form>
<?php }

add_shortcode('SC','simply_contact');
function simply_contact(){
	$dir = plugin_dir_path( __FILE__ );
	require_once($dir.'contact.php');
}

//Un install Plugin 
register_uninstall_hook(__FILE__, 'simply_contact_plugin_uninstall');
?>