<?php
/**
 * @file
 * Contains \Drupal\ip_location\EventSubscriber\IpLocationSubscriber.
 */

namespace Drupal\ip_location\EventSubscriber;

use Drupal\ip_location\Controller\IpLocationController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;


class IpLocationSubscriber implements EventSubscriberInterface
{
  /**
   * Return url by language depends of what language
   */

  public function redirectAccordingToCountryCode()
  {
    $location = new IpLocationController();
    $countryCode = $location->setCountryCode();

    switch ($countryCode) {
      case'KR':
        $location->getLangByCountry('ko');
        break;
      case 'CN':
        $location->getLangByCountry('zh-hans');
        break;
      case 'TH':
        $location->getLangByCountry('th');
        break;
      case 'ID':
        $location->getLangByCountry('id');
        break;
      case 'JP':
        $location->getLangByCountry('jp');
        break;
      default:
        $location->getLangByCountry('en');
        break;
    }
  }


  /**
   * @return array
   * This will return when request is successful
   * Drupal 8 middleware
   */

  static function getSubscribedEvents()
  {
    $events = [];
    $events[KernelEvents::REQUEST][] = ['redirectAccordingToCountryCode'];

    return $events;
  }

}