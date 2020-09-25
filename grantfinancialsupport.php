<?php

require_once 'grantfinancialsupport.civix.php';
use CRM_GrantFinancialSupport_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function grantfinancialsupport_civicrm_config(&$config) {
  _grantfinancialsupport_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function grantfinancialsupport_civicrm_xmlMenu(&$files) {
  _grantfinancialsupport_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function grantfinancialsupport_civicrm_install() {
  $menus = [
    'Grant Programs',
    'Grant Payment',
    'Find Grant Payments',
    'Grant Payment Reprint',
    'New Grant Program',
  ];
  foreach ($menus as $menu) {
    $navs = CRM_Utils_Array::collect('id', civicrm_api3('Navigation', 'get', ['name' => $menu, 'sequential' => 1])['values']);
    foreach ($navs as $id) {
      civicrm_api3('Navigation', 'create', ['id' => $id, 'is_active' => FALSE]);
    }
  }
  _grantfinancialsupport_civix_civicrm_install();
}

function grantfinancialsupport_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Grant_Form_Grant' && ($form->getVar('_action') != CRM_Core_Action::DELETE)) {
    $grantStatuses = CRM_Core_OptionGroup::values('grant_status');
    foreach ($grantStatuses as $id => $status) {
      if ($status != ts('Paid')) {
        unset($grantStatuses[$id]);
      }
    }
    $form->add('select', 'status_id', ts('Grant Status'), $grantStatuses, TRUE);
    $form->setDefaults(['grant_program_id' => 1]);
    $form->add('text', 'amount_granted', ts('Amount Granted'),'', TRUE);
    $form->addRule('amount_granted', ts('Please enter a valid amount.'), 'money');
    $form->assign('showFields', TRUE);

    CRM_Core_Resources::singleton()->addScript(
    "CRM.$(function($) {
      $('.crm-grant-form-block-grant_program_id').hide();
    });"
  );
  }
}

function grantfinancialsupport_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if ($formName == 'CRM_Grant_Form_Grant' && !empty($errors['check_number'])) {
    unset($errors['check_number']);
  }
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function grantfinancialsupport_civicrm_postInstall() {
  _grantfinancialsupport_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function grantfinancialsupport_civicrm_uninstall() {
  _grantfinancialsupport_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function grantfinancialsupport_civicrm_enable() {
  _grantfinancialsupport_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function grantfinancialsupport_civicrm_disable() {
  _grantfinancialsupport_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function grantfinancialsupport_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _grantfinancialsupport_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function grantfinancialsupport_civicrm_managed(&$entities) {
  _grantfinancialsupport_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function grantfinancialsupport_civicrm_caseTypes(&$caseTypes) {
  _grantfinancialsupport_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function grantfinancialsupport_civicrm_angularModules(&$angularModules) {
  _grantfinancialsupport_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function grantfinancialsupport_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _grantfinancialsupport_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function grantfinancialsupport_civicrm_entityTypes(&$entityTypes) {
  _grantfinancialsupport_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function grantfinancialsupport_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function grantfinancialsupport_civicrm_navigationMenu(&$menu) {
  _grantfinancialsupport_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _grantfinancialsupport_civix_navigationMenu($menu);
} // */
