<?php
/*
Plugin Name: WP Doc Admin
Plugin URI: https://www.tonek.se
Description: This plugin let you add documentation for the backend
Version: 0.1
Author: Martin Tonek
Author URI: https://www.tonek.se
*/
 
add_action( 'admin_bar_menu', 'custom_wp_toolbar_link', 999 );
 
function custom_wp_toolbar_link( $wp_admin_bar ) {
  if( current_user_can( 'level_5' ) ){

    $args = array(
      'id' => 'wp-doc',
      //'class' => 'wp-doc-btn',
      'title' => '<span class="ab-icon"></span><span class="ab-label">'.__( 'Help', 'some-textdomain' ).'</span>',
      //'href' => '#',
      'meta' => array(
        //'target' => '_self',
        'class' => 'wp-doc-admin-link',
        'title' => 'WP Doc Admin'
      )
    );
    $wp_admin_bar->add_node($args);

  }
}
 
add_action( 'admin_enqueue_scripts', 'custom_wp_toolbar_css_admin' );
//add_action( 'wp_enqueue_scripts', 'custom_wp_toolbar_css_admin' );
 
function custom_wp_toolbar_css_admin() {
  if( current_user_can( 'level_5' ) ){
    wp_register_style( 'wp_doc_admin_css', plugin_dir_url( __FILE__ ) . 'wp-doc-admin.css','','', 'screen' );
    wp_enqueue_style( 'wp_doc_admin_css' );
    wp_register_script( 'wp_doc_admin_js', plugin_dir_url( __FILE__ ) . 'wp-doc-admin.js',array(),'1.0.0', true );
    wp_enqueue_script( 'wp_doc_admin_js' );
  }
}
add_action('admin_footer', 'wp_doc_modal');
add_action('wp_footer', 'wp_doc_modal');

function wp_doc_modal()
{
#print "MARTIN ÄR EN SMURF!";
  //<!-- Trigger/Open The Modal -->
  #print '<button id="myBtn">Open Modal</button>';
  //<!-- The Modal -->
#  print '<div id="myModal" class="modal">';
  //  <!-- Modal content -->
#  print '  <div class="modal-content">';
#  print '    <span class="close">&times;</span>';
#  print '    <p>Some text in the Modal..</p>';
#  print '  </div>';
#  print '</div>';
?>
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2>Modal Header</h2>
    </div>
    <div class="modal-body">
      <p>Some text in the Modal Body</p>
      <p>Some other text...</p>
    </div>
    <div class="modal-footer">
      <h3>Modal Footer</h3>
    </div>
  </div>
</div>
<?php
}

function remove_footer_admin () {
  echo 'My footer text. Thank you WordPress for giving me this filter.';
}
#add_filter('admin_footer_text', 'wp_doc_modal');
