<?php

/**
 * @file
 * Contains \Drupal\sandbox\SandViewBuilder.
 */

namespace Drupal\sandbox;

use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a Sand view builder.
 */
class SandViewBuilder implements EntityViewBuilderInterface {

  /**
   * {@inheritdoc}
   */
  public function buildContent(array $entities, array $displays, $view_mode, $langcode = NULL) {
    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function view(EntityInterface $entity, $view_mode = 'full', $langcode = NULL) {
    $build = $this->viewMultiple(array($entity), $view_mode, $langcode);
    return reset($build);
  }

  /**
   * {@inheritdoc}
   */
  public function viewMultiple(array $entities = array(), $view_mode = 'full', $langcode = NULL) {
    $build = array();
    foreach ($entities as $entity_id => $entity) {
      $build[$entity_id] = array(
        '#type' => 'fieldset',
        '#title' => check_plain($entity->label()),
      );
      $fields = $entity->baseFieldDefinitions($entity->entityType());
      foreach ($fields as $key => $definition) {
        $build[$entity_id][$key] = array(
          '#type' => 'item',
          '#title' => $definition->getLabel(),
          '#markup' => check_plain($entity->$key),
        );
      }
    }
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function resetCache(array $ids = NULL) { }

}
