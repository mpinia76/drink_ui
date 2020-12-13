<?php
namespace Drink\UI\pages\balances;

use Drink\UI\pages\DrinkPage;

use Drink\UI\components\filter\model\UIProductoCriteria;

use Drink\UI\components\grid\model\RankProductoGridModel;

use Drink\UI\service\UIProductoService;

use Drink\UI\utils\DrinkUtils;

use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Drink\Core\model\Producto;
use Drink\Core\criteria\ProductoCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;


use Drink\UI\utils\DrinkUIUtils;
use Drink\UI\service\UIServiceFactory;


/**
 * Página para consultar los productos.
 *
 * @author Marcos
 * @since 22/10/2020
 *
 */
class BalanceRankProductoGrid extends DrinkPage{

	private $productoCriteria;

	public function __construct(){
		/*$productoCriteria = new ProductoCriteria();

		$productoCriteria->setVendedor(UIServiceFactory::getUIVendedorService()->get(DrinkUIUtils::getVendedorSession() ));
		$this->setProductoCriteria($productoCriteria);*/
	}

	public function getTitle(){
		return $this->localize( "balanceRankProducto.title" );
	}



	public function getType(){

		return "BalanceRankProducto";

	}

	public function getModelClazz(){
		return get_class( new RankProductoGridModel() );
	}

	public function getUicriteriaClazz(){
		return get_class( new UIProductoCriteria() );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );


	}


	public function getProductoCriteria()
	{
	    return $this->productoCriteria;
	}

	public function setProductoCriteria($productoCriteria)
	{
	    $this->productoCriteria = $productoCriteria;
	}
}
?>
