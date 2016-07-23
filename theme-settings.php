<?php

/**
 * Implement hook_form_system_theme_settings_alter()
 */
function adminlte_form_system_theme_settings_alter(&$form, $form_state) {

  $form['adminlte_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('AdminLTE Configuration'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['adminlte_group']['skin_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('Skin'),
    '#description' => t('Enable theme skin'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['adminlte_group']['layout_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('Layout Options'),
    '#description' => t('Enable theme layout'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['adminlte_group']['layout_group']['layout_options'] = array(
    '#type' => 'checkboxes',
    '#options' => array(
      'fixed' => t('fixed'),
      'layout-boxed' => t('layout-boxed'),
      'layout-top-nav' => t('layout-top-nav'),
      'sidebar-collapse' => t('sidebar-collapse'),
      //'sidebar-mini' => t('sidebar-mini'),
    ),
    '#default_value' => theme_get_setting('layout_options'),
  );

  $form['adminlte_group']['skin_group']['skin'] = array(
    '#type' => 'radios',
    '#options' => array(
      'skin-blue' => t('skin-blue'),
      'skin-blue-light' => t('skin-blue-light'),
      'skin-yellow' => t('skin-yellow'),
      'skin-yellow-light' => t('skin-yellow-light'),
      'skin-green' => t('skin-green'),
      'skin-green-light' => t('skin-green-light'),
      'skin-purple' => t('skin-purple'),
      'skin-purple-light' => t('skin-purple-light'),
      'skin-blue' => t('skin-blue'),
      'skin-red' => t('skin-red'),
      'skin-red-light' => t('skin-red-light'),
      'skin-black' => t('skin-black'),
      'skin-black-light' => t('skin-black-light'),
    ),
    '#default_value' => theme_get_setting('skin'),
  );
}
