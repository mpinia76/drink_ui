<?php
namespace Drink\UI\pages\marcasProducto\modificar;

use Drink\UI\pages\DrinkPage;

use Drink\UI\service\UIServiceFactory;

use Rasty\utils\XTemplate;
use Drink\Core\model\MarcaProducto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

class MarcaProductoModificar extends DrinkPage{

	/**
	 * marcaProducto a modificar.
	 * @var MarcaProducto
	 */
	private $marcaProducto;

	
	public function __construct(){
		
		//inicializamos el marcaProducto.
		$marcaProducto = new MarcaProducto();
		$this->setMarcaProducto($marcaProducto);
				
	}
	
	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		return array($menuGroup);
	}
	
	public function setMarcaProductoOid($oid){
		
		//a partir del id buscamos el marcaProducto a modificar.
		$marcaProducto = UIServiceFactory::getUIMarcaProductoService()->get($oid);
		
		$this->setMarcaProducto($marcaProducto);
		
	}
	
	public function getTitle(){
		return $this->localize( "marcaProducto.modificar.title" );
	}

	public function getType(){
		
		return "MarcaProductoModificar";
		
	}	

	protected function parseXTemplate(XTemplate $xtpl){
		
	}

	public function getMarcaProducto(){
		
	    return $this->marcaProducto;
	}

	public function setMarcaProducto($marcaProducto)
	{
	    $this->marcaProducto = $marcaProducto;
	}
}
?>