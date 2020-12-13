<?php
namespace Drink\UI\pages\vendedores;

use Drink\UI\pages\DrinkPage;

use Drink\UI\components\filter\model\UIVendedorCriteria;

use Drink\UI\components\grid\model\VendedorGridModel;

use Drink\UI\service\UIVendedorService;

use Drink\UI\utils\DrinkUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Drink\Core\model\Vendedor;
use Drink\Core\criteria\VendedorCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los vendedores.
 * 
 * @author Marcos
 * @since 21-07-2020
 * 
 */
class Vendedores extends DrinkPage{

	
	public function __construct(){
		
	}
	
	public function getTitle(){
		return $this->localize( "vendedores.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario 
		//y utilizando permisos
		
		$menuGroup = new MenuGroup();
		
		$menuOption = new MenuOption();
		$menuOption->setLabel( $this->localize( "menu.vendedores.agregar") );
		$menuOption->setPageName("VendedorAgregar");
		$menuOption->setIconClass( "icon-vendedores");
		$menuGroup->addMenuOption( $menuOption );
		
		
		return array($menuGroup);
	}
	
	public function getType(){
		
		return "Vendedores";
		
	}	

	public function getModelClazz(){
		return get_class( new VendedorGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIVendedorCriteria() );
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );
		
		$xtpl->assign("agregar_label", $this->localize("vendedor.agregar") );
	}

}
?>