<?php

/**
 * @file
 * Contains \Drupal\sandbox\Entity\Sand.
 */

namespace Drupal\sandbox\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\sandbox\SandInterface;
use Drupal\Core\Field\FieldDefinition;

/**
 * Defines the Sand particle entity.
 *
 * @EntityType(
 *   id = "sand",
 *   label = @Translation("Sand particle"),
 *   controllers = {
 *     "storage" = "Drupal\Core\Config\Entity\ConfigStorageController",
 *     "list" = "Drupal\sandbox\Controller\SandListController",
 *     "view_builder" = "Drupal\sandbox\SandViewBuilder",
 *     "form" = {
 *       "default" = "Drupal\sandbox\Form\SandFormController",
 *       "add" = "Drupal\sandbox\Form\SandFormController",
 *       "edit" = "Drupal\sandbox\Form\SandFormController",
 *       "delete" = "Drupal\sandbox\Form\SandDeleteForm"
 *     }
 *   },
 *   config_prefix = "sandbox.sand",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "bundle" = "vid"
 *   },
 *   bundle_keys = {
 *     "bundle" = "vid"
 *   },
 *   bundle_entity_type = "taxonomy_vocabulary",
 *   links = {
 *     "edit-form" = "sandbox.sand_edit"
 *   }
 * )
 */
class Sand extends ConfigEntityBase implements SandInterface {
  /**
   * The Sand particle ID.
   *
   * @var string
   */
  public $id;

  /**
   * The Sand particle UUID.
   *
   * @var string
   */
  public $uuid;

  /**
   * The Sand particle label.
   *
   * @var string
   */
  public $label;

  /**
   * The taxonomy vocabulary this sand particle belongs to.
   */
  public $vid;

  /**
   * The color of the sand particle.
   */
  public $color;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions($entity_type) {
    $fields = array();

    $fields['id'] = FieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = FieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setReadOnly(TRUE);

    $fields['label'] = FieldDefinition::create('string')
      ->setLabel(t('Label'));

    $fields['color'] = FieldDefinition::create('string')
      ->setLabel(t('Color'));

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function bundle() {
    return $this->vid;
  }
}
