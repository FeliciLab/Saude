<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;

class Edital extends \MapasCulturais\Controller{


    function GET_index(){
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
       
        $this->render('single');
    }

}