<?php
/*
Plugin Name: Libsyn Download Count
Plugin URI: http://www.lonemill.com
Description: Gets the current months download count from Libsyn for a specified show
Version: 1.0
Author: Cory Pratt
Author URI: http://www.lonemill.com
License:
*/

add_action('admin_init', 'libsynoptions_init');
add_action('admin_menu', 'libsynoptions_add_page');

// Init plugin with options
function libsynoptions_init() {
  register_setting( 'libsynoptions_options', 'libsynoption', 'libsynoptions_validate' );
}

// Add menu page
function libsynoptions_add_page() {
  add_menu_page( 'Libsyn Download Count',
                                  'Libsyn Count',
                                  'manage_options',
                                  'libsynoptions',
                                  'libsynoptions_do_page',
                                  'dashicons-performance',
                                  81);
}

// Draw the menu page itself
function libsynoptions_do_page() {
  ?>
  <div class="wrap">
    <h2>Libsyn Count Numbers</h2>
    <p>Enter a Libsyn show ID</p>
    <form method="post" action="options.php">
      <?php settings_fields('libsynoptions_options'); ?>
      <?php $options = get_option('libsynoption'); ?>
      <table class="form-table">
        <tr valign="top"><th scope="row">Show ID</th>
          <td><input name="libsynoption[id]" type="number" value="<?php echo $options['id']; ?>" /></td>
        </tr>
      </table>
      <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
      </p>
    </form>
  </div>
  <?php 
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function libsynoptions_validate($input) {  
  return $input;
}

if ( ! is_admin() ) {
     include( plugin_dir_path( __FILE__ ) . 'templates/libsyn-getcounts.php');
} else {
}

