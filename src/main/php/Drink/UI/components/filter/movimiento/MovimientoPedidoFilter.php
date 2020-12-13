<?php

namespace Drink\UI\components\filter\movimiento;


use Drink\UI\service\UIServiceFactory;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\components\grid\model\MovimientoPedidoGridModel;

use Drink\UI\components\filter\model\UIMovimientoPedidoCriteria;


use Rasty\Grid\filter\Filter;
use Rasty\utils\XTemplate;
use Rasty\utils\LinkBuilder;

/**
 * Filtro para buscar movimientos de Pedido
 * 
 * @author Marcos
 * @since 28-08-2020
 */
class MovimientoPedidoFilter extends Filter{
		
	
	
	public function getType(){
		
		return "MovimientoPedidoFilter";
	}
	
	public function __construct(){
		
		parent::__construct();
		
		$this->setGridModelClazz( get_class( new MovimientoPedidoGridModel() ));
		
		$this->setUicriteriaClazz( get_class( new UIMovimientoPedidoCriteria()) );
		
		
		$this->addProperty("fechaDesde");
		$this->addProperty("fechaHasta");
		
	}
	
	protected function parseXTemplate(XTemplate $xtpl){

		//rellenamos el banco con bapro
		//$this->fillInput("cuenta", UIServiceFactory::getUIBancoService()->getCajaBAPRO() );
		
		parent::parseXTemplate($xtpl);

		$xtpl->assign("lbl_fechaDesde",  $this->localize( "criteria.fechaDesde" ) );
		$xtpl->assign("lbl_fechaHasta",  $this->localize( "criteria.fechaHasta" ) );
		
		
	}
	
	
	
}
?>