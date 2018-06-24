<?php

namespace Drupal\forcontu_pec2\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Grant points plugins.
 */
abstract class GrantPointsBase extends PluginBase implements GrantPointsInterface {

  public function description() {
    return $this->pluginDefinition['description'];
  }
  
  abstract public function grant($entityType, $entityId, $userId);

}
