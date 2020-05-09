<?php

class Home extends Dojo_controller
{
  public function index()
  {
    $data['page'] = 'Dojomvc framework PHP'; //send a data name page [assoc array] to the [views]
    $this->view('Home/index', $data); //running view with send a data
  }
}