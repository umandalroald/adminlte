<?php

/**
 * Implement hook_preprocess_html()
 */
function adminlte_preprocess_html(&$variables) {
  $variables['classes_array'][] = 'hold-transition skin-blue sidebar-mini';
}

/**
 * Implement hook_init()
 */
function adminlte_init() {
  $theme_path = drupal_get_path('theme', $GLOBALS['theme']);
  drupal_add_css('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', 'external');
  drupal_add_css('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css', 'external');
  drupal_add_js($theme_path . '/dist/js/app.min.js', array('type' => 'file', 'scope' => 'footer'));
}

/**
 * Implement hook_preprocess_page()
 */
function  adminlte_preprocess_page(&$vars, $hook) {
  global $user;
  global $base_url;

  $vars['front_page'] = $base_url;
  $theme_path = drupal_get_path('theme', 'adminlte');

  if (true) {
    // jQuery 2.1.4
    drupal_add_js($theme_path . '/plugins/jQuery/jQuery-2.1.4.min.js', array('type' => 'file', 'scope' => 'footer'));
    // Bootstrap 3.3.5
    drupal_add_js($theme_path . '/bootstrap/js/bootstrap.min.js', array('type' => 'file', 'scope' => 'footer'));
    // jQuery UI
    drupal_add_js('https://code.jquery.com/ui/1.11.4/jquery-ui.min.js', array('type' => 'external', 'scope' => 'footer'));
    // FastClick
    drupal_add_js($theme_path . '/plugins/fastclick/fastclick.min.js', array('type' => 'file', 'scope' => 'footer'));
    // AdminLTE App
    drupal_add_js($theme_path . '/dist/js/app.min.js', array('type' => 'file', 'scope' => 'footer'));
    // Moment
    drupal_add_js('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js', array('type' => 'external', 'scope' => 'footer'));
    // Fullcalendar
    drupal_add_js($theme_path . '/plugins/fullcalendar/fullcalendar.min.js', array('type' => 'file', 'scope' => 'footer'));
    // Additional js for theme.
    drupal_add_js($theme_path . '/assets/js/script.js', array('type' => 'file', 'scope' => 'footer'));
  }

  $vars['logout'] = '/user/logout';
  $vars['profile'] = drupal_get_path_alias('profile-main/' . $user->uid);
  $roles = end($user->roles);
  $vars['role'] = ucfirst($roles);
  reset($user->roles);
  // Create custom variable for page tpl
  if(user_is_logged_in()) {
    $account = user_load($user->uid);

    $alt = t("@user's picture", array('@user' => format_username($user)));

    if(!empty($account->picture)) {
      $user_picture = theme('image_style', array('style_name' => 'thumbnail', 'path' => $account->picture->uri, 'alt' => $alt, 'title' => $alt, 'attributes' => array('class' => 'img-circle')));
      $user_picture_m = theme('image_style', array('style_name' => 'thumbnail', 'path' => $account->picture->uri, 'alt' => $alt, 'title' => $alt, 'attributes' => array('class' => 'user-image')));
    }
    else {
      $user_picture = theme('image_style', array('style_name' => 'thumbnail', 'path' => $image_path, 'alt' => $alt, 'title' => $alt, 'attributes' => array('class' => 'img-circle')));
      $user_picture_m = theme('image_style', array('style_name' => 'thumbnail', 'path' => $image_path, 'alt' => $alt, 'title' => $alt, 'attributes' => array('class' => 'user-image')));
    }

    $vars['avatar'] = $user_picture;
    $vars['avatarsm'] = $user_picture_m;
    $vars['history'] = 'Member for ' . format_interval(time() - $user->created);
    $fullname = array(
      'firstname' => isset($profile->field_firstname['und']) ? $profile->field_firstname['und'][0]['value'] : '',
      'lastname' => isset($profile->field_lastname['und']) ? $profile->field_lastname['und'][0]['value'] : '',
    );

    $vars['fullname'] = implode($fullname, ' ');
  }
}

/**
 * Implement theme_button().
 */
function adminlte_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'form-' . $element['#button_type'];
  $element['#attributes']['class'][] = 'btn btn-block btn-primary';

  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/**
 * Implement theme_textfield()
 */
function adminlte_textfield($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'text';
  element_set_attributes($element, array('id', 'name', 'value', 'size', 'maxlength'));
  _form_set_class($element, array('form-text', 'form-control'));

  $extra = '';
  if ($element['#autocomplete_path'] && !empty($element['#autocomplete_input'])) {
    drupal_add_library('system', 'drupal.autocomplete');
    $element['#attributes']['class'][] = 'form-autocomplete';

    $attributes = array();
    $attributes['type'] = 'hidden';
    $attributes['id'] = $element['#autocomplete_input']['#id'];
    $attributes['value'] = $element['#autocomplete_input']['#url_value'];
    $attributes['disabled'] = 'disabled';
    $attributes['class'][] = 'autocomplete';
    $extra = '<input' . drupal_attributes($attributes) . ' />';
  }

  $output = '<input' . drupal_attributes($element['#attributes']) . ' />';

  return $output . $extra;
}

