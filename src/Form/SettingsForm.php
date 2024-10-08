<?php

declare(strict_types=1);

namespace Drupal\htmx_plus\Form;

use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the settings form for the HTMX Plus module.
 */
class SettingsForm extends StateFormBase {

  /**
   * Config settings.
   */
  const CONFIG_NAME = 'htmx_plus.settings';

  /**
   * {@inheritdoc}
   *
   * @return string[]
   *   An array of configuration object names.
   */
  protected function getEditableConfigNames(): array {
    return [
      static::CONFIG_NAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'htmx_plus_settings_form';
  }

  /**
   * {@inheritdoc}
   *
   * @param array<string,mixed> $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array<string,mixed>
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('htmx_plus.settings');

    $form['debug_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Debug Extension'),
      '#default_value' => $config->get('debug_enabled'),
    ];

    $form['debug_enabled_all'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable HTMX debug mode for all elements'),
      '#default_value' => $this->state->get('htmx_plus.debug_enabled_all'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * @param array<string,mixed> $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('htmx_plus.settings')
      ->set('debug_enabled', $form_state->getValue('debug_enabled'))
      ->save();

    $this->state->set('htmx_plus.debug_enabled_all', $form_state->getValue('debug_enabled_all'));

    parent::submitForm($form, $form_state);
  }

}
