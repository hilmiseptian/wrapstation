<?php

class CoreController
{
  public function index()
  {
    include_once('views/layouts/header.php');
    include_once('views/index.php');
    include_once('views/layouts/footer.php');
  }
}
