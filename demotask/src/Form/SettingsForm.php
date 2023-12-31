<?php

namespace Drupal\demotask\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure demotask settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  const CONFIGNAME = 'demotask.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'demotask_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->config('demotask.settings')->get('title'),
      '#required' => TRUE,
    ];

    $format = 'basic_html';
    if ($this->config('demotask.settings')->get('text')['format']) {
      $format = $this->config('demotask.settings')->get('text')['format'];
    }

    $form['text'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Text'),
      '#format' => $format,
      '#default_value' => $this->config('demotask.settings')->get('text')['value'],
      '#required' => TRUE,
    ];

    $form['display'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display'),
      '#default_value' => $this->config('demotask.settings')->get('display'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $config->set('title', $form_state->getValue('title'));
    $config->set('text', $form_state->getValue('text'));
    $config->set('display', $form_state->getValue('display'));
    $config->save();
  }

}
