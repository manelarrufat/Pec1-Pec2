<?php

namespace Drupal\forcontu_pec2\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Points edit forms.
 *
 * @ingroup forcontu_pec2
 */
class PointsForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\forcontu_pec2\Entity\Points */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Points.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Points.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.forcontu_pec2_points.canonical', ['forcontu_pec2_points' => $entity->id()]);
  }

}