/**
 * Implement theme_password()
 */
function adminlte_password($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'password';
  element_set_attributes($element, array('id', 'name', 'size', 'maxlength'));
  _form_set_class($element, array('form-text', 'form-control'));

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}

/**
 * Implement theme_preprocess_views_view_table()
 */
function adminlte_preprocess_views_view_table(&$vars) {
  $vars['classes_array'][] = 'table table-bordered table-striped dataTable';
}

/**
 * Implement theme_select()
 */
function adminlte_select($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'size'));
  _form_set_class($element, array('form-select', 'form-control'));

  return '<select' . drupal_attributes($element['#attributes']) . '>' . form_select_options($element) . '</select>';
}

/**
 * Implement theme_menu_tree()
 */
 /*
function  adminlte_menu_tree($variables) {
  return '<ul class="menu">' . $variables['tree'] . '</ul>';
}
*/

/**
 * Customize specific menu -  menu
 */
function adminlte_menu_tree__menu_navigation_menu($variables) {
  global $level;
  $class = ($level == 1) ? 'sidebar-menu' : 'treeview-menu';
  $main_navigation = ($level == 1) ? '<li class="header">MAIN NAVIGATION</li>' : '';

  return '<ul class="' . $class . '">' . $main_navigation . $variables['tree'] . '</ul>';
}

/**
 * Implement theme_menu_link()
 */
function adminlte_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
  global $level;
  // Add treeview class
  if ($element['#below']) {
    $element['#attributes']['class'][0] = 'treeview';
    unset($element['#attributes']['class'][1]);
    $sub_menu = drupal_render($element['#below']);
    $level = 1;
  }
  else {
    $level = $element['#original_link']['depth'];
  }
  // Add active class in selected menu
  if($element['#original_link']['in_active_trail'] == TRUE) {
    $element['#attributes']['class'][] = 'active';
  }

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implement theme_link()
 */
function adminlte_link($variables) {
  global $level;
  $icon = '';
  // Add arrow
  if($level == 1 && $variables['path'] == '<front>') {
    $icon = '<i class="fa fa-angle-left pull-right"></i>';
  }

  $title = ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text']));
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '">' . '<i' . drupal_attributes($variables['options']['attributes']) . '></i><span>' . $title . '</span>' . $icon . '</a>';
}

/**
 * Implement  theme_menu_local_tasks()
 */
function adminlte_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul class="nav nav-tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    foreach ($variables['primary'] as $key => $link) {
      if (is_array($link)) {
        if ($link['#link']['path'] == 'user/%/view') {
          $variables['primary'][$key]['#link']['title'] = 'Basic Information';
        }
        if ($link['#link']['path'] == 'user/%/edit') {
          $variables['primary'][$key]['#link']['title'] = 'Settings';
        }
      }
    }
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}

/**
 * Implement theme_status_messages()
 */
function adminlte_status_messages($variables) {
  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );

  foreach (drupal_get_messages($display) as $type => $messages) {

    switch ($type) {
      case 'error':
        $class = 'alert alert-danger alert-dismissible';
        $icon = '<i class="icon fa fa-ban"></i>';
        break;
      case 'status':
        $class = 'alert alert-success alert-dismissible';
        $icon = '<i class="icon fa fa-check"></i>';
        break;
      case 'warning':
        $class = 'alert alert-warning alert-dismissible';
        $icon = '<i class="icon fa fa-warning"></i>';
        break;
      default:
        # code here
        break;
    }

    $output .= "<div class='box-body'>";
    $output .= "<div class=\"$class\">\n";
    if (!empty($status_heading[$type])) {
      $output .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
      //$output .= '<h4>' . $icon . ' ' . $status . '</h4>';
    }
    if (count($messages) > 1) {
      $output .= " <div>\n";
      foreach ($messages as $message) {
        $output .= '  <span>' . $icon . ' ' . $message . "</span>\n";
      }
      $output .= " </div>\n";
    }
    else {
      $output .= $icon;
      $output .= reset($messages);
    }
    $output .= "</div>";
    $output .= "</div>\n";
  }
  return $output;
}

/**
 * Implements preprocess_table__field_collection_table()
 */
function adminlte_preprocess_table__field_collection_table(&$vars) {
  // Modify created > date
  if(arg(1) == 'request-item') {
    $vars['header'][0]['data'] = 'Date';
  }

  // Add a new (blank) header
  array_unshift($vars['header'], '&nbsp;');
  $vars['attributes']['class'][0] = 'views-table cols-24 table table-bordered table-striped dataTable';
  // Add an incremental count to each row
  $count = 1;
  foreach ($vars['rows'] as $key => &$row) {
    array_unshift($row['data'], $count++);
  }
}

/*
function  adminlte_preprocess_entity(&$variables) {
  $bundle = $variables['elements']['#entity']->type;
  if($bundle == 'commissary') {
    $variables['title'] = '';
    foreach($variables['theme_hook_suggestions'] as &$suggestion) {
      $suggestion = 'entity__' . $suggestion;
      dpm($suggestion);
    }
  }
}
*/

function adminlte_table($variables) {
  $header = $variables['header'];
  $rows = $variables['rows'];
  $attributes = $variables['attributes'];
  $caption = $variables['caption'];
  $colgroups = $variables['colgroups'];
  $sticky = $variables['sticky'];
  $empty = $variables['empty'];

  // Add sticky headers, if applicable.
  if (count($header) && $sticky) {
    drupal_add_js('misc/tableheader.js');
    // Add 'sticky-enabled' class to the table to identify it for JS.
    // This is needed to target tables constructed by this function.
    $attributes['class'][] = 'sticky-enabled';
  }

  if(current_path() == 'manage-employee' || current_path() == 'administer-employee') {
    $attributes = $variables['attributes'] = array('class' => 'cols-24 table table-bordered table-striped dataTable');
  }

  $output = '<table' . drupal_attributes($attributes) . ">\n";

  if (isset($caption)) {
    $output .= '<caption>' . $caption . "</caption>\n";
  }

  // Format the table columns:
  if (count($colgroups)) {
    foreach ($colgroups as $number => $colgroup) {
      $attributes = array();

      // Check if we're dealing with a simple or complex column
      if (isset($colgroup['data'])) {
        foreach ($colgroup as $key => $value) {
          if ($key == 'data') {
            $cols = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $cols = $colgroup;
      }

      // Build colgroup
      if (is_array($cols) && count($cols)) {
        $output .= ' <colgroup' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cols as $col) {
          $output .= ' <col' . drupal_attributes($col) . ' />';
        }
        $output .= " </colgroup>\n";
      }
      else {
        $output .= ' <colgroup' . drupal_attributes($attributes) . " />\n";
      }
    }
  }

  // Add the 'empty' row message if available.
  if (!count($rows) && $empty) {
    $header_count = 0;
    foreach ($header as $header_cell) {
      if (is_array($header_cell)) {
        $header_count += isset($header_cell['colspan']) ? $header_cell['colspan'] : 1;
      }
      else {
        $header_count++;
      }
    }
    $rows[] = array(array('data' => $empty, 'colspan' => $header_count, 'class' => array('empty', 'message')));
  }

  // Format the table header:
  if (count($header)) {
    $ts = tablesort_init($header);
    // HTML requires that the thead tag has tr tags in it followed by tbody
    // tags. Using ternary operator to check and see if we have any rows.
    $output .= (count($rows) ? ' <thead><tr>' : ' <tr>');
    foreach ($header as $cell) {
      $cell = tablesort_header($cell, $header, $ts);
      $output .= _theme_table_cell($cell, TRUE);
    }
    // Using ternary operator to close the tags based on whether or not there are rows
    $output .= (count($rows) ? " </tr></thead>\n" : "</tr>\n");
  }
  else {
    $ts = array();
  }

  // Format the table rows:
  if (count($rows)) {
    $output .= "<tbody>\n";
    $flip = array('even' => 'odd', 'odd' => 'even');
    $class = 'even';
    foreach ($rows as $number => $row) {
      // Check if we're dealing with a simple or complex row
      if (isset($row['data'])) {
        $cells = $row['data'];
        $no_striping = isset($row['no_striping']) ? $row['no_striping'] : FALSE;

        // Set the attributes array and exclude 'data' and 'no_striping'.
        $attributes = $row;
        unset($attributes['data']);
        unset($attributes['no_striping']);
      }
      else {
        $cells = $row;
        $attributes = array();
        $no_striping = FALSE;
      }
      if (count($cells)) {
        // Add odd/even class
        if (!$no_striping) {
          $class = $flip[$class];
          $attributes['class'][] = $class;
        }

        // Build row
        $output .= ' <tr' . drupal_attributes($attributes) . '>';
        $i = 0;
        foreach ($cells as $cell) {
          $cell = tablesort_cell($cell, $header, $ts, $i++);
          $output .= _theme_table_cell($cell);
        }
        $output .= " </tr>\n";
      }
    }
    $output .= "</tbody>\n";
  }

  $output .= "</table>\n";
  return $output;
}

/**
 * Implement hook_preprocess_views_view()
 */
function adminlte_preprocess_views_view(&$variables) {
  $function_name = __FUNCTION__ . '__' . $variables['view']->name;
  if (function_exists($function_name)) {
    $function_name($variables);
  }
}
