<?php
class Dojo_controller
{
  protected $base_url,
            $db;
  public function __construct()
  {
    global $config;
    $this->base_url = $config['base_url'];
    if ($config['auto_connect_db'] == true)
    {
      $this->db = new connect_db;
    }
  }
  public function view($view, $data = [])
  {
    require_once 'app/views/' . $view . '.php';
  }

  public function model($model)
  {
    require_once 'app/models/' . $model . '.php';
    return new $model;
  }

  public function database()
  {
    $this->db = new connect_db;
  }
}