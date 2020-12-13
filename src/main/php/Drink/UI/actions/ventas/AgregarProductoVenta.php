<?php
namespace Drink\UI\actions\ventas;

use Drink\UI\utils\DrinkUIUtils;
use Drink\Core\utils\DrinkUtils;

use Drink\UI\service\UIServiceFactory;
use Drink\Core\model\Venta;
use Drink\Core\model\DetalleVenta;

use Rasty\actions\Action;
use Rasty\actions\Forward;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;
use Rasty\exception\RastyDuplicatedException;


/**
 * se cobra una venta en efectivo
 *
 * @author Marcos
 * @since 21/06/2019
 */
class AgregarProductoVenta extends Action{


	public function execute(){

		$forward = new Forward();


		//tomamos la venta
		$ventaOid = RastyUtils::getParamGET("ventaOid");
		$forward->addParam( "ventaOid", $ventaOid );
		try {


			//la recuperamos la venta.
			$venta = UIServiceFactory::getUIVentaService()->get( $ventaOid );





			$detalles = DrinkUIUtils::getDetallesVentaSession();



			$total=0;
			$costo=0;
			foreach ($detalles as $detallejson) {
				$detalle = new DetalleVenta();

				$detalle->setCantidad( $detallejson["cantidad"] );
				$detalle->setPrecioUnitario( $detallejson["precioUnitario"] );
				$detalle->setCosto( $detallejson["costo"] );
				$detalle->setStockActualizado( $detallejson["stockActualizado"] );
				$detalle->setProducto( UIServiceFactory::getUIProductoService()->get($detallejson["producto_oid"]) );

				$venta->addDetalle( $detalle );
				$total += round($detallejson["cantidad"]*$detallejson["precioUnitario"],2);
				$costo += round($detallejson["cantidad"]*$detallejson["costo"],2);
			}
			$monto = $venta->getMonto();
			$montoDebe = $venta->getMontoDebe();
			$venta->setMonto($monto+$total);
			$venta->setMontoDebe($montoDebe+$total);

			//print_r($venta);

			$user = RastySecurityContext::getUser();
			$user = DrinkUtils::getUserByUsername($user->getUsername());

			$cuenta = DrinkUtils::getCuentaUnica();

			UIServiceFactory::getUIVentaService()->agregarProducto($venta,$cuenta,$user);

			$forward->setPageName( "Ventas" );


		} catch (RastyException $e) {

			$forward->setPageName( "VentaAgregarProducto" );
			$forward->addError( Locale::localize($e->getMessage())  );

		}

		return $forward;

	}

}
?>
