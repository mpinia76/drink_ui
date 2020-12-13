<?php
namespace Drink\UI\components\grid\formats;

use Drink\UI\utils\DrinkUIUtils;

use Drink\Core\model\EstadoPedido;
use Rasty\Grid\entitygrid\model\GridValueFormat;
use Rasty\i18n\Locale;

/**
 * Formato para renderizar el estado de un Pedido
 *
 * @author Marcos
 * @since 27-08-2020
 *
 */

class GridEstadoPedidoFormat extends  GridValueFormat{

	private $pattern;
	
	public function format( $value, $item=null ){
		
		if( !empty($value))
			return  Locale::localize( EstadoPedido::getLabel( $value ) );
		else $value;	
	}		
	
	public function getPattern(){
		return $this->pattern;
	}
	
	public function getColumnCssClass($value, $item=null){
	
		return DrinkUIUtils::getEstadoPedidoCss($value);
	}
}