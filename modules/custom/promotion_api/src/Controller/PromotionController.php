<?php
namespace Drupal\promotion_api\Controller;

use Drupal\promotion_api\Model\PromotionModel as Promotion;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class PromotionController extends ControllerBase {

  public function index($langcode) {

    $data = new Promotion;
    $promotionContent = $data->getPromotion($langcode);

    foreach($promotionContent as $value) {
      $result[] = [
        'id' => $value->nid,
        'type' => $value->type,
        'title' => $value->title,
        'subtitle' => $value->field_sub_title_value,
        'body' => $value->body_value,
        'thumb_image' => [
          'alt' => $value->field_block_image_alt,
          'title' => $value->field_block_image_title,
          'height' => $value->field_block_image_height,
          'width' => $value->field_block_image_width,
          'src' => file_create_url($value->uri),
          'filename' => $value->filename,
        ],
        'status' => $value->status,
      ];
    }

    return new JsonResponse($result);
  }

  public function getPromotionByCategory($langcode, $category)
  {
    $data = new Promotion();
    $promotionContent = $data->filterByCategory($langcode, $category);

    foreach($promotionContent as $value) {
      $result[] = [
        'id' => $value->nid,
        'type' => $value->type,
        'title' => $value->title,
        'subtitle' => $value->field_sub_title_value,
        'body' => $value->body_value,
        'category' => $value->name,
        'thumb_image' => [
          'alt' => $value->field_block_image_alt,
          'title' => $value->field_block_image_title,
          'height' => $value->field_block_image_height,
          'width' => $value->field_block_image_width,
          'src' => file_create_url($value->uri),
          'filename' => $value->filename,
        ],
        'status' => $value->status,
      ];
    }

    return new JsonResponse($result);

  }

  public function getPromotionByDetails($langcode, $category, $id)
  {
    $data = new Promotion();
    $promotionContent = $data->filterById($langcode, $category, $id);

    foreach($promotionContent as $value) {
      $result[] = [
        'id' => $value->nid,
        'type' => $value->type,
        'title' => $value->title,
        'subtitle' => $value->field_sub_title_value,
        'body' => $value->body_value,
        'category' => $value->name,
        'thumb_image' => [
          'alt' => $value->field_block_image_alt,
          'title' => $value->field_block_image_title,
          'height' => $value->field_block_image_height,
          'width' => $value->field_block_image_width,
          'src' => file_create_url($value->uri),
          'filename' => $value->filename,
        ],
        'status' => $value->status,
      ];
    }

    return new JsonResponse($result);

  }
}
