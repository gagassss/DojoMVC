<?php

class Notfound extends Dojo_controller
{
  public function index()
  {
    $data['page'] = 'Page Not Found';
    $this->view('error/404', $data); //running view with send a data
  }
}