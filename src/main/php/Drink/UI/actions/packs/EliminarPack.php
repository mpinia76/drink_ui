<?php
namespace Drink\UI\actions\packs;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\Pack;
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
 * @since 28/03/2019
 */
class EliminarPack extends JsonAction{

	
	public function execute(){

		try {

			$packOid = RastyUtils::getParamGET("packOid");
			
			//obtenemos la pack
			$pack = UIServiceFactory::getUIPackService()->get($packOid);

			UIServiceFactory::getUIPackService()->delete($pack);
			
			$result["info"] = Locale::localize("pack.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>