<?php
/*
Plugin Name: WP Doc Admin
Plugin URI: https://www.tonek.se
Description: This plugin let you add documentation for the backend
Version: 0.2
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

add_action('admin_menu', 'register_my_custom_submenu_page');

function register_my_custom_submenu_page() {
    add_submenu_page(
        'tools.php',
        'Submenu Page',
        'WP Doc Admin',
        'manage_options',
        'wp-doc-admin-submenu-page',
        'wp_doc_admin_page_content' );
}

function wp_doc_admin_page_content() {
    echo '<div class="wrap">';
        echo '<h2>Page Title</h2>';
    echo '</div>';
}




//add_management_page( 'Custom Permalinks', 'Custom Permalinks', 'manage_options', 'my-unique-identifier', 'custom_permalinks_options_page' );


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
#  print '</div>'; 470 1450

$arrDocAdminContent = array (
  'title' => "WP Doc Admin",
  'pages' => array (
    'Coffee' => array (
      //'title'     => 'Coffee',
      'text'      => '<h2>title here</h2><p>Some text here Coffe</p>'
    ),
    'Tea' => array(
      //'title'     => 'Tea',
      'text'      => 'Some text here Tea',
      'Black' => array (
        //'title'     => 'Black tea',
        'text'    => 'Sub text Black tea'
      ),
      'Green' => array (
        //'title'     => 'Green tea',
        'text'    => 'Sub text Green tea'
      ),
    ),
    'Milk' => array (
      //'title'     => 'Milk',
      'text'      => 'Some text here Milk'
    )
  )
);

$firstKey = array_key_first($arrDocAdminContent['pages']);


$breadcrumb[] = array('url'=>'home','title'=>$arrDocAdminContent['title']);
$firstpage = $arrDocAdminContent['pages'][$firstKey];
$breadcrumb[] = array('url'=>$firstKey,'title'=>$firstKey);
?>
<script>
 var wp_doc_admin_data = '<?php print json_encode($arrDocAdminContent); ?>';
</script>
<div id="wp-doc-admin-modal" class="wp-doc-admin-modal">
  <!-- Modal content -->
  <div class="wp-doc-admin-modal-content">
    <span class="close">&times;</span>
    <div class="wp-doc-admin-wrapper">
      <div class="wp-doc-admin-left-column">
        <h3><?php print $arrDocAdminContent['title'];?></h3>
        <?php
        print "<ul>";
        foreach ($arrDocAdminContent['pages'] as $key => $value) {
          if ($firstKey == $key) { $class = "active";} else {$class ="";}
          if (is_array($value) && count($value)>1) { $class.= "has_children"; }
          print "<li class=\"wp-doc-admin-pages $class\" id=\"wp-doc-admin-pages-". strtolower(str_replace(" ","-",$key)) . "\"><a href=\"javascript:wp_doc_admin_goto('{$key}');\">{$key}</a>";
          if (is_array($value) && count($value)>1) {
            print "<ul>";
            foreach ($value as $subkey => $subvalue) {
              if ($subkey == "text") { continue;}
              print "<li class=\"wp-doc-admin-pages wp-doc-admin-hidden is_children\" id=\"wp-doc-admin-pages-". strtolower(str_replace(" ","-",$subkey)) . "\"><a href=\"javascript:wp_doc_admin_goto('{$subkey}');\">{$subkey}</a>";
              print "</li>";
            }
            print "</ul>";
          }
          print "</li>";
        }
        print "</ul>";
        ?>
      </div>
      <div class="wp-doc-admin-right-column">
        <div class="breadcrumbs">
          <?php
            $strBreadcrumb ="";
            foreach ($breadcrumb as $key => $value) {
              //print $value;
              // code...
              $strBreadcrumb.= "<a href=\"javascript:wp_doc_admin_goto('" . $value['url'] . "');\">" . $value['title'] . "</a> &gt;";
            }
            print substr($strBreadcrumb,0,-4);
          ?>
        </div>
        <div id="wp-doc-admin-content">
          <?php print $firstpage['text'];?>
        </div>
      </div>
    </div>
    <div class="wp-doc-admin-footer">
      Powered by <a href="https://www.tonek.se" target="_blank"><strong>WP Doc Admin</strong></a>
      <span>v.<?php print get_file_data( ABSPATH .'wp-content/plugins/wp-doc-admin/wp-doc-admin.php', array('Version'), 'plugin')[0]; ?></span>
    </div>
  </div>
</div>
<?php
}

/*function remove_footer_admin () {
  echo 'My footer text. Thank you WordPress for giving me this filter.';
}*/
#add_filter('admin_footer_text', 'wp_doc_modal');
