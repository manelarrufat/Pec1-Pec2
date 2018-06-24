<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\Plugin\GrantPointsBase;

/**
* Create points when creating a node.
*
* @GrantPoints(
* id = "node_create",
* description = @Translation("Create 5 points when creating a node")
* )
*/
class NodeCreate extends GrantPointsBase {
  public function grant($entityType, $entityId, $userId) {
    $points = \Drupal::entityTypeManager()->getStorage('forcontu_pec2_points');
    $points->create(['target_type' => $entityType, 'target_entity' => $entityId, 
      'operation' => 'create', 'points' => 5, 'uid'=> $userId])->save();
  }

}
