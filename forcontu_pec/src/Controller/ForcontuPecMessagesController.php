<?php

/* 
 * @file
 * Contains \Drupal\forcontu_pec\Controller\ForcontuPecMessagesController
 */

namespace Drupal\forcontu_pec\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/*
 * Class ForcontuPecMessagesController
 */
class ForcontuPecMessagesController extends ControllerBase {
  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;
  
  /**
   * Database Service Object.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;
  
  /**
   * Constructs a new CurrentUserContext.
   *
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The current user.
   * @param \Drupal\Core\Database\Connection $database
   *   Database Service Object.
   */
  public function __construct(AccountInterface $current_user, Connection $database) {
    $this->currentUser = $current_user;
    $this->database = $database;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'), 
      $container->get('database')
    );
  }
  
  /**
   * Messages.
   * 
   * @return messages table
   */
  public function messages() {
    $config = \Drupal::config('forcontu_pec.settings');
    $limit = $config->get('forcontu_pec_num_items');
    
    $output = '<h2>PEC 1.e - Listado de nodos y formulario de confirmación</h2>';
    
    //  nid, título, activado, mensaje y operaciones
    
    $query = $this->database->select('forcontu_pec_messages', 'f');
    $query->join('node_field_data', 'n', 'f.nid = n.nid');
    $query->fields('f', ['nid', 'checked', 'message']);
    $query->fields('n', ['title']);
    $query->range(0, $limit);
    $query->orderBy('nid', 'DESC');
        
    $result = $query->execute();
    
    $header = [
      'nid' => t('NID'),
      'title' => t('Title'),
      'activated' => t('Activated'),
      'message' => t('Message'),
      'operations' => t('Operations'),
     ];
    
    foreach ($result as $record) {
      $urlEdit = Url::fromRoute('entity.node.edit_form', ['node' => $record->nid]);
      $linkEdit = Link::fromTextAndUrl(t('Edit'), $urlEdit)->toString();
      
      $urlDelete = Url::fromRoute('forcontu_pec.delete', ['node' => $record->nid]);
      $linkDelete = Link::fromTextAndUrl(t('Delete'), $urlDelete)->toString();
      
      $mainLink = t('@linkEdit | @linkDelete', array('@linkEdit' => $linkEdit, '@linkDelete' => $linkDelete));
      
      $rows[] = [
        $record->nid,
        $record->title,
        $record->checked,
        $record->message,
        $mainLink,
      ];
    }
    
    $build['forcontu_comment_table'] = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    );
    
        
    return array('#markup' => $output, $build);
  }
  
}

