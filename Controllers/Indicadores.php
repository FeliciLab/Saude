<?php
namespace Saude\Controllers;

use DateTime;
use \MapasCulturais\App;

class Indicadores extends \MapasCulturais\Controller {

	function GET_index() {
		$this->render('index');
	}
}