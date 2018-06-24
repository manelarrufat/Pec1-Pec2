<?php

namespace Drupal\forcontu_pec2\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Grant points plugins.
 */
interface GrantPointsInterface extends PluginInspectionInterface {
  
  public function description();

  public function grant($entityType, $entityId, $userId);

}
