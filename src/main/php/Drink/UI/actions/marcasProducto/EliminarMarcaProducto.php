<?php
namespace Drink\UI\actions\marcasProducto;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\MarcaProducto;
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
 * se eliminar un marca de documento
 * 
 * @author Marcos
 * @since 05/03/2018
 */
class EliminarMarcaProducto extends JsonAction{

	
	public function execute(){

		try {

			$marcaProductoOid = RastyUtils::getParamGET("marcaProductoOid");
			
			//obtenemos la marcaProducto
			$marcaProducto = UIServiceFactory::getUIMarcaProductoService()->get($marcaProductoOid);

			UIServiceFactory::getUIMarcaProductoService()->delete($marcaProducto);
			
			$result["info"] = Locale::localize("marcaProducto.borrar.success")  ;
			
		} catch (RastyException $e) {
		
			$result["error"] = Locale::localize($e->getMessage())  ;
			
		}
		
		return $result;		
		
	}
}
?>