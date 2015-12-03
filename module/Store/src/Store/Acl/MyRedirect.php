<?php
namespace Store\Acl;

use Zend\Http\Response;

class MyRedirect
{
  public static function toUrl($url)
  {
    $response = new Response();
    $response->getHeaders()->addHeaderLine('Location', $url);
    $response->setStatusCode(302);
    return $response;
  }
}