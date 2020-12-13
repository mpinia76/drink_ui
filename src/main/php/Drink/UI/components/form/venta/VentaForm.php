<?php

namespace Drink\UI\components\form\venta;

use Cose\Security\service\ServiceFactory;
use Drink\UI\service\finder\ClienteFinder;



use Drink\UI\components\filter\model\UIVendedorCriteria;

use Drink\UI\service\finder\VendedorFinder;

use Drink\UI\service\finder\ProductoFinder;
use Drink\UI\service\finder\ComboFinder;
use Drink\UI\service\finder\PackFinder;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;

use Rasty\Forms\form\Form;

use Rasty\components\RastyComponent;
use Rasty\utils\XTemplate;
use Rasty\utils\RastyUtils;


use Drink\Core\model\Venta;
use Drink\Core\model\DetalleVenta;
use Drink\Core\model\Vendedor;


use Rasty\utils\LinkBuilder;
use Rasty\security\RastySecurityContext;

use Rasty\utils\Logger;

/**
 * Formulario para venta

 * @author Marcos
 * @since 09/03/2018
 */
class VentaForm extends Form{



	/**
	 * label para el cancel
	 * @var string
	 */
	private $labelCancel;


	/**
	 *
	 * @var Venta
	 */
	private $venta;

	private $detalle;

	public function __construct(){

		parent::__construct();
		$this->setLabelCancel("venta.cancelar");
		$this->setLabelSubmit("venta.confirmar");

		$this->addProperty("fecha");

		$this->addProperty("cliente");
		$this->addProperty("vendedor");
		$this->addProperty("observaciones");

		$this->setBackToOnSuccess("VentaCobrar");
		$this->setBackToOnCancel("Ventas");

	}

	public function getOid(){

		return $this->getComponentById("oid")->getPopulatedValue( $this->getMethod() );
	}


	public function getType(){

		return "VentaForm";

	}

	public function fillEntity($entity){

		//le agregamos los detalles de sesión.
		$detalles = DrinkUIUtils::getDetallesVentaSession();


		parent::fillEntity($entity);


		foreach ($detalles as $detallejson) {

			$detalle = new DetalleVenta();

			$detalle->setCantidad( $detallejson["cantidad"] );
			$detalle->setPrecioUnitario( $detallejson["precioUnitario"] );
			$detalle->setCosto( $detallejson["costo"] );
			$detalle->setStockActualizado( $detallejson["stockActualizado"] );
			$detalle->setProducto( UIServiceFactory::getUIProductoService()->get($detallejson["producto_oid"]) );
			if ($detallejson["combo_oid"]) {
				$detalle->setCombo( UIServiceFactory::getUIComboService()->get($detallejson["combo_oid"]) );
			}


			$entity->addDetalle( $detalle );

		}

		$user = RastySecurityContext::getUser();
		$user = ServiceFactory::getUserService()->getUserByUsername($user->getUsername());
		$entity->setUser( $user );


	}

	protected function parseXTemplate(XTemplate $xtpl){

		parent::parseXTemplate($xtpl);

		$xtpl->assign("cancel", $this->getLinkCancel() );
		$xtpl->assign("lbl_cancel", $this->localize( $this->getLabelCancel() ) );

		$xtpl->assign("lbl_fecha", $this->localize("venta.fecha") );

		$xtpl->assign("lbl_cliente", $this->localize("venta.cliente") );
		$xtpl->assign("lbl_vendedor", $this->localize("venta.vendedor") );
		$xtpl->assign("lbl_observaciones", $this->localize("venta.observaciones") );

		$xtpl->assign("detalles_legend", $this->localize("venta.agregar.detalles_legend") );
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "venta.detalle.precio" ) );
		$xtpl->assign("lbl_detalle_cantidad", $this->localize( "venta.detalle.cantidad" ) );
		$xtpl->assign("lbl_detalle_subtotal", $this->localize( "venta.detalle.subtotal" ) );


		$xtpl->assign("linkConsultarStockDetalle", $this->getLinkActionConsultarStockDetalle() );
		$xtpl->assign("linkAgregarDetalle", $this->getLinkActionAgregarDetalle() );
		$xtpl->assign("linkBorrarDetalle", $this->getLinkActionBorrarDetalle() );

		$xtpl->assign("linkAgregarCombo", $this->getLinkActionAgregarCombo() );

		$xtpl->assign("linkConsultarMayorista", $this->getLinkActionConsultarMayorista() );

		$oVendedor = UIServiceFactory::getUIVendedorService()->get(DrinkUIUtils::getVendedorSession() );

		$xtpl->assign("mayorista", $oVendedor->getMayorista() );

	}


	public function getLabelCancel()
	{
	    return $this->labelCancel;
	}

	public function setLabelCancel($labelCancel)
	{
	    $this->labelCancel = $labelCancel;
	}

	public function getLinkCancel(){
		$params = array();

		return LinkBuilder::getPageUrl( $this->getBackToOnCancel() , $params) ;
	}



	public function getProductoFinderClazz(){

		return get_class( new ProductoFinder() );

	}

	public function getVenta()
	{
	    return $this->venta;
	}

	public function setVenta($venta)
	{
	    $this->venta = $venta;
	}

	public function getDetalle()
	{
	    return $this->detalle;
	}

	public function setDetalle($detalle)
	{
	    $this->detalle = $detalle;
	}


	public function getLinkActionAgregarDetalle(){

		return LinkBuilder::getActionAjaxUrl( "AgregarDetalleVentaJson") ;

	}

	public function getLinkActionConsultarStockDetalle(){

		return LinkBuilder::getActionAjaxUrl( "ConsultarStockDetalleVentaJson") ;

	}

	public function getLinkActionConsultarMayorista(){

		return LinkBuilder::getActionAjaxUrl( "ConsultarVendedorMayoristaJson") ;

	}

	public function getLinkActionBorrarDetalle(){

		return LinkBuilder::getActionAjaxUrl( "BorrarDetalleVentaJson") ;

	}

	public function getLinkActionAgregarCombo(){

		return LinkBuilder::getActionAjaxUrl( "AgregarComboVentaJson") ;

	}



	public function getClienteFinderClazz(){

		return get_class( new ClienteFinder() );

	}

	public function getComboFinderClazz(){

		return get_class( new ComboFinder() );

	}

	public function getPackFinderClazz(){

		return get_class( new PackFinder() );

	}

	public function getVendedorFinderClazz(){

		return get_class( new VendedorFinder() );

	}


	public function getVendedores(){

		$vendedores = UIServiceFactory::getUIVendedorService()->getList( new UIVendedorCriteria());

		return $vendedores;
	}

	public function getLinkActionAgregarCliente(){

		return LinkBuilder::getActionUrl( "AgregarCliente") ;

	}
}
?>
