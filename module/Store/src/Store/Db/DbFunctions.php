<?php
namespace Store\Db;


use Zend\Db\Adapter\Driver;

class DbFunctions
{
  /**
   * @param $sql
   * @return array
   */

  public static function sql($sql)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $a = iterator_to_array($Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE));
    return $a;
  }

  /**
   * @param $entity String
   * @param int $id
   * @return array
   */

  public static function getEntity($entity, $id = 0)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = 'SELECT * FROM ' . $entity . 's';

    if ($id !== 0) {
      $sql = 'SELECT * FROM ' . $entity . 's WHERE ' . $entity . '_id = ' . $id;
      return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE)->current();
    }
    return iterator_to_array($Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE));
  }

  /**
   * @param $entity
   * @return array|\ArrayObject|null
   */

  public static function getEntityCount($entity)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = 'SELECT COUNT(*) FROM ' . $entity . 's';
    return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE)->current();
  }

  /**
   * @param $entity
   * @param $fields
   * @param null $id
   * @param null $order
   * @param null $limit
   * @return array|\ArrayObject|null
   */

  public static function getFieldEntity($entity, $fields, $id = null, $order = null, $limit = null)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    //make fields list
    $sqlField = '';
    if ($fields == null){
      $sqlField = '*';
    } else {
      $arrayCount = count($fields);
      $currentField = 1;
      foreach ($fields AS $field)
      {
        $sqlField .= ($arrayCount != $currentField) ? '`' . $field . '`, ' : '`' . $field . '`';
        ++$currentField;
      }
    }

    $sql = ($id !== null)
      ? 'SELECT ' . $sqlField . ' FROM ' . $entity . 's WHERE ' . $entity . '_id = ' . $id
      : 'SELECT ' . $sqlField . ' FROM ' . $entity . 's';

    if ($order !== null) $sql .= ' ORDER BY `' . $order . '`';
    if ($limit !== null) $sql .= (is_array($limit))
                               ? ' LIMIT ' . (int) $limit['from'] . ', ' . (int) $limit['end']
                               : ' LIMIT ' . (int) $limit;

    if ($id !== null){
      return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE)->current();
    }
    return iterator_to_array($Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE));
  }


  /**
   * @param $entity String
   * @param $setField String
   * @return mixed
   */

  public static function insertEntity($entity, $setField)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = "INSERT INTO `" . $entity . "s` VALUES (DEFAULT, " . $setField . ")";
    return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE);
  }


  /**
   * @param $entity String
   * @param $setString
   * @param $id
   * @return mixed
   */

  public static function updateEntityById($entity, $setString, $id)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = 'UPDATE ' . $entity . 's SET ' . $setString . ' WHERE ' . $entity . '_id = ' . $id;
    return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE);
  }

  /**
   * @param $entity String
   * @param $id
   * @return mixed
   */

  public static function deleteEntityById($entity, $id)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = 'DELETE FROM ' . $entity . 's WHERE ' . $entity . '_id = ' . $id;
    return $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE);
  }

  /**
   * @param $name
   * @param $pass
   * @return mixed
   */

  public static function authenticateUser($name, $pass)
  {
    $Adapter = MyDbAdapter::getDbAdapter();
    $sql = "SELECT * FROM `users` "
         . "WHERE user_name = '" . $name . "' "
         . "AND user_pass = '" . $pass . "'";
    $result = $Adapter->query($sql, $Adapter::QUERY_MODE_EXECUTE);
    $row = $result->current();
    if ($row === false){
      return false;
    }
    return $row;
  }
}