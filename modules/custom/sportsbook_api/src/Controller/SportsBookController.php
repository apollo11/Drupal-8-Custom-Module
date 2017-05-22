<?php
namespace Drupal\sportsbook_api\Controller;

use Drupal\sportsbook_api\Model\SportsBookModel as SportsBook;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class SportsBookController extends ControllerBase {

  public function index($langcode)
  {
    $data = new SportsBook();
    $sportsBookContent = $data->getSportsBook($langcode);

    foreach($sportsBookContent as $value) {
      $test[] = $value;
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



