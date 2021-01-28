<?php
namespace Drupal\assignment\Plugin\Block;
use Drupal\Core\block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\assignment\Services\GetTime;

/**
 * Provides a 'Time' block.
 *
 * @Block(
 * id = "timezone_block",
 * admin_label = @Translation("Returns Time based on Timezone"),
 * )
 */

class GetTimeBlock extends BlockBase  implements ContainerFactoryPluginInterface {

  /**
  * @var $time \Drupal\assignment\Services\GetTime
  */
  protected $time;

  /**
  * @param array $configuration
  * @param string $plugin_id
  * @param mixed $plugin_definition
  * @param \Drupal\assignment\Services\GetTime $time
  */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, GetTime $time) {
  parent::__construct($configuration, $plugin_id, $plugin_definition);
  $this->time = $time;
  }

  /**
  * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
  * @param array $configuration
  * @param string $plugin_id
  * @param mixed $plugin_definition
  *
  * @return static
  */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
  return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('assignment.get_timezone_service'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $city = $country = $time = "mohit";
    $city = \Drupal::config('assignment.adminsettings')->get('city');
    $country = \Drupal::config('assignment.adminsettings')->get('country');
    $timezone = \Drupal::config('assignment.adminsettings')->get('timezone');

    $time = $this->time->get_timezone($timezone);

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