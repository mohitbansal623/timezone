<?php
namespace Drupal\assignment\Plugin\Block;
use Drupal\Core\block\BlockBase;


/**
 * Provides a 'Time' block.
 *
 * @Block(
 * id = "timezone_block",
 * admin_label = @Translation("Returns Time based on Timezone"),
 * )
 */

class GetTimeBlock extends BlockBase{
  /**
   * {@inheritdoc}
   */
  public function build() {
    $city = $country = $time = "mohit";
    $city = \Drupal::config('assignment.adminsettings')->get('city');
    $country = \Drupal::config('assignment.adminsettings')->get('country');
    $timezone = \Drupal::config('assignment.adminsettings')->get('timezone');

    // Fetching time based on the timezone using service.
    $call_time_service = \Drupal::service('assignment.get_timezone_service'); 

    $time = $call_time_service->get_timezone($timezone);

    return array(
        '#theme' => 'time_block',
        '#city' => $city,
        '#country' => $country,
        '#time' => $time,
    );
  }

  /**
   * {@inheritdoc} Preventing block to be cached.
   */
  public function getCacheMaxAge() {
    return 0;
  }
}