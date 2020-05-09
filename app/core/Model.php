<?php

class Dojo_model
{
  protected $db;
  public function __construct()
  {
    global $config;
    $this->db = new database;
    if ($config['auto_connect_db'] == true)
    {
      $this->db = new connect_db;
    }

  }

  public function database()
  {
    $this->db = new connect_db;
  }
}