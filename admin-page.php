<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// Include the Responsivity Tool API
require_once( dirname(__file__).'/viewer/responsivity-class.php' );
$responsivity = new ResponsivityTool();
?>

<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>


    <?php

	$tool_url = plugin_dir_url( __FILE__ )."viewer/";
	if ( get_page_by_path( 'responsivity' ) ) $tool_url = home_url("responsivity");

	$responsivity->print_form($tool_url, "_blank");

	?><br/>


    <h2>Access</h2>

		<form method="post" action="options.php" id="responsivity-ajax-option-save" enctype="multipart/form-data">
			<?php settings_fields( 'responsivity_settings' ); ?>
			<?php do_settings_sections( 'responsivity_settings' ); ?>

	    	<label for="responsivity_public">
		    	<input type="checkbox" id="responsivity_public" name="responsivity_public" value="true" <?=$this->responsivity_public ? "checked" : ""?>> Allow public access
	    	</label><br/><br/><br/>

		</form>

</div>