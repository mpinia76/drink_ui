<?php
namespace Drink\UI\pages\balances;

use Drink\UI\pages\DrinkPage;

use Drink\UI\components\filter\model\UIProductoCriteria;



use Drink\UI\service\UIVentaService;

use Drink\UI\utils\DrinkUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Drink\Core\model\Caja;
use Drink\Core\criteria\VentaCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar las balances.
 *
 * @author Marcos
 * @since 22/10/2020
 *
 */
class BalanceRankProducto extends DrinkPage{



	public function __construct(){

	}

	public function getTitle(){
		return $this->localize("balanceRankProducto.title") ;
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();




		return array($menuGroup);
	}

	public function getType(){

		return "BalanceRankProducto";

	}


	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}



}
?>
