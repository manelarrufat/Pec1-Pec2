<?php

namespace Drupal\forcontu_pec2\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\webprofiler\Form\FormBuilderWrapper;

/**
 * Provides a 'Ranking' block.
 *
 * @Block(
 *  id = "ranking",
 *  admin_label = @Translation("Ranking"),
 * )
 */
class Ranking extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var \Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  /**
   * Drupal\webprofiler\Form\FormBuilderWrapper definition.
   *
   * @var \Drupal\webprofiler\Form\FormBuilderWrapper
   */
  protected $formBuilder;
  /**
   * Constructs a new Ranking object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    Connection $database, 
	FormBuilderWrapper $form_builder
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $this->formBuilder = $form_builder;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('form_builder')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
            'number_of_users' => 3,
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $range = range(1, 10);
    $form['number_of_users'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of users'),
      '#description' => $this->t('Display number of users selected'),
      '#options' => array_combine($range, $range),
      '#default_value' => $this->configuration['number_of_users'],
      '#size' => 5,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['number_of_users'] = $form_state->getValue('number_of_users');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $order = 1;
    $build = [];
    $build[] = ['#markup' => '<table>',];
    
    $build[] = ['#markup' => '<tr><th>'.$this->t('Position').'</th><th>'. 
      $this->t('Username').'</th><th>'.$this->t('Points').'</th> </tr>',];
    $limit = (int) $this->configuration['number_of_users'];
    
    $connection = \Drupal::database();
    
    $result = $connection->queryRange(
          'SELECT uid, SUM(points) as total  '
        . 'FROM {forcontu_pec2_points} '
        . 'GROUP BY uid '
        . 'ORDER BY total DESC ', 0, $limit);
    
    foreach ($result as $record) {
      //dpm($record);
      $user = $connection->query(
          'SELECT name FROM {users_field_data} WHERE uid = :uid', [':uid' => $record->uid]);
      foreach ($user as $u) {
        //dpm($u);
      }
      $build[] = ['#markup' => '<tr><td>'.$order
          .'</td><td>'. $u->name
          .'</td><td>'.$record->total
          .'</td> </tr>',];
      $order++;
    }
    
    $build[] = ['#markup' => '</table>',];

    return $build;
  }

}
