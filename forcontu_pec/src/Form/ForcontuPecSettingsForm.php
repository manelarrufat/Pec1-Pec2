<?php

namespace Drupal\forcontu_pec\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ForcontuPecSettingsForm.
 */
class ForcontuPecSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'forcontu_pec.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'forcontu.pec.settings';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('forcontu_pec.settings');
    
    $form['forcontu_pec_allowed_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content types'),
      '#description' => $this->t('Content type allowed'),
      '#options' => ['article' => $this->t('Article'), 'page' => $this->t('Page')],
      '#default_value' => $config->get('forcontu_pec_allowed_types'),
    ];
    $form['forcontu_pec_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Message'),
      '#description' => $this->t('Message'),
      '#maxlength' => 50,
      '#size' => 100,
      '#default_value' => $config->get('forcontu_pec_message'),
    ];
    $form['forcontu_pec_num_items'] = [
      '#type' => 'select',
      '#title' => $this->t('Elements to show'),
      '#description' => $this->t('Number of elements to show'),
      '#options' => ['1' => $this->t('1'), '2' => $this->t('2'), '3' => $this->t('3'), '4' => $this->t('4'), '5' => $this->t('5'), '10' => $this->t('10'), '20' => $this->t('20')],
      '#size' => 5,
      '#default_value' => $config->get('forcontu_pec_num_items'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('forcontu_pec.settings')
      ->set('forcontu_pec_allowed_types', $form_state->getValue('forcontu_pec_allowed_types'))
      ->set('forcontu_pec_message', $form_state->getValue('forcontu_pec_message'))
      ->set('forcontu_pec_num_items', $form_state->getValue('forcontu_pec_num_items'))
      ->save();
  }

}
