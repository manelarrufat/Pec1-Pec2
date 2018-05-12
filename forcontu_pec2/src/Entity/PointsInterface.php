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
   * Gets the Points name.
   *
   * @return string
   *   Name of the Points.
   */
  public function getName();

  /**
   * Sets the Points name.
   *
   * @param string $name
   *   The Points name.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setName($name);

  /**
   * Gets the Points creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Points.
   */
  public function getCreatedTime();

  /**
   * Sets the Points creation timestamp.
   *
   * @param int $timestamp
   *   The Points creation timestamp.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Points published status indicator.
   *
   * Unpublished Points are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Points is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Points.
   *
   * @param bool $published
   *   TRUE to set this Points to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\forcontu_pec2\Entity\PointsInterface
   *   The called Points entity.
   */
  public function setPublished($published);

}
