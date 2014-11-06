<?php

add_action('admin_init', 'update_primary_shareaholic_plugin_file', 1);

function update_primary_shareaholic_plugin_file(){
  if (is_plugin_active('shareaholic/sexy-bookmarks.php')) {
    deactivate_plugins('shareaholic/sexy-bookmarks.php');
    activate_plugins('shareaholic/shareaholic.php');
  }
}

?>