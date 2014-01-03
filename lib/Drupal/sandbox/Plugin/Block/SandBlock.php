<?php

/**
 * @file
 * Contains \Drupal\sandbox\Plugin\Block\SandBlock.
 */

namespace Drupal\sandbox\Plugin\Block;

use Drupal\block\BlockBase;

/**
 * Provides a 'Sand' block.
 *
 * @Block(
 *   id = "sand_block",
 *   admin_label = @Translation("Floating sand particles in a block.")
 * )
 */
class Sandblock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $query = \Drupal::entityQuery('sand');
    $query->condition('color', $this->configuration['color'], $this->configuration['color_op']);
    $result = $query->execute();
    $ops = $this->getOperators();
    $vars = array(
      '@color_op' => strtolower($ops[$this->configuration['color_op']]),
      '!color' => '<code>' . check_plain($this->configuration['color']) . '</code>',
    );
    $render['desc'] = array(
      '#markup' => $this->t('Sand particles with a color that @color_op !color:', $vars),
    );
    $render['list'] = array(
      '#theme' => 'item_list',
      '#items' => $result,
    );
    return $render;
  }

  /**
   * Overrides \Drupal\block\BlockBase::defaultConfiguration().
   */
  public function defaultConfiguration() {
    return array(
      'color' => '#',
      'color_op' => 'STARTS_WITH',
    );
  }

  /**
   * Returns available entity query operators.
   *
   * @return array
   */
  protected function getOperators() {
    return array(
      'STARTS_WITH' => $this->t('Starts with'),
      'CONTAINS' => $this->t('Contains'),
      'ENDS_WITH' => $this->t('Ends with'),
    );
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockForm().
   */
  public function blockForm($form, &$form_state) {
    $form['color'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Color'),
      '#default_value' => $this->configuration['color'],
    );
    $form['color_op'] = array(
      '#type' => 'select',
      '#title' => $this->t('Operation'),
      '#default_value' => $this->configuration['color_op'],
      '#options' => $this->getOperators(),
    );
    return $form;
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, &$form_state) {
    $this->configuration['color'] = $form_state['values']['color'];
    $this->configuration['color_op'] = $form_state['values']['color_op'];
  }

}