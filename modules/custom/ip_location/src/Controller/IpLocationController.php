<?php

namespace Drupal\ip_location\Controller;

use Drupal\ip_location\Model\IpLocationModel;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class IpLocationController extends ControllerBase
{

  /**
   * @param Request $request
   * @return JsonResponse
   * 101.226.196.133 - china
   * 103.47.144.173 - Shanghai China
   * 45.115.24.81 - Bangkok Thailand
   * 103.55.9.17 - Jakarda Indonesia
   * 45.115.25.49 - Korea
   * 172.94.27.149 - Japan
   *
   */

  /**
   * @return  ISOCODE
   * @$ip  - Add client IP Address
   * @$ipLocation - Add object of Iplocation Model
   * @$reader - Get ISOCODE
   */

  public function setCountryCode()
  {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipLocation = new IpLocationModel();
    $reader = $ipLocation->getisoCode($ip);

    return $reader;

  }

  /**
   * @return JsonResponse
   * @$ip  - Add client IP Address
   * @$ipLocation - Add object of Iplocation Model
   * @$country - get country value;
   */
  public function setCountry()
  {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ipLocation = new IpLocationModel();
    $country = $ipLocation->getCountry($ip);

    return new JsonResponse( ['ip' => $ip, 'country' => $country]);
  }

  /**
   * @param $isoCode
   * Ge Country code and save it as default country code
   */
  public function getLangByCountry($isoCode)
  {
    $lang_code = $isoCode;
    \Drupal::configFactory()->getEditable('system.site')->set('default_langcode', $lang_code)->save();

  }

}