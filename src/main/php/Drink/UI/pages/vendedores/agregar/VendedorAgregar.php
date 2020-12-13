<?php
namespace Drink\UI\pages\vendedores\agregar;

use Drink\Core\utils\DrinkUtils;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\pages\DrinkPage;

use Rasty\utils\XTemplate;
use Drink\Core\model\Vendedor;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class VendedorAgregar extends DrinkPage{

	/**
	 * vendedor a agregar.
	 * @var Vendedor
	 */
	private $vendedor;

	
	public function __construct(){
		
		//inicializamos el vendedor.
		$vendedor = new Vendedor();
		
		
		
		$this->setVendedor($vendedor);

		
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Vendedores");
//		$menuGroup->addMenuOption( $menuOption );
//		
		
		return array($menuGroup);
	}
	
	public function getTitle(){
		return $this->localize( "vendedor.agregar.title" );
	}

	public function getType(){
		
		return "VendedorAgregar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
		
		$vendedorForm = $this->getComponentById("vendedorForm");
		$vendedorForm->fillFromSaved( $this->getVendedor() );
	}


	public function getVendedor()
	{
	    return $this->vendedor;
	}

	public function setVendedor($vendedor)
	{
	    $this->vendedor = $vendedor;
	}
	
	
					
	public function getMsgError(){
		return "";
	}
}
?>