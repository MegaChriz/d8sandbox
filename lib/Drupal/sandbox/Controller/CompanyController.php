<?php

/**
 * @file
 * Contains \Drupal\sandbox\Controller\CompanyController.
 */

namespace Drupal\sandbox\Controller;

use Drupal\Component\Utility\String;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\sandbox\Entity\Company;

/**
 * Returns responses for companies.
 */
class CompanyController extends ControllerBase {

  /**
   * Content callback for the 'create new company' page.
   * @return array
   */
  public function add() {
    $company = entity_create('sandbox_company', array(
      'created' => REQUEST_TIME,
    ));
    return \Drupal::entityManager()->getForm($company);
  }

}