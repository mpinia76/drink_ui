<?php
namespace Drink\UI\actions\vendedores;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\Vendedor;
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
 * @since 21/07/2020
 */
class EliminarVendedor extends JsonAction{

	
	public function execute(){

		try {

			$vendedorOid = RastyUtils::getParamGET("vendedorOid");
			
			//obtenemos la vendedor
			$vendedor = UIServiceFactory::getUIVendedorService()->get($vendedorOid);

			UIServiceFactory::getUIVendedorService()->delete($vendedor);
			
			$result["info"] = Locale::localize("vendedor.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>