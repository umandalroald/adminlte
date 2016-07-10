<?php

function adminlte_form_system_theme_settings_alter(&$form, $form_state) {

  $form['adminlte_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('BMS AdminLTE'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['adminlte_group']['skin_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('Skin'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['adminlte_group']['layout_group'] = array(
    '#type' => 'fieldset',
    '#title' => t('Layout Options'),
    '#weight' => -20,
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['adminlte_group']['layout_group']['layout_options'] = array(
    '#type' => 'checkboxes',
    '#options' => array(
      0 => t('fixed'),
      1 => t('layout-boxed '),
      2 => t('layout-top-nav'),
      3 => t('sidebar-collapse'),
      4 => t('sidebar-mini'),
    ),
    //'#default_value' => theme_get_setting('theme_skin'),
    //'#description'   => t("Place this text in the widget spot on your site."),
  );

  $form['adminlte_group']['skin_group']['skin'] = array(
    '#type' => 'radios',
    '#options' => array(
      0 => t('skin-blue'),
      1 => t('skin-blue-light'),
      2 => t('skin-yellow'),
      3 => t('skin-yellow-light'),
      4 => t('skin-green'),
      5 => t('skin-green-light'),
      6 => t('skin-purple'),
      7 => t('skin-purple-light'),
      8 => t('skin-blue'),
      9 => t('skin-red'),
      10 => t('skin-red-light'),
      11 => t('skin-black'),
      12 => t('skin-black-light'),
    ),
    //'#default_value' => theme_get_setting('theme_skin'),
    //'#description'   => t("Place this text in the widget spot on your site."),
  );
}
