<?php
namespace Drink\UI\actions\ventas;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\Venta;
use Drink\Core\utils\DrinkUtils;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se anula una venta
 * 
 * @author Marcos
 * @since 13/03/2018
 */
class AnularVenta extends Action{

	
	public function execute(){

		$forward = new Forward();
		
		
		//tomamos la venta
		$ventaOid = RastyUtils::getParamPOST("ventaOid");
		$forward->addParam( "ventaOid", $ventaOid );
		try {

			//la recuperamos la venta.
			$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );
			
			$user = RastySecurityContext::getUser();
			$user = DrinkUtils::getUserByUsername($user->getUsername());
			
			UIServiceFactory::getUIVentaService()->anular($venta, $user);			
			
			$forward->setPageName( "Ventas" );
		
			
		} catch (RastyException $e) {
		
			$forward->setPageName( "VentaAnular" );
			$forward->addError( Locale::localize($e->getMessage())  );
			
		}
		
		return $forward;
		
	}

}
?>