<?php

/**
 * @file
 * Contains \Drupal\sandbox\Form\SandFormController.
 */

namespace Drupal\sandbox\Form;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityFormController;

class SandFormController extends EntityFormController {
  /**
   * {@inheritdoc}
   */
  public function form(array $form, array &$form_state) {
    $form = parent::form($form, $form_state);
    $sand = $this->entity;
    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $sand->label(),
      '#description' => $this->t("Label for the Sand particle."),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $sand->id(),
      '#machine_name' => array(
        'exists' => 'sand_load',
      ),
      '#disabled' => !$sand->isNew(),
    );
    $form['color'] = array(
      '#type' => 'color',
      '#title' => $this->t('Color'),
      '#default_value' => $sand->color,
    );
    // You will need additional form elements for your custom properties.
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, array &$form_state) {
    $sand = $this->entity;
    $status = $sand->save();
    if ($status) {
      drupal_set_message($this->t('Saved the %label Sand particle.', array(
        '%label' => $sand->label(),
      )));
    }
    else {
      drupal_set_message($this->t('The %label Sand particle was not saved.', array(
        '%label' => $sand->label(),
      )));
    }
    $form_state['redirect'] = 'admin/config/system/sand';
  }

  /**
   * {@inheritdoc}
   */
  public function delete(array $form, array &$form_state) {
    $destination = array();
    $request = $this->getRequest();
    if ($request->query->has('destination')) {
      $destination = drupal_get_destination();
      $request->query->remove('destination');
    }
    $form_state['redirect'] = array('admin/config/system/sand/' . $this->entity->id() . '/delete', array('query' => $destination));
  }
}