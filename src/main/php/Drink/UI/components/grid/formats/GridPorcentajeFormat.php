<?php
namespace Drink\UI\components\grid\formats;

use Drink\UI\utils\DrinkUIUtils;

use Drink\Core\model\Sucursal;
use Drink\Core\model\Producto;
use Rasty\i18n\Locale;
use Rasty\Grid\entitygrid\model\GridValueFormat;

/**
 * Formato para porcentaje
 *
 * @author Bernardo
 * @since 10-06-2014
 *
 */

class GridPorcentajeFormat extends  GridValueFormat{

	public function __construct(){
	
	}
	
	public function format( $value, $item=null ){
		
		if( $value !=null )
			return  DrinkUIUtils::formatPorcentajeToView($value);
		else $value;	
	}		
	

}