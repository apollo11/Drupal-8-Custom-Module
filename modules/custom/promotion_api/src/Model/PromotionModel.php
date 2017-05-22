<?php
namespace Drupal\promotion_api\Model;

class PromotionModel {

  public function getPromotion($langcode)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__body', 'nb', 'nb.entity_id = nfd.nid and nb.langcode = nfd.langcode');
    $query->addField('nb', 'body_value');
    $query->leftJoin('node__field_sub_title', 'nfst', 'nfst.entity_id = nb.entity_id and nfst.langcode = nb.langcode');
    $query->addField('nfst', 'field_sub_title_value');
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid and nfet.langcode = nfd.langcode');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('node__field_block_image', 'nfbi', 'nfbi.entity_id = nfet.entity_id and nfbi.langcode = nfd.langcode');
    $query->fields('nfbi', [
      'field_block_image_target_id'
      , 'field_block_image_alt'
      , 'field_block_image_title'
      , 'field_block_image_width '
      , 'field_block_image_height'
    ]);
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfbi.entity_id and nff.langcode = nfbi.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('node__field_order_by', 'nfob', 'nfob.entity_id = nff.entity_id and nfob.langcode = nff.langcode');
    $query->addField('nfob', 'field_order_by_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfbi.field_block_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'promotions');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfob.field_order_by_value', 'ASC');
    $result = $query->execute();

    return $result;

  }

  public function filterByCategory($langcode, $category)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__body', 'nb', 'nb.entity_id = nfd.nid and nb.langcode = nfd.langcode');
    $query->addField('nb', 'body_value');
    $query->leftJoin('node__field_sub_title', 'nfst', 'nfst.entity_id = nb.entity_id and nfst.langcode = nb.langcode');
    $query->addField('nfst', 'field_sub_title_value');
    $query->leftJoin('node__field_promotion_kind', 'nfpk', 'nfpk.entity_id = nfd.nid and nfpk.langcode = nfd.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfd_1', 'ttfd_1.tid = nfpk.field_promotion_kind_target_id and ttfd_1.langcode = nfpk.langcode');
    $query->addField('ttfd_1', 'name');
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid and nfet.langcode = nfd.langcode');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('node__field_block_image', 'nfbi', 'nfbi.entity_id = nfet.entity_id and nfbi.langcode = nfd.langcode');
    $query->fields('nfbi', [
      'field_block_image_target_id'
      , 'field_block_image_alt'
      , 'field_block_image_title'
      , 'field_block_image_width '
      , 'field_block_image_height'
    ]);
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfbi.entity_id and nff.langcode = nfbi.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('node__field_order_by', 'nfob', 'nfob.entity_id = nfpk.entity_id and nfob.langcode = nfpk.langcode');
    $query->addField('nfob', 'field_order_by_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfbi.field_block_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'promotions');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('ttfd_1.name', $category);
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfob.field_order_by_value', 'ASC');
    $result = $query->execute();

    return $result;

  }

  public function filterById($langcode, $category, $id)
  {
    $query = \Drupal::database()->select('node_field_data', 'nfd');
    $query->fields('nfd', ['nid', 'vid', 'uid', 'type', 'title', 'langcode', 'status']);
    $query->leftJoin('node__body', 'nb', 'nb.entity_id = nfd.nid and nb.langcode = nfd.langcode');
    $query->addField('nb', 'body_value');
    $query->leftJoin('node__field_sub_title', 'nfst', 'nfst.entity_id = nb.entity_id and nfst.langcode = nb.langcode');
    $query->addField('nfst', 'field_sub_title_value');
    $query->leftJoin('node__field_promotion_kind', 'nfpk', 'nfpk.entity_id = nfd.nid and nfpk.langcode = nfd.langcode');
    $query->leftJoin('taxonomy_term_field_data', 'ttfd_1', 'ttfd_1.tid = nfpk.field_promotion_kind_target_id and ttfd_1.langcode = nfpk.langcode');
    $query->addField('ttfd_1', 'name');
    $query->leftJoin('node__field_egames_type', 'nfet', 'nfet.entity_id = nfd.nid and nfet.langcode = nfd.langcode');
    $query->fields('nfet', ['bundle', 'entity_id', 'field_egames_type_target_id', 'langcode']);
    $query->leftJoin('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = nfet.field_egames_type_target_id and nfet.langcode = ttfd.langcode');
    $query->addField('ttfd', 'name', 'game_platform');
    $query->leftJoin('taxonomy_term__field_game_code', 'ttfgc', 'ttfgc.entity_id = ttfd.tid and ttfgc.langcode = ttfd.langcode');
    $query->fields('ttfgc', ['field_game_code_value']);
    $query->leftJoin('taxonomy_term__field_is_single_wallet', 'ttfis', 'ttfis.entity_id = ttfgc.entity_id and ttfis.langcode = ttfgc.langcode');
    $query->addField('ttfis', 'field_is_single_wallet_value');
    $query->leftJoin('node__field_game_no', 'nfgn', 'nfgn.entity_id = nfd.nid and nfgn.langcode = nfd.langcode');
    $query->fields('nfgn', ['field_game_no_value']);
    $query->leftJoin('node__field_block_image', 'nfbi', 'nfbi.entity_id = nfet.entity_id and nfbi.langcode = nfd.langcode');
    $query->fields('nfbi', [
      'field_block_image_target_id'
      , 'field_block_image_alt'
      , 'field_block_image_title'
      , 'field_block_image_width '
      , 'field_block_image_height'
    ]);
    $query->leftJoin('node__field_featured', 'nff', 'nff.entity_id = nfbi.entity_id and nff.langcode = nfbi.langcode');
    $query->addField('nff', 'field_featured_value');
    $query->leftJoin('node__field_order_by', 'nfob', 'nfob.entity_id = nfpk.entity_id and nfob.langcode = nfpk.langcode');
    $query->addField('nfob', 'field_order_by_value');
    $query->leftJoin('file_managed', 'fm', 'fm.fid = nfbi.field_block_image_target_id');
    $query->fields('fm', ['uri', 'filename', 'fid', 'langcode']);
    $query->condition('nfd.type', 'promotions');
    $query->condition('nfd.langcode', $langcode, '=');
    $query->condition('ttfd_1.name', $category);
    $query->condition('nfd.nid', $id);
    $query->condition('nfd.status', 1 , '=');
    $query->orderBy('nfob.field_order_by_value', 'ASC');
    $result = $query->execute();

    return $result;

  }
}