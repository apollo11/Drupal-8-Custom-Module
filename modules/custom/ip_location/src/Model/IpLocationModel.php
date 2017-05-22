<?php

namespace Drupal\ip_location\Model;

use GeoIp2\Database\Reader;
use Symfony\Component\HttpFoundation\Request;
use Zend\Diactoros\Response\JsonResponse;

class IpLocationModel
{
  protected $connectionGeoip;
  protected $ip = '127.0.0.1';
  protected $defaulIP = '162.211.177.142';
  protected $data = '/usr/share/GeoIP/GeoLite2-City.mmdb';

  /**
   * @param Request $request
   * @return JsonResponse
   * 101.226.196.133 - china
   * 103.47.144.173 - Shanghai China
   * 45.115.24.81 - Bangkok Thailand
   * 103.55.9.17 - Jakarda Indonesia
   * 45.115.25.49 - Korea
   * 172.94.27.149 - Japan
   * 162.211.177.142 - US
   *
   */
  public function getIp(Request $request)
  {
    return $request->getClientIp();

  }

  /**
   * @return null|string
   * Get the client IP Adddress $clientIfo->getClientIp()
   * If the client ip is not available redirect to Us IP
   */
  public function getisoCode($ip)
  {
    $reader = new Reader($this->data);
    try {
      $record = $reader->city($ip);
    }
    catch(\GeoIp2\Exception\AddressNotFoundException $e) {

      $record = $reader->city($this->defaulIP);
    }
    
    $isoCode = $record->country->isoCode;

    return $isoCode;
  }


  public function getCountry($ip)
  {
    $reader = new Reader($this->data);
    try {
      $record = $reader->city($ip);
    } catch (\GeoIp2\Exception\AddressNotFoundException $e) {

      $record = $reader->city($this->defaulIP);
    }

    $country = $record->country;

    return $country;
  }

  public function hostUrl() {
    $host='http://'.$_SERVER['SERVER_NAME'].'/';

    return $host;
  }


}