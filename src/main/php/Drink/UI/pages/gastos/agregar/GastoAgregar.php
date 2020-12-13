<?php
namespace Drink\UI\pages\gastos\agregar;

use Drink\Core\utils\DrinkUtils;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\pages\DrinkPage;

use Rasty\utils\XTemplate;
use Drink\Core\model\Gasto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class GastoAgregar extends DrinkPage{

	/**
	 * gasto a agregar.
	 * @var Gasto
	 */
	private $gasto;

	
	public function __construct(){
		
		//inicializamos el gasto.
		$gasto = new Gasto();
		
		$gasto->setFecha( new \Datetime() );
		
		$gasto->setConcepto( DrinkUtils::getConceptoGastoVarios() );
		
		$this->setGasto($gasto);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Gastos");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "gasto.agregar.title" );
	}

	public function getType(){
		
		return "GastoAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		
	}


	public function getGasto()
	{
	    return $this->gasto;
	}

	public function setGasto($gasto)
	{
	    $this->gasto = $gasto;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>