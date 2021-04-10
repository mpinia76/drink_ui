<?php
namespace Drink\UI\pages\presupuestos\agregar;

use Datetime;
use Drink\Core\utils\DrinkUtils;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\pages\DrinkPage;

use Rasty\utils\XTemplate;
use Drink\Core\model\Presupuesto;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Drink\UI\service\UIServiceFactory;


use Rasty\utils\RastyUtils;

class PresupuestoAgregar extends DrinkPage{

	/**
	 * presupuesto a agregar.
	 * @var Presupuesto
	 */
	private $presupuesto;


	public function __construct(){

		//inicializamos el presupuesto.
		$presupuesto = new Presupuesto();

		$presupuesto->setFecha( new Datetime() );

		if(RastyUtils::getParamGET("clienteOid") ){
			$cliente = UIServiceFactory::getUIClienteService()->get( RastyUtils::getParamGET("clienteOid") );
			$presupuesto->setCliente($cliente );
		}
		else{
			$presupuesto->setCliente( DrinkUtils::getClienteDefault() );
		}

        $presupuesto->setVendedor(UIServiceFactory::getUIVendedorService()->get(DrinkUIUtils::getVendedorSession() ));

		$this->setPresupuesto($presupuesto);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Presupuestos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "presupuesto.agregar.title" );
	}

	public function getType(){

		return "PresupuestoAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		DrinkUIUtils::setDetallesPresupuestoSession( array() );
	}


	public function getPresupuesto()
	{
	    return $this->presupuesto;
	}

	public function setPresupuesto($presupuesto)
	{
	    $this->presupuesto = $presupuesto;
	}



	public function getMsgError(){
		return "";
	}
}
?>
