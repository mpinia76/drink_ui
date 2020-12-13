<?php
namespace Drink\UI\actions\combos;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\Combo;
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
 * se eliminar un tipo de documento
 * 
 * @author Marcos
 * @since 29/08/2019
 */
class EliminarCombo extends JsonAction{

	
	public function execute(){

		try {

			$comboOid = RastyUtils::getParamGET("comboOid");
			
			//obtenemos la combo
			$combo = UIServiceFactory::getUIComboService()->get($comboOid);

			UIServiceFactory::getUIComboService()->delete($combo);
			
			$result["info"] = Locale::localize("combo.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>