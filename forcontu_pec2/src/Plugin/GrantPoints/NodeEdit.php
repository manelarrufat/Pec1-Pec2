<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\Plugin\GrantPointsBase;

/**
* Create points when edit a node.
*
* @GrantPoints(
* id = "node_edit",
* description = @Translation("Create 1 point when edit a node")
* )
*/
class NodeEdit extends GrantPointsBase {
  public function grant($entityType, $entityId, $userId) {
    $points = \Drupal::entityTypeManager()->getStorage('forcontu_pec2_points');
    $points->create(['target_type' => $entityType, 'target_entity' => $entityId, 
      'operation' => 'edit', 'points' => 1, 'uid'=> $userId])->save();
  }

}
