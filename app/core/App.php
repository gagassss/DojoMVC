<?php

class App
{
  protected $controller;
  protected $method;
  protected $params = []; //params in URL
  public function __construct()
  {
    global $config;
    $this->controller = $config['controller_default'];
    $this->method = 'index';
    $url = $this->parse_URL();
    // controller
    if ($url !== null) {
      if(file_exists('app/controllers/' . $url[0] . '.php'))
      {
        $this->controller = $url[0];
        unset($url[0]);
      } else {
          $this->controller = $config['404_controller'];
      }
    }

    require_once 'app/controllers/' . $this->controller . '.php';
    $this->controller = new $this->controller;

    // method

    if(isset($url[1]))
    {
      if (method_exists($this->controller, $url[1]))
      {
        $this->method = $url[1];
        unset($url[1]);
      }
    }
    // params

    if(!empty($url))
    {
      $this->params = array_values($url);
    }
    // running controller,method & send a params
    call_user_func_array([$this->controller, $this->method], $this->params);


  }

  public function parse_URL()
  {
    if (isset($_GET['url']))
    {
      $url = rtrim($_GET['url'], '/');
      $url = filter_var($url, FILTER_SANITIZE_URL);
      $url = explode('/', $url);
      return $url;
    }
  }
}