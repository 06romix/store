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


  public static function getAll()
  {
    return DbFunctions::getEntity('product');
  }

  public static function getProduct($id = 0, $order = null, $limit = null)
  {

    if ($id) {
      $count = 1;
      $sql = "SELECT * FROM products
              LEFT JOIN products_description
              ON product_id = description_id
              WHERE product_id = " . $id . " AND product_status = 1";

    } else {
      $count = 0;
      $sql = "SELECT * FROM products
                      LEFT JOIN products_description
                      ON product_id = description_id
                      WHERE product_status = 1";
    }
    if ($order !== null) $sql .= ' ORDER BY `' . $order . '`';
    if ($limit !== null) $sql .= (is_array($limit))
      ? ' LIMIT ' . (int) $limit['from'] . ', ' . (int) $limit['end']
      : ' LIMIT ' . (int) $limit;
    return DbFunctions::sql($sql, $count);
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
    return self::getProduct(0, $sortBy, $pageLimit);
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
    $where = ' WHERE product_status = 1';
    return DbFunctions::getEntityCount('product', $where)['COUNT(*)'];
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

  /**
   * @return mixed
   */

  public function save()
  {
    $productSQL = "'" . $this->name . "'";
    DbFunctions::insert("INSERT INTO products (product_name)  VALUES (" . $productSQL . ")");

    $this->id = DbFunctions::sql("SELECT product_id FROM products
                                  WHERE product_name = '" . $this->name . "'
                                  ORDER BY product_id DESC", 1)['product_id'];
    $descriptionSQL = $this->id . ", '"
      . $this->description . "', "
      . $this->price . ", "
      . $this->quantity . ", NULL";
    DbFunctions::insert("INSERT INTO products_description VALUES (" . $descriptionSQL . ")");
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