<?php
namespace Drink\UI\pages\pedidos\agregar;

use Datetime;
use Drink\Core\utils\DrinkUtils;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\pages\DrinkPage;

use Rasty\utils\XTemplate;
use Drink\Core\model\Pedido;
use Rasty\Menu\menu\model\MenuGroup;
use Rasty\Menu\menu\model\MenuOption;

/**
 * Page para agregar un pedido
 *
 * @author Marcos
 * @since 10-07-2020
 *
 */
class PedidoAgregar extends DrinkPage{

	/**
	 * pedido a agregar.
	 * @var Pedido
	 */
	private $pedido;


	public function __construct(){

		//inicializamos el pedido.
		$pedido = new Pedido();

		$pedido->setFechaHora( new Datetime() );
		//$pedido->setProveedor( DrinkUtils::getProveedorDefault() );

		$this->setPedido($pedido);


	}

	public function getMenuGroups(){

		//TODO construirlo a partir del usuario
		//y utilizando permisos

		$menuGroup = new MenuGroup();

//		$menuOption = new MenuOption();
//		$menuOption->setLabel( $this->localize( "form.volver") );
//		$menuOption->setPageName("Pedidos");
//		$menuGroup->addMenuOption( $menuOption );
//

		return array($menuGroup);
	}

	public function getTitle(){
		return $this->localize( "pedido.agregar.title" );
	}

	public function getType(){

		return "PedidoAgregar";

	}

	protected function parseXTemplate(XTemplate $xtpl){

		DrinkUIUtils::setDetallesPedidoSession( array() );

        $pedidoForm = $this->getComponentById("pedidoForm");
        $pedidoForm->fillFromSaved( $this->getPedido() );
	}


	public function getPedido()
	{
	    return $this->pedido;
	}

	public function setPedido($pedido)
	{
	    $this->pedido = $pedido;
	}



	public function getMsgError(){
		return "";
	}
}
?>
