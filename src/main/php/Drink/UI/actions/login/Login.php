<?php
namespace Drink\UI\actions\login;

use DateTime;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;

use Drink\Core\utils\DrinkUtils;


use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;



/**
 * se realiza el login contra el core.
 *
 * @author Marcos
 * @since 01/03/2018
 */
class Login extends Action{

	public function isSecure(){
		return false;
	}

	public function execute(){

		$forward = new Forward();
		try {


			RastySecurityContext::login( RastyUtils::getParamPOST("username"), RastyUtils::getParamPOST("password") );

			//DrinkUIUtils::setSucursal( DrinkUtils::getSucursalDefault() );

			$user = RastySecurityContext::getUser();

			$user = DrinkUtils::getUserByUsername($user->getUsername());

			if( DrinkUtils::isAdmin($user)){

				//$empleado = DrinkUtils::getEmpleadoDefault();
				DrinkUIUtils::loginAdmin($user);

			}else{

				//TODO
			}

			/*DrinkUIUtils::login( $empleado );
			//buscamos la caja que esté abierta para el empleado
			$caja = UIServiceFactory::getUICajaService()->getCajaAbiertaByEmpleado($empleado);
			DrinkUIUtils::setCaja($caja);*/

			if( DrinkUIUtils::isAdminLogged() )
				$forward->setPageName( $this->getForwardAdmin() );
			/*elseif( DrinkUIUtils::isCajaSelected() )
				$forward->setPageName( $this->getForwardEmpleado() );*/
			else {//si no hay caja abierta, lo enviamos a abrir una nueva.
                DrinkUIUtils::setVendedorSession(DrinkUtils::DRINK_VENDEDOR_MELISA);
                $forward->setPageName($this->getForwardEmpleado());
            }

		} catch (RastyException $e) {

			$forward->setPageName( $this->getErrorForward() );
			$forward->addError( $e->getMessage() );

		}

		return $forward;

	}

	protected function getForwardEmpleado(){
		return "VentasHome";
	}

	protected function getForwardAdmin(){
		return "AdminHome";
	}

	protected function getForwardCaja(){
		//si hay cajas abiertas lo enviamos a seleccionar una de ellas.

		if( DrinkUIUtils::isAdminLogged() )

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas();

		else

			$cajas = UIServiceFactory::getUICajaService()->getCajasAbiertas( new DateTime() );


		if(count($cajas) > 0)
			return "SeleccionarCaja";
		else
			return "AbrirCaja";
	}

	protected function getErrorForward(){
		return "Login";
	}
}
?>
