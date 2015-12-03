<?php
namespace Store\Entity;

use Store\Db\DbFunctions;

class Order
{
  private $id;
  private $product_id;
  private $quantity;
  private $date;
  private $user_id;
  private $product_price; //product price at time of purchase

  function __construct()
  {
    $this->date = date('Y-m-d H:i:s');
  }

  /**
   * @param int $id
   * @return array
   */

  public static function getOrder($id = 0)
  {
    $sql = "SELECT
              order_id,
              order_product_id,
              price_product,
              order_user_id,
              order_quantity,
              order_date,
              user_id,
              user_name,
              product_id,
              product_name
            FROM
              orders
            LEFT JOIN
              users ON order_user_id = user_id
            LEFT JOIN
              products ON order_product_id = product_id";
    if ($id !== 0)
    {
      $sql .= ' WHERE order_id = ' . $id;
      return DbFunctions::sql($sql)[0];
    }
    return DbFunctions::sql($sql);
  }

  public function exchangeArray($data)
  {
    foreach ($data AS $key => $val){
      if (property_exists($this, $key)){
        $this->$key = ($val !== null) ? $val : null;
      }
    }
  }

  public function setProductId($id)
  {
    $this->product_id = (int) $id;
  }

  public function setProductPrice($price)
  {
    $this->product_price = (int) $price;
  }

  public function setUserId($id)
  {
    $this->user_id = (int) $id;
  }

  public function save()
  {
    $setField = $this->product_id . ", "
              . $this->quantity . ", '"
              . $this->date . "', "
              . $this->user_id . ", "
              . $this->product_price;
    return DbFunctions::insertEntity('order', $setField);
  }
}