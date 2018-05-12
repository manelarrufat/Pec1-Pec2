<?php

namespace Drupal\forcontu_pec2;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Points entities.
 *
 * @ingroup forcontu_pec2
 */
class PointsListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Points ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\forcontu_pec2\Entity\Points */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.forcontu_pec2_points.edit_form',
      ['forcontu_pec2_points' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
