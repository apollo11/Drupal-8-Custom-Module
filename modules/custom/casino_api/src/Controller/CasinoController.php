<?php
namespace Drupal\casino_api\Controller;

use Drupal\casino_api\Model\CasinoModel as Casino;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class CasinoController extends ControllerBase {

  public function index($langcode)
  {

    $data = new Casino();
    $casinoContent = $data->getCasino($langcode);

    foreach ($casinoContent as $value) {
      $test [] = $value;
      $result [] = [
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
        'powered_by_image' => [
          'alt' => $value->field_casino_carousel_image_alt,
          'title' => $value->field_casino_carousel_image_title,
          'height' => $value->field_casino_carousel_image_height,
          'width' => $value->field_casino_carousel_image_width,
          'src' => file_create_url($value->uri),
          'filename' => $value->filename,
        ],
        'logo' => [
          'alt' => $value->tcmmi_field_content_main_image_alt,
          'title' => $value->tcmmi_field_content_main_image_title,
          'height' => $value->tcmmi_field_content_main_image_height,
          'width' => $value->tcmmi_field_content_main_image_width,
          'src' => file_create_url($value->fm_2_uri),
          'filename' => $value->fm_2_filename,
        ],
        'game_platform' => $value->game_platform,
        'game_platform_code' => $value->field_game_code_value,
        'game_code' => $value->field_game_no_value,
        'is_single_wallet' => $value->field_is_single_wallet_value,
        'langcode' => $value->langcode
      ];
    }

    return new JsonResponse($result);
  }
}
