<?php
namespace Store\Basket;

use Store\Entity\Product;

class ShopBasket
{
  private $products = array();

  public function showBasket()
  {
    $this->exchangeProducts();

    echo '<div class="basket"><img src="/img/basket.png" alt="">';
    echo '<span class="count">' . $this->getProductsCount() . '</span><div name="basket">';
    echo '<div class="basketTitle"><a href="">Корзина</a></div>';
    echo '<ul class="basketProductList">';
    $this->getProducts();
    echo '</ul>';
    echo '<div class="basketOrderButton"><a href=""><button class="purchaseButton">Замовити</button></a></div>';
    echo '</div></div>';
  }

  private function getProducts()
  {
    if ($this->products) {
      ksort($this->products);
      foreach ($this->products AS $id => $qua){
        echo '<li><span name="qua">' . $qua . 'x</span> '
          . '<span name="product">' . Product::getProduct($id)['product_name'] . '</span>'
          . '<button onclick="deleteProductFromBasket(' . $id . ', 1)">'
          . '<img src="/img/delete.png" alt="X">'
          . '</button>'
          . '</li>';
      }
    } else {
      echo '<li>Корзина порожня</li>';
    }
  }

  public static function getUpdatedProducts()
  {
    $list = '';
    if (isset($_COOKIE['basket'])) {
      $products = $_COOKIE['basket'];
      ksort($products);
      foreach ($products AS $product)
      {
        $product = json_decode($product);
        $list .= '<li><span name="qua">' . $product->quantity . 'x</span> '
              . '<span name="product">' . Product::getProduct($product->id)['product_name'] . '</span>'
              . '<button onclick="deleteProductFromBasket(' . $product->id . ', 1)">'
              . '<img src="/img/delete.png" alt="X">'
              . '</button>'
              . '</li>';
      }
    } else {
      $list = '<li>Корзина порожня</li>';
    }
    return $list;
  }

  private function exchangeProducts()
  {
    if (isset($_COOKIE['basket'])) {
      foreach ($_COOKIE['basket'] AS $product)
      {
        $product = json_decode($product);
        $this->products[$product->id] = $product->quantity;
      }
    }
  }

  private function getProductsCount()
  {
    $count = 0;
    if (count($this->products) > 0) {
      foreach ($this->products AS $quantity)
      {
        $count += $quantity;
      }
    }
    return $count;
  }

  public function sortProducts($products)
  {
    ksort($products);
  }
}
