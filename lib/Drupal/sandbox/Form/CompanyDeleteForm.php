<?php

/**
 * @file
 * Contains \Drupal\status_update\Form\BlockDeleteForm.
 */

namespace Drupal\sandbox\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;

/**
 * Provides a deletion confirmation form for the status update instance deletion form.
 */
class CompanyDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the company %name?', array('%name' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return array(
      'route_name' => 'sandbox_company.edit',
      'route_parameters' => array('sandbox_company' => $this->entity->id()),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {
    $this->entity->delete();
    watchdog('content', 'Company %name deleted.', array('%name' => $this->entity->label()));
    drupal_set_message($this->t('The company %name has been deleted.', array('%name' => $this->entity->label())));
    $form_state['redirect'] = '';
  }

}