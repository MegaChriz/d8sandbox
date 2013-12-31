<?php

/**
 * @file
 * Contains \Drupal\status_update\StatusUpdateFormController.
 */

namespace Drupal\sandbox;

use Drupal\Component\Utility\String;
use Drupal\Core\Entity\ContentEntityFormController;
use Drupal\Core\Language\Language;

/**
 * Form controller for the status update edit forms.
 */
class CompanyFormController extends ContentEntityFormController {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, array &$form_state) {
    /**
     * @var \Drupal\sandbox\Entity\Company $company
     */
    $company = $this->entity;

    if (!$company->isNew()) {
      // We need to set the title manually in this case.
      drupal_set_title(t('Edit company <em>@title</em>', array('@title' => $company->label())), PASS_THROUGH);
    }
    else {
      drupal_set_title(t('Create new company'), PASS_THROUGH);
    }

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#maxlength' => 60,
      '#default_value' => $company->name->value,
    );
    $form['kvk'] = array(
      '#type' => 'textfield',
      '#title' => t('KvK number'),
      '#maxlength' => 60,
      '#default_value' => $company->kvk->value,
    );

    return parent::form($form, $form_state, $company);
  }

  /**
   * Overrides Drupal\Core\Entity\EntityFormController::save().
   */
  public function save(array $form, array &$form_state) {
    $insert = $this->entity->isNew();

    $this->entity->save();

    if ($insert) {
      drupal_set_message(t('Company %name has been created.', array('%name' => $this->entity->label())));
    }
    else {
      drupal_set_message(t('Company %name has been updated.', array('%name' => $this->entity->label())));
    }

    if ($insert) {
      // Go to home page.
      $form_state['redirect'] = array('');
    }
    else {
      $form_state['redirect'] = array('sandbox/company/' . $this->entity->id() . '/edit');
    }
  }

  /**
   * Overrides Drupal\Core\Entity\EntityFormController::delete().
   */
  public function delete(array $form, array &$form_state) {
    $destination = array();
    $query = \Drupal::request()->query;
    if ($query->has('destination')) {
      $destination = drupal_get_destination();
      $query->remove('destination');
    }
    $form_state['redirect'] = array('sandbox/company/' . $this->entity->id() . '/delete', array('query' => $destination));
  }
}
