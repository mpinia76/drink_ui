<?php

namespace Drink\UI\components\footer;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;


class FooterDrink extends RastyComponent{


	public function __construct(){
	}

	public function getType(){

		return "FooterDrink";

	}

	protected function parseXTemplate(XTemplate $xtpl){

        $xtpl->assign('year', date('Y'));
	}

}
?>
