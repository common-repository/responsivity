<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class ResponsivityViewer {

	var $responsivity_public;
	var $responsivity_page;


	function __construct() {

		// Frontend
		if ( !is_admin() )
			$this->frontend_functions();


		// Backend
		if ( is_admin() )
			$this->backend_functions();


		// CALL THE EXISTING OPTIONS
		$this->responsivity_public = get_option( 'responsivity_public', false );

	}

	function frontend_functions() {

		// Responsivity Page
		add_filter( 'page_template', array($this, 'template') );


		// If site is in Responsivity Tool frames
		if ( isset($_GET['responsivity_frame']) && $_GET['responsivity_frame'] ) {

			// Hide the admin bar
			add_action('init', array($this, 'remove_adminbar'));


			// Don't show the site if no access
			add_action('init', function() {

				if ( !$this->responsivity_public && !current_user_can('administrator') )
					wp_die("You don't have access to see this page.");

			});


		}


	}

	function remove_adminbar() {

		show_admin_bar(false);
		add_filter('show_admin_bar', '__return_false'); // CHECK THIS !!!

		// Remove the admin bar margins
		add_action('get_header', function() {

			remove_action('wp_head', '_admin_bar_bump_cb');

		});

	}

	function template($page_template) {

	    if ( is_page( 'responsivity' ) ) {
	        $page_template = dirname( __FILE__ ) . '/viewer/index.php';
	    }

	    return $page_template;
	}

	function backend_functions() {


		// TOOLS MENU
		add_action( 'admin_menu', array($this, 'toolsMenu') );


		// PLUGINS PAGE LINK
		add_filter('plugin_action_links', array($this, 'plugins_page_link'), 2, 2 );


		// CALL THE JAVASCRIPT AND CSS FILES
		add_action( 'admin_enqueue_scripts', array($this, 'css_js') );


		// REGISTER SETTINGS
		add_action('admin_init', array($this,'register_settings') );


	}


	// PLUGINS PAGE LINK
	function plugins_page_link($actions, $file) {

		if(false !== strpos($file, 'responsivity') && current_user_can('administrator'))
			$actions['settings'] = '<a href="tools.php?page=responsivity">Settings</a>';

		return $actions;

	}


	// TOOLS MENU
	function toolsMenu() {

		$this->responsivity_page = add_submenu_page(
			'tools.php',					// admin page slug
			'Responsivity Viewer',  		// page title
			'Responsivity', 				// menu title
			'administrator',        		// capability required to see the page
			'responsivity',         		// admin page slug, e.g. options-general.php?page=amr_options
			array($this, 'adminPage')	// callback function to display the options page
		);

	}


	// ADMIN PAGE
	function adminPage() {

		require_once( dirname(__file__).'/admin-page.php' );

	}


	// STYLE AND SCRIPT
	function css_js($hook) {

		if( $hook != $this->responsivity_page ) { return; }

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-form' );
		wp_enqueue_script( 'responsivity-js', plugin_dir_url( __FILE__ ) .'script.js', array('jquery'), '1.0.0', true);

		wp_register_style( 'responsivity-css', plugin_dir_url( __FILE__ ) .'style.css', false, '1.0.0' );
		wp_enqueue_style( 'responsivity-css' );

	}


	// REGISTER SETTINGS
	function register_settings() {

		register_setting( 'responsivity_settings' , 'responsivity_public' );

	}


}

?>