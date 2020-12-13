<?php

namespace Drink\UI\layouts;

use Rasty\Layout\layout\Rasty\Layout;

use Rasty\utils\XTemplate;


class DrinkLoginMetroLayout extends DrinkMetroLayout{

	public function getXTemplate($file_template=null){
		return parent::getXTemplate( dirname(__DIR__) . "/layouts/DrinkLoginMetroLayout.htm" );
	}

	public function getType(){
		
		return "DrinkLoginMetroLayout";
		
	}	

}
?>