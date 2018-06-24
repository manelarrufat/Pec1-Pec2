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
    $form['number_of_users'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of users'),
    '#description' => $this->t('Display number of users selected'),
      '#options' => ['no' => $this->t('no')],
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
    $build = [];
    $build['ranking_number_of_users']['#markup'] = '<p>' . $this->configuration['number_of_users'] . '</p>';

    return $build;
  }

}
