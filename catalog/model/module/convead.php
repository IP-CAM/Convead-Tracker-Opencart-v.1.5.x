<?php

class ModelModuleConvead extends Model {

  public function lineItemsInfo($products) {
    $items = array();
    $revenue = 0;
    foreach ($products as $product) {
      $variant_id = $this->getVariantId($product['product_id'], $product['option']);
      $price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
      $items[] = array(
      'product_id' => $variant_id,
      'qnt' => $product['quantity'],
      'price' => $price
      );
      $revenue += $product['price'] * $product['quantity'];
    }
    return array($revenue, $items);
  }

  public function getVariantId($product_id, $options) {
    if (count($options)) {
      $option = current($options);
      if (!isset($option['option_value_id']) and isset($option['option_value']) and is_array($option['option_value'])) $option = current($option['option_value']);
      return $product_id.(isset($option['option_value_id']) ? str_pad($option['option_value_id'], 7, '0', STR_PAD_LEFT) : '');
    }
    else {
      return $product_id;
    }
  }
}
