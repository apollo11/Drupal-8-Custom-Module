<?php
namespace Drupal\banner_api\Controller;

use Drupal\banner_api\Model\BannerModel as Banner;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use GeoIp2\Database\Reader;
use Symfony\Component\HttpFoundation\Request;


class BannerController extends ControllerBase {

  public function index($langcode)
  {
    $data = new Banner();
    $bannerContent = $data->getBanner($langcode);

    foreach ($bannerContent as $value) {
      $test [] = $value;

      $result[] = [
        'id' => $value->nid,
        'type' => $value->type,
        'title' => $value->title,
        'thumb_image' => [
          'alt' => $value->field_content_main_image_alt,
          'title' => $value->field_content_main_image_title,
          'height' => $value->field_content_main_image_height,
          'width' => $value->field_content_main_image_width,
          'src' => file_create_url($value->uri),
          'filename' => $value->filename,
        ],
        'game_platform' => $value->game_platform,
        'game_platform_code' => $value->field_game_code_value,
        'game_code' => $value->field_game_no_value,
        'is_single_wallet' => $value->field_is_single_wallet_value,
        'action_title' => $value->field_action_title_value,
        'langcode' => $value->langcode
      ];

    }

    return new JsonResponse($result);

  }

  public function testIP(Request $request) {
    $ip = $request->getClientIp();
    $reader = new Reader('/usr/share/GeoIP/GeoLite2-City.mmdb');
    $record = $reader->city('172.94.27.149');

    return new JsonResponse(['code' => $record->country, 'ip' => $ip]);
  }

}

