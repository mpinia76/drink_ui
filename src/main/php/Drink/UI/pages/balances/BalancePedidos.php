<?php
namespace Drink\UI\pages\balances;

use Drink\UI\pages\DrinkPage;

use Drink\UI\components\filter\model\UIPedidoCriteria;

use Drink\UI\components\grid\model\BalancePedidoGridModel;

use Drink\UI\service\UIPedidoService;

use Drink\UI\utils\DrinkUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Drink\Core\model\Pedido;
use Drink\Core\criteria\PedidoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


/**
 * Página para consultar los pedidos.
 *
 * @author Marcos
 * @since 23-10-2020
 *
 */
class BalancePedidos extends DrinkPage{


	public function __construct(){

	}

	public function getTitle(){
		return $this->localize( "pedidos.title" );
	}



	public function getType(){

		return "BalancePedidos";

	}

	public function getModelClazz(){
		return get_class( new BalancePedidoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIPedidoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}

}
?>
