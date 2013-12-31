<?php

/**
 * @file
 * Contains Drupal\sandbox\Entity\Company.
 */

namespace Drupal\sandbox\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\Core\Field\FieldDefinition;

/**
 * Defines the company entity class.
 *
 * @EntityType(
 *   id = "sandbox_company",
 *   label = @Translation("Company"),
 *   module = "sandbox",
 *   controllers = {
 *     "storage" = "Drupal\Core\Entity\FieldableDatabaseStorageController",
 *     "render" = "Drupal\Core\Entity\EntityRenderController",
 *     "form" = {
 *       "default" = "Drupal\sandbox\CompanyFormController",
 *       "delete" = "Drupal\sandbox\Form\CompanyDeleteForm"
 *     }
 *   },
 *   base_table = "sandbox_company",
 *   fieldable = TRUE,
 *   translatable = FALSE,
 *   entity_keys = {
 *     "id" = "company_id",
 *     "uuid" = "uuid",
 *     "label" = "name",
 *   },
 * )
 */
class Company extends ContentEntityBase implements ContentEntityInterface {
  /**
   * Implements Drupal\Core\Entity\EntityInterface::id().
   */
  public function id() {
    return $this->get('company_id')->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions($entity_type) {
    $fields['company_id'] = FieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the company.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = FieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The company UUID.'))
      ->setReadOnly(TRUE);

    $fields['name'] = FieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the company.'));

    $fields['kvk'] = FieldDefinition::create('string')
      ->setLabel(t('KvK number'));

    // @todo Convert to a "created" field in https://drupal.org/node/2145103.
    $fields['created'] = FieldDefinition::create('integer')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the company was created.'));

    // @todo Convert to a "changed" field in https://drupal.org/node/2145103.
    $fields['changed'] = FieldDefinition::create('integer')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the company was last modified.'))
      ->setPropertyConstraints('value', array('EntityChanged' => TRUE));

    return $fields;
  }
}
