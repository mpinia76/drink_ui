<?php
namespace Drink\UI\pages\clientes;

use Drink\UI\pages\DrinkPage;

use Drink\UI\components\filter\model\UIClienteCriteria;

use Drink\UI\components\grid\model\ClienteCtaCteGridModel;

use Drink\UI\service\UIClienteService;


use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;
use Rasty\i18n\Locale;

use Drink\Core\model\Cliente;
use Drink\Core\criteria\ClienteCriteria;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

use Rasty\security\RastySecurityContext;
use Drink\Core\utils\DrinkUtils;


/**
 * Página para consultar las ctas ctes de los clientes.
 *
 * @author Marcos
 * @since 12/09/2019
 *
 */
class ClientesCtaCte extends DrinkPage{


	private $clienteCriteria;

	public function __construct(){
		$clienteCriteria = new ClienteCriteria();


		$this->setClienteCriteria($clienteCriteria);
	}

	public function getTitle(){
		return $this->localize( "clientesCtaCte.title" );
	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos


		$menuGroup = new MenuGroup();


        $user = RastySecurityContext::getUser();

        $user = DrinkUtils::getUserByUsername($user->getUsername());

        if( DrinkUtils::isAdmin($user)) {


            $menuOption = new MenuOption();
            $menuOption->setLabel($this->localize("menu.cobrarCuentaCorriente"));
            $menuOption->setPageName("CobrarCtaCte");
            $menuOption->setImageSource($this->getWebPath() . "css/images/cobros_48.png");
            $menuGroup->addMenuOption($menuOption);

            $menuOption = new MenuOption();
            $menuOption->setLabel($this->localize("menu.actualizarCuentaCorriente"));
            $menuOption->setPageName("ActualizarCtaCte");
            $menuOption->setImageSource($this->getWebPath() . "css/images/gastos_32.png");
            $menuGroup->addMenuOption($menuOption);
        }


		return array($menuGroup);
	}

	public function getType(){

		return "ClientesCtaCte";

	}

	public function getModelClazz(){
		return get_class( new ClienteCtaCteGridModel() );
	}

	public function getUicriteriaClazz(){
		$clienteCriteria = new UIClienteCriteria();
		$clienteCriteria->setTieneCtaCte(1);
		return get_class( $clienteCriteria );
	}

	protected function parseXTemplate(XTemplate $xtpl){

		$xtpl->assign("legend_operaciones", $this->localize("grid.operaciones") );
		$xtpl->assign("legend_resultados", $this->localize("grid.resultados") );

		$clienteFilter = $this->getComponentById("clientesFilter");

		$clienteFilter->fillFromSaved( $this->getClienteCriteria() );
	}

	public function getClienteCriteria()
	{
	    return $this->clienteCriteria;
	}

	public function setClienteCriteria($clienteCriteria)
	{
	    $this->clienteCriteria = $clienteCriteria;
	}

}
?>
