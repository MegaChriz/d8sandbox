<?php

/**
 * @file
 * Contains \Drupal\sandbox\Controller\SandListController.
 */

namespace Drupal\sandbox\Controller;

use Drupal\Core\Config\Entity\ConfigEntityListController;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Sand particle.
 */
class SandListController extends ConfigEntityListController {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = $this->t('Sand particle');
    $header['id'] = $this->t('Machine name');
    $header['color'] = $this->t('Color');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $this->getLabel($entity);
    $row['id'] = $entity->id();
    $row['color'] = $entity->color;
    return $row + parent::buildRow($entity);
  }
}