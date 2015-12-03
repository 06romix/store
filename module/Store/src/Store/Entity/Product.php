<?php
namespace Store\Entity;

use Store\Db\DbFunctions;

class Product
{
  private $id;
  private $name;
  private $description;
  private $price;
  private $quantity;
  private $createdDate;

  function __construct()
  {
    $this->createdDate = date('Y-m-d H:i:s');
  }

  public static function getAll()
  {
    return DbFunctions::getEntity('product');
  }

  /**
   * @param array|null $fields
   * @param null $sortBy
   * @param array|string|null $limit
   * @return array
   */

  public static function getAllByField($fields, $sortBy = null, $limit = null)
  {
    return DbFunctions::getFieldEntity('product', $fields, null, $sortBy, $limit);
  }

  /**
   * @param array|null $fields
   * @param null $sortBy
   * @param array $limit
   * @param int $page
   * @return array
   */

  public static function getAllByPage($fields = null, $sortBy = null, $limit, $page)
  {

    if ($page <= 1) {
      $pageLimit = $limit;
    } else {
      $pageLimit['from'] = $limit * ($page - 1);
      $pageLimit['end'] = $limit * $page - $limit;
    }
    return DbFunctions::getFieldEntity('product', $fields, null, $sortBy, $pageLimit);
  }

  /**
   * @param int $id
   * @return int|int
   */

  public static function getOne($id)
  {
    return DbFunctions::getEntity('product', $id);
  }

  public static function getCount()
  {
    return DbFunctions::getEntityCount('product')['COUNT(*)'];
  }

  public function dbToProduct($data)
  {
    foreach ($data AS $key => $val){
      //if isset prefix - modification $key
      $key = preg_replace('/product_/', '', $key);
      if (property_exists($this, $key)){
        $this->$key = ($val !== null) ? $val : null;
      }
    }
  }

  public function exchangeArray($data)
  {
    foreach ($data AS $key => $val){
      if (property_exists($this, $key)){
        $this->$key = ($val !== null) ? $val : null;
      }
    }
  }

  public function getArrayCopy()
  {
    return get_object_vars($this);
  }

  /**
   * @return mixed
   */

  public function save()
  {
    $setField = "'"
              . $this->name . "', '"
              . $this->description . "', "
              . $this->price . ", "
              . $this->quantity . ", '"
              . $this->createdDate . "'";
    return DbFunctions::insertEntity('product', $setField);
  }

  /**
   * @param $whereValue String
   * @return mixed
   */

  public function update($whereValue)
  {
    $setString = "product_name = '"         . $this->name . "', "
               . "product_description = '"  . $this->description . "', "
               . "product_price = '"        . $this->price . "', "
               . "product_quantity = '"     . $this->quantity. "'";

    return DbFunctions::updateEntityById('product', $setString, $whereValue);
  }

  public function delete($product_id)
  {
    return DbFunctions::deleteEntityById('product', $product_id);
  }
}