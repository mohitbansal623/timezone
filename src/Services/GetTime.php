<?php

namespace Drupal\assignment\Services;

use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Class GetTime used to get time based on timezone
 *
 * @package \Drupal\assignment\Services
 */
class GetTime {

  /**
   * The query factory.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  protected $queryFactory;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * ProgramService service constructor.
   */
  public function __construct(QueryFactory $queryFactory, EntityTypeManagerInterface $entityTypeManager) {
    $this->queryFactory = $queryFactory;
    $this->entityTypeManager = $entityTypeManager;
  }

  public function get_timezone($timezone) {

    // Fetching the current time based on a timezone passed.
    $date = new \DateTime("now", new \DateTimeZone($timezone));

    // Converting it in format as per requirement.
    $formatted_date = $date->format('dS M Y - h:i A');
    
    // $formatted_date = \Drupal::service('date.formatter')->format(
    //   $date->getTimestamp(), 'custom', 'dS M Y - h:i A'
    // );
    return $formatted_date;
  }

}
