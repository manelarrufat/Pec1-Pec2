<?php

namespace Drupal\forcontu_pec2\Plugin\GrantPoints;

use Drupal\forcontu_pec2\Plugin\GrantPointsBase;
use Drupal\Core\Database\Database;

/**
* Removes points when delete a node.
*
* @GrantPoints(
* id = "node_delete",
* description = @Translation("Removes points when delete a node")
* )
*/
class NodeDelete extends GrantPointsBase {
  public function grant($entityType, $entityId, $userId) {
    //$points = \Drupal::entityTypeManager()->getStorage('forcontu_pec2_points');
    $database = Database::getConnection();
    $connection = \Drupal::database();
    $points = $connection->delete('forcontu_pec2_points')
                ->condition('target_entity', $entityId)
                ->execute();
  }

}
