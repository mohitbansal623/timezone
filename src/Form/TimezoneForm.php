<?php  
/**  
 * @file  
 * Contains Drupal\welcome\Form\TimezoneForm.  
 */  
namespace Drupal\assignment\Form;  
use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  

class TimezoneForm extends ConfigFormBase { 

	/**  
   * {@inheritdoc}  
   */  
  protected function getEditableConfigNames() {  
    return [  
      'assignment.adminsettings',  
    ];  
  }  

  /**  
   * {@inheritdoc}  
   */  
  public function getFormId() {  
    return 'assignment_form';  
  }

  /**  
   * {@inheritdoc}  
   */  
  public function buildForm(array $form, FormStateInterface $form_state) {  
    
    // Initialising the config variable.
    // assignment.adminsettings is the module's configuration name, so this will load the admin settings.  
    $config = $this->config('assignment.adminsettings');  

    // Country field.
    $form['country'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('Country'),
      '#required' => TRUE,  
      '#description' => $this->t('Enter country name'),  
      '#default_value' => $config->get('country'),  
    ];

    // City field.
    $form['city'] = [  
      '#type' => 'textfield',  
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#description' => $this->t('Enter city name'),  
      '#default_value' => $config->get('city'),  
    ];


    // Setting timezone options.
    $timezone_options = array('America/Chicago' => 'America/Chicago', 'America/New_York' => 'America/New_York', 'Asia/Tokyo' => 'Asia/Tokyo', 'Asia/Dubai' => 'Asia/Dubai', 'kolkata' => 'Asia/Kolkata', 'Europe/Amsterdam' => 'Europe/Amsterdam', 'Europe/Oslo' => 'Europe/Oslo', 'Europe/London' => 'Europe/London');


    // Creating timezone select list.
    $form['timezone'] = [  
      '#type' => 'select',  
      '#title' => $this->t('Select Timezone'),  
      '#options' => $timezone_options,
      '#size' => NULL,
      '#required' => TRUE,  
      '#default_value' => !empty($config->get('timezone')) ? $config->get('timezone'): 'chicago',  
    ];

    return parent::buildForm($form, $form_state);  
  }

  /**  
   * {@inheritdoc}  
   */  
  public function submitForm(array &$form, FormStateInterface $form_state) {  
    parent::submitForm($form, $form_state);  

    $this->config('assignment.adminsettings')  
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))  
      ->save();  
  }       

}  