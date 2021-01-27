<?php
namespace Drupal\assignment\Plugin\Block;
use Drupal\Core\block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;


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

    $data = ['city' => $city, 'country' => $country, 'time' => $time];
    $cid = 'timezone_' . $timezone;
    $tags = ['timezone:' . $timezone];

    // Getting custom cache tag if exists.
    if ($item = \Drupal::cache()->get($cid)) {
      $data = $item->data;
    }

    // Setting custom cache.
    \Drupal::cache()->set($cid, $data, CacheBackendInterface::CACHE_PERMANENT, $tags);

    return array(
        '#theme' => 'time_block',
        '#data' => $data,
    );
  }
}