<?php

drupal_static_reset('element_info');

/**
 * Implements hook_js_alter().
 */
function adminlte_js_alter(&$js) {
  $theme_path = drupal_get_path('theme', 'adminlte');
  // Ensure jQuery Once is always loaded.
  // @see https://drupal.org/node/2149561
  if (empty($js['misc/jquery.once.js'])) {
    $jquery_once = drupal_get_library('system', 'jquery.once');
    $js['misc/jquery.once.js'] = $jquery_once['js']['misc/jquery.once.js'];
    $js['misc/jquery.once.js'] += drupal_js_defaults('misc/jquery.once.js');
  }
}

/**
 * Implement theme_item_list().
 */
function adminlte_item_list($variables) {
}

/**
 * Implement theme_menu_link().
 */
function adminlte_menu_link($variables) {
  $element = $variables['element'];
  $sub_menu = '';
  $output = '';
  $icon = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  if(in_array('expanded', $element['#attributes']['class'])) {
    switch($element['#title']) {
      case 'Store':
          $output .= '<i class="fa fa-home"></i>';
        break;
      case 'Request':
          $output .= '<i class="fa fa-file-text"></i>';
        break;
      case 'Employee':
          $output .= '<i class="fa fa-users"></i>';
        break;
    }
    $output .= l($element['#title'], $element['#href'], $element['#localized_options']);
    $output .= '<i class="fa pull-right fa-angle-down"></i>';
  }
  else {
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  }
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implement theme_breadcrumb().
 */
function adminlte_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  if (!empty($breadcrumb)) {
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    $output .= '<div class="breadcrumb">' . implode(' » ', $breadcrumb) . '</div>';
    return $output;
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
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}
