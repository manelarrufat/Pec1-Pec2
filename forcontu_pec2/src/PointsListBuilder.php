<?php

namespace Drupal\forcontu_pec2;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Datetime\DateFormatterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Points entities.
 *
 * @ingroup forcontu_pec2
 */
class PointsListBuilder extends EntityListBuilder {
  protected $dateFormatter;
  
  public function __construct(EntityTypeInterface $entity_type, 
EntityStorageInterface $storage, 
DateFormatterInterface $date_formatter) {
    parent::__construct($entity_type, $storage);
    
    $this->dateFormatter = $date_formatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, 
EntityTypeInterface $entity_type) {
    return new static (
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('date.formatter')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Points ID');
    $header['uid'] = $this->t('User ID');
    $header['target_type'] = $this->t('Target type');
    $header['target_entity'] = $this->t('Target entity ID');
    $header['operation'] = $this->t('Operation');
    $header['timestamp'] = $this->t('Created');
    $header['points'] = $this->t('Points');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\forcontu_pec2\Entity\Points */
    $row['id'] = $entity->id();
    $row['uid'] = $entity->getUserId();
    $row['target_type'] = $entity->getTargetType();
    $row['target_entity'] = $entity->getTargetEntity();
    $row['operation'] = $entity->getOperation();
    $row['timestamp'] = $this->dateFormatter->format($entity->getTimestamp(), 'short');
    $row['points'] = $entity->getPoints();
    
    return $row + parent::buildRow($entity);
  }

}
