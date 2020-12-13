<?php
namespace Drink\UI\components\grid\formats;

use Drink\UI\utils\DrinkUIUtils;
use Rasty\Grid\entitygrid\model\GridValueFormat;

use Drink\Core\model\Sucursal;
use Drink\Core\model\Producto;
use Rasty\i18n\Locale;

/**
 * Formato para imprte
 *
 * @author Marcos
 * @since 12-03-2018
 *
 */

class GridImporteFormat extends  GridValueFormat{
	
	private $simbolo;
	
	public function __construct($simbolo=null){
		$this->simbolo = $simbolo;
	}
	
	public function format( $value, $item=null ){
		
		if( $value !=null )
			return  DrinkUIUtils::formatMontoToView($value, $this->getSimbolo());
		else $value;	
	}		
	


	public function getSimbolo()
	{
	    return $this->simbolo;
	}

	public function setSimbolo($simbolo)
	{
	    $this->simbolo = $simbolo;
	}
}