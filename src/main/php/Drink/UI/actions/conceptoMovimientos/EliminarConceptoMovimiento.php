<?php
namespace Drink\UI\actions\conceptoMovimientos;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\ConceptoMovimiento;
use Drink\Core\utils\DrinkUtils;

use Rasty\actions\JsonAction;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se eliminar un concepto de gasto
 * 
 * @author Marcos
 * @since 12/03/2018
 */
class EliminarConceptoMovimiento extends JsonAction{

	
	public function execute(){

		try {

			$conceptoMovimientoOid = RastyUtils::getParamGET("conceptoMovimientoOid");
			
			//obtenemos la conceptoMovimiento
			$conceptoMovimiento = UIServiceFactory::getUIConceptoMovimientoService()->get($conceptoMovimientoOid);

			UIServiceFactory::getUIConceptoMovimientoService()->delete($conceptoMovimiento);
			
			$result["info"] = Locale::localize("conceptoMovimiento.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>