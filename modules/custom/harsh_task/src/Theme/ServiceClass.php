<?php

namespace Drupal\harsh_task\Theme;

use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
/**
 * Sets the active theme on admin pages.
 */
class ServiceClass implements ThemeNegotiatorInterface {

  /**
   * Protected configFactory variable.
   *
   * @var configFactory
   */
  protected $configFactory;
  

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
    
  }
  
  public static function create(ContainerInterface $container) {
    kint($container->get('current_user')); die;
  return new static(
      $container->get('current_user')
  );
  }
  
  public function getFormId() {
    return 'ques1';
  }
  
  protected function getEditableConfigNames() {
    return [
      'harsh_task.Harsh_TaskConfig',
    ];
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    kint($form_state);
    $uid = $this->currentUser->id();
    drupal_set_message($uid);
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory('harsh_task.Harsh_TaskConfig')->save();
  }
}
