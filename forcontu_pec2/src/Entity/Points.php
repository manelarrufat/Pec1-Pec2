<?php

namespace Drupal\forcontu_pec2\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Points entity.
 *
 * @ingroup forcontu_pec2
 *
 * @ContentEntityType(
 *   id = "forcontu_pec2_points",
 *   label = @Translation("Points"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\forcontu_pec2\PointsListBuilder",
 *     "views_data" = "Drupal\forcontu_pec2\Entity\PointsViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "add" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "edit" = "Drupal\forcontu_pec2\Form\PointsForm",
 *       "delete" = "Drupal\forcontu_pec2\Form\PointsDeleteForm",
 *     },
 *     "access" = "Drupal\forcontu_pec2\PointsAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\forcontu_pec2\PointsHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "forcontu_pec2_points",
 *   admin_permission = "administer points entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "points",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}",
 *     "add-form" = "/admin/structure/forcontu_pec2_points/add",
 *     "edit-form" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}/edit",
 *     "delete-form" = "/admin/structure/forcontu_pec2_points/{forcontu_pec2_points}/delete",
 *     "collection" = "/admin/structure/forcontu_pec2_points",
 *   },
 *   field_ui_base_route = "forcontu_pec2_points.settings"
 * )
 */
class Points extends ContentEntityBase implements PointsInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getUserId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setUserId($uid) {
    $this->set('uid', $uid);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getTargetType() {
    return $this->get('target_type')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setTargetType($target_type) {
    $this->set('target_type', $target_type);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getTargetEntity() {
    return $this->get('target_entity')->target_id;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setTargetEntity($target_id) {
    $this->set('target_entity', $target_id);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getOperation() {
    return $this->get('operation')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setOperation($operation) {
    $this->set('operation', $operation);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getTimestamp() {
    return $this->get('timestamp')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setTimestamp($timestamp) {
    $this->set('timestamp', $timestamp);
  }
  
  /**
   * {@inheritdoc}
   */
  public function getPoints() {
    return $this->get('points')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setPoints($points) {
    $this->set('points', $points);
  }
  
  

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Owner of the points'))
      ->setDescription(t('The user ID of the owner of the Points entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['target_type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Entity type'))
      ->setDescription(t('The entity type that generates points.'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('node')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['target_entity'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Entity that generates points.'))
      ->setDescription(t('The node ID of the entity that generates points.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'node')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'node',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['operation'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Operation'))
      ->setDescription(t('The operation that generates or cancels points.'))
      ->setSettings([
        'max_length' => 10,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['timestamp'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Timestamp'))
      ->setDescription(t('The time that the points was generated.'));

    $fields['points'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Points'))
      ->setDescription(t('The points that the node was generated.'))
      ->setSettings([
      ])
      ->setDefaultValue(0)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  public function getOwner(): UserInterface {
    
  }

  public function getOwnerId() {
    
  }

  public function setOwner(UserInterface $account): \this {
    
  }

  public function setOwnerId($uid): \this {
    
  }

}
