<?php

namespace Drupal\forcontu_pec2\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Points entities.
 *
 * @ingroup forcontu_pec2
 */
interface PointsInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the User id.
   *
   * @return int
   *   The user id.
   */
  public function getUserId();

  /**
   * Sets the User id.
   *
   * @param int $uid
   *   The User id.
   *
   * @return $this
   */
  public function setUserId($uid);
  
  /**
   * Gets the target entity type
   * 
   * @return string
   *   The entity type
   */
  public function getTargetType();
  
  /**
   * Sets the target entity type
   * 
   * @param string $target_type
   *   The entity target type
   * 
   * @return $this
   */
  public function setTargetType($target_type);
  
   /**
   * Gets the target entity id
   * 
   * @return int
   *   The entity id
   */
  public function getTargetEntity();
  
  /**
   * Sets the target entity id
   * 
   * @param string $target_id
   *   The entity target id
   * 
   * @return $this
   */
  public function setTargetEntity($target_id);
  
  /**
   * Gets the operation
   * 
   * @return string
   *   The operation name
   */
  public function getOperation();
  
  /**
   * Sets the operation
   * 
   * @param string $operation
   *   The operation
   * 
   * @return $this
   */
  public function setOperation($operation);
   
  
  
  
  /**
   * Gets the Points creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Points.
   */
  public function getTimestamp();

  /**
   * Sets the Points creation timestamp.
   *
   * @param int $timestamp
   *   The Points creation timestamp.
   *
   * @return $this
   */
  public function setTimestamp($timestamp);

  /**
   * Returns the Points.
   *
   * @return int
   *   The number of points.
   */
  public function getPoints();

  /**
   * Sets the number of Points.
   *
   * @param int $points
   *   Number of points
   *
   * @return $this
   */
  public function setPoints($points);

}
