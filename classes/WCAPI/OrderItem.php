<?php
namespace WCAPI;
/**
 * An OrderItem class to insulate the API from the details of the
 * database representation
*/
require_once(dirname(__FILE__) . "/Base.php");
require_once(dirname(__FILE__) . "/Order.php");
require_once(dirname(__FILE__) . "/Product.php");
class OrderItem extends Base {

  public static function setupMetaAttributes() {
    // We only accept these attributes.
    static::$_meta_attributes_table = array(
      'quantity'          => array('name' => '_qty',           'type' => 'number'), 
      'tax_class'         => array('name' => '_tax_class',    'type' => 'number'), 
      'product_id'        => array('name' => '_product_id',    'type' => 'number'), 
      'variation_id'      => array('name' => '_variation_id',    'type' => 'number'), 
      'subtotal'          => array('name' => '_line_subtotal',    'type' => 'number'),
      'total'             => array('name' => '_line_total',    'type' => 'number'),  
      'tax'               => array('name' => '_line_tax',    'type' => 'number'),  
      'subtotal_tax'      => array('name' => '_line_subtotal_tax',    'type' => 'number'), 
      // if this is a tax li, then there will be these fields...what a mess.
      'rate_id'           => array('name' => 'rate_id',     'type' => 'number'), 
      'label'             => array('name' => 'label',       'type' => 'number'), 
      'compound'          => array('name' => 'compound',    'type' => 'number'), 
      'tax_amount'        => array('name' => 'tax_amount',  'type' => 'number'), 
      'shipping_tax'      => array('name' => 'shipping_tax','type' => 'number'), 

    );
    static::$_meta_attributes_table = apply_filters( 'WCAPI_order_item_meta_attributes_table', static::$_meta_attributes_table );
  } // end setupMetaAttributes
  public static function setupModelAttributes() {
    global $wpdb;
    static::$_model_settings = array_merge(Base::getDefaultModelSettings(), array(
      'model_table'                => $wpdb->prefix . 'woocommerce_order_items',
      'meta_table'                => $wpdb->prefix . 'woocommerce_order_itemmeta',
      'model_table_id'             => 'order_item_id',
      'meta_table_foreign_key'    => 'order_item_id',
      'meta_function' => 'woocommerce_get_order_item_meta',
      'belongs_to' => array(
        'order' => array('class_name' => 'Order', 'foreign_key' => 'order_id'),
        'product' => array('class_name' => 'Product', 'meta_attribute' => 'product_id'),
      ),
    ) );
    static::$_model_attributes_table = array(
      'name'            => array('name' => 'order_item_name',  'type' => 'string'),
      'type'            => array('name' => 'order_item_type',  'type' => 'string'),
      'order_id'            => array('name' => 'order_id',     'type' => 'number'),

    );
    static::$_model_attributes_table = apply_filters( 'WCAPI_order_item_model_attributes_table', static::$_model_attributes_table );
  }
}