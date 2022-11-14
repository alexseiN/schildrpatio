<?php

namespace App\Models\backend;

use CodeIgniter\Model;

class Allvisitors extends Model{

    protected $_table_name = 'allvisitors';
    protected $_order_by = 'time';

    function __construct(){
        parent::__construct();
        $this->AllvisitorsModel = new Allvisitorsmodel();
    }

}
?>