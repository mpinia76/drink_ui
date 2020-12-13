<?php
namespace Drink\UI\pages\packs\modificar;

use Drink\UI\pages\DrinkPage;

use Drink\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Drink\Core\model\Pack;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class PackModificar extends DrinkPage{

	/**
	 * pack a modificar.
	 * @var Pack
	 */
	private $pack;

	
	public function __construct(){
		
		//inicializamos el pack.
		$pack = new Pack();
		$this->setPack($pack);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setPackOid($oid){
		
		//a partir del id buscamos el pack a modificar.
		$pack = UIServiceFactory::getUIPackService()->get($oid);
		
		$this->setPack($pack);
		
	}
	
	public function getTitle(){
		return $this->localize( "pack.modificar.title" );
	}

	public function getType(){
		
		return "PackModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getPack(){
		
	    return $this->pack;
	}

	public function setPack($pack)
	{
	    $this->pack = $pack;
	}
}
?>