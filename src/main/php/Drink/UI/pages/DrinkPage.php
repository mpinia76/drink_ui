<?php
namespace Drink\UI\pages;

use Drink\UI\utils\DrinkUIUtils;

use Drink\Core\model\Cuenta;
use Drink\Core\model\Gasto;
use Drink\Core\model\Venta;
use Drink\Core\model\Presupuesto;
use Drink\Core\model\Pedido;

use Rasty\components\RastyPage;
use Rasty\utils\LinkBuilder;

/**
 * página genérica para la app de cuentas
 *
 * @author Marcos
 * @since 01/03/2018
 */
abstract class DrinkPage extends RastyPage{



	public function getTitle(){
		return $this->localize( "cuentas_app.title" );
	}

	public function getMenuGroups(){

		return array();
	}

	public function getLinkDrink(){

		return LinkBuilder::getPageUrl( "Drink") ;

	}



	public function getLinkTiposProducto(){

		return LinkBuilder::getPageUrl( "TiposProducto") ;

	}

	public function getLinkTipoProductoAgregar(){

		return LinkBuilder::getPageUrl( "TipoProductoAgregar") ;

	}

	public function getLinkActionAgregarTipoProducto(){

		return LinkBuilder::getActionUrl( "AgregarTipoProducto") ;

	}

	public function getLinkActionModificarTipoProducto(){

		return LinkBuilder::getActionUrl( "ModificarTipoProducto") ;

	}



	public function getLinkMarcasProducto(){

		return LinkBuilder::getPageUrl( "MarcasProducto") ;

	}

	public function getLinkMarcaProductoAgregar(){

		return LinkBuilder::getPageUrl( "MarcaProductoAgregar") ;

	}

	public function getLinkActionAgregarMarcaProducto(){

		return LinkBuilder::getActionUrl( "AgregarMarcaProducto") ;

	}

	public function getLinkActionModificarMarcaProducto(){

		return LinkBuilder::getActionUrl( "ModificarMarcaProducto") ;

	}

	public function getLinkIvas(){

		return LinkBuilder::getPageUrl( "Ivas") ;

	}

	public function getLinkIvaAgregar(){

		return LinkBuilder::getPageUrl( "IvaAgregar") ;

	}

	public function getLinkActionAgregarIva(){

		return LinkBuilder::getActionUrl( "AgregarIva") ;

	}

	public function getLinkActionModificarIva(){

		return LinkBuilder::getActionUrl( "ModificarIva") ;

	}



	public function getLinkEstadoAgregar(){

		return LinkBuilder::getPageUrl( "EstadoAgregar") ;

	}

	public function getLinkActionAgregarEstado(){

		return LinkBuilder::getActionUrl( "AgregarEstado") ;

	}

	public function getLinkActionModificarEstado(){

		return LinkBuilder::getActionUrl( "ModificarEstado") ;

	}

	public function getLinkConceptoGastos(){

		return LinkBuilder::getPageUrl( "ConceptoGastos") ;

	}

	public function getLinkConceptoGastoAgregar(){

		return LinkBuilder::getPageUrl( "ConceptoGastoAgregar") ;

	}

	public function getLinkActionAgregarConceptoGasto(){

		return LinkBuilder::getActionUrl( "AgregarConceptoGasto") ;

	}

	public function getLinkActionModificarConceptoGasto(){

		return LinkBuilder::getActionUrl( "ModificarConceptoGasto") ;

	}

	public function getLinkConceptoMovimientos(){

		return LinkBuilder::getPageUrl( "ConceptoMovimientos") ;

	}

	public function getLinkConceptoMovimientoAgregar(){

		return LinkBuilder::getPageUrl( "ConceptoMovimientoAgregar") ;

	}

	public function getLinkActionAgregarConceptoMovimiento(){

		return LinkBuilder::getActionUrl( "AgregarConceptoMovimiento") ;

	}

	public function getLinkActionModificarConceptoMovimiento(){

		return LinkBuilder::getActionUrl( "ModificarConceptoMovimiento") ;

	}

	public function getLinkClientes(){

		return LinkBuilder::getPageUrl( "Clientes") ;

	}



	public function getLinkClientesCtaCte(){

		return LinkBuilder::getPageUrl( "ClientesCtaCte") ;

	}

	public function getLinkClienteAgregar(){

		return LinkBuilder::getPageUrl( "ClienteAgregar") ;

	}

	public function getLinkActionAgregarCliente(){

		return LinkBuilder::getActionUrl( "AgregarCliente") ;

	}

	public function getLinkActionModificarCliente(){

		return LinkBuilder::getActionUrl( "ModificarCliente") ;

	}

	public function getLinkActionCobrarCuentaCorriente(){

		return LinkBuilder::getActionUrl( "CobrarCuentaCorriente") ;

	}

	public function getLinkActionActualizarCuentaCorriente(){

		return LinkBuilder::getActionUrl( "ActualizarCuentaCorriente") ;

	}


	public function getLinkProductos(){

		return LinkBuilder::getPageUrl( "Productos") ;

	}

	public function getLinkProductosPdf(){

		return LinkBuilder::getPdfUrl( "ProductosPDF") ;

	}

	public function getLinkProductosXls(){

		return LinkBuilder::getPageUrl( "ProductosXLS") ;

	}

	public function getLinkPreciosPdf(){

		return LinkBuilder::getPdfUrl( "PreciosPDF") ;

	}

	public function getLinkPreciosXls(){

		return LinkBuilder::getPageUrl( "PreciosXLS") ;

	}

	public function getLinkProductoAgregar(){

		return LinkBuilder::getPageUrl( "ProductoAgregar") ;

	}

	public function getLinkActionAgregarProducto(){

		return LinkBuilder::getActionUrl( "AgregarProducto") ;

	}

	public function getLinkActionModificarProducto(){

		return LinkBuilder::getActionUrl( "ModificarProducto") ;

	}

	public function getLinkPacks(){

		return LinkBuilder::getPageUrl( "Packs") ;

	}

	public function getLinkPackAgregar(){

		return LinkBuilder::getPageUrl( "PackAgregar") ;

	}

	public function getLinkActionAgregarPack(){

		return LinkBuilder::getActionUrl( "AgregarPack") ;

	}

	public function getLinkActionModificarPack(){

		return LinkBuilder::getActionUrl( "ModificarPack") ;

	}








	public function getLinkGastos(){

		return LinkBuilder::getPageUrl( "Gastos") ;

	}

	public function getLinkGastoAgregar($backTo = "GastoPagar"){



		return LinkBuilder::getPageUrl( "GastoAgregar", array("backTo" => $backTo )) ;

	}

	public function getLinkActionAgregarGasto(){

		return LinkBuilder::getActionUrl( "AgregarGasto") ;

	}

	public function getLinkActionPagarGasto(Gasto $gasto, Cuenta $cuenta, $backTo ="AdminHome"){



		return LinkBuilder::getActionUrl( "PagarGasto", array("gastoOid"=>$gasto->getOid(),
																"cuentaOid"=>$cuenta->getOid(),
																"backTo" => $backTo)) ;

	}

	public function getLinkGastoAnular(Gasto $gasto){

		return LinkBuilder::getPageUrl( "GastoAnular", array("gastoOid"=>$gasto->getOid())) ;

	}

	public function getLinkActionAnularGasto(Gasto $gasto){

		return LinkBuilder::getActionUrl( "AnularGasto", array("gastoOid"=>$gasto->getOid())) ;

	}

	public function getLinkActionModificarStockProducto(){

		return LinkBuilder::getActionUrl( "ModificarStockProducto") ;

	}

	public function getLinkVentas(){

		return LinkBuilder::getPageUrl( "Ventas") ;

	}

	public function getLinkVentaAgregar($backTo="VentaCobrar"){

		return LinkBuilder::getPageUrl( "VentaAgregar", array("backTo" => $backTo )) ;

	}

	public function getLinkActionAgregarVenta(){

		return LinkBuilder::getActionUrl( "AgregarVenta") ;

	}

	public function getLinkVentaCobrar(){

		return LinkBuilder::getPageUrl( "VentaCobrar") ;

	}

	public function getLinkActionCobrarVentaEfectivo(Venta $venta){

		return LinkBuilder::getActionUrl( "CobrarVentaEfectivo", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkActionCobrarVentaCtaCte(Venta $venta){

		return LinkBuilder::getActionUrl( "CobrarVentaCtaCte", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkActionCobrarVentaTarjeta(){

		return LinkBuilder::getActionUrl( "CobrarVentaTarjeta") ;

	}

	public function getLinkVentaAnular(Venta $venta){

		return LinkBuilder::getPageUrl( "VentaAnular", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkActionAnularVenta(Venta $venta){

		return LinkBuilder::getActionUrl( "AnularVenta", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkMovimientosCaja(){

		return LinkBuilder::getPageUrl( "MovimientosCaja") ;

	}

	public function getLinkMovimientosCajaTarjeta(){

		return LinkBuilder::getPageUrl( "MovimientosCajaTarjeta") ;

	}

	public function getLinkMovimientosCajaCtaCte(){

		return LinkBuilder::getPageUrl( "MovimientosCajaCtaCte") ;

	}

	public function getLinkMovimientosVenta(){

		return LinkBuilder::getPageUrl( "MovimientosVenta") ;

	}

	public function getLinkMovimientosGasto(){

		return LinkBuilder::getPageUrl( "MovimientosGasto") ;

	}





	public function getLinkAdminHome(){

		return LinkBuilder::getPageUrl( "AdminHome") ;

	}



	public function getLinkProveedores(){

		return LinkBuilder::getPageUrl( "Proveedors") ;

	}

	public function getLinkActionAgregarProveedor(){

		return LinkBuilder::getActionUrl( "AgregarProveedor") ;

	}

	public function getLinkActionModificarProveedor(){

		return LinkBuilder::getActionUrl( "ModificarProveedor") ;

	}

	public function getLinkProveedorAgregar(){

		return LinkBuilder::getPageUrl( "ProveedorAgregar") ;

	}



	public function getLinkPedidos(){

		return LinkBuilder::getPageUrl( "Pedidos") ;

	}

	public function getLinkPedidoAgregar($backTo = "PedidoPagar"){



		return LinkBuilder::getPageUrl( "PedidoAgregar", array("backTo" => $backTo )) ;

	}

	public function getLinkActionAgregarPedido(){

		return LinkBuilder::getActionUrl( "AgregarPedido") ;

	}

	public function getLinkActionPagarPedido(Pedido $pedido, Cuenta $cuenta, $backTo ="AdminHome"){

		return LinkBuilder::getActionUrl( "PagarPedido", array("pedidoOid"=>$pedido->getOid(),
																"cuentaOid"=>$cuenta->getOid(),
																"backTo" => $backTo)) ;

	}

	public function getLinkPedidoAnular(Pedido $pedido){

		return LinkBuilder::getPageUrl( "PedidoAnular", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkActionAnularPedido(Pedido $pedido){

		return LinkBuilder::getActionUrl( "AnularPedido", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkPedidoRecibir(Pedido $pedido){

		return LinkBuilder::getPageUrl( "PedidoRecibir", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkPedidoAnularRecibir(Pedido $pedido){

		return LinkBuilder::getPageUrl( "PedidoAnularRecibir", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkActionRecibirPedido(Pedido $pedido){

		return LinkBuilder::getActionUrl( "RecibirPedido", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkActionAnularRecibirPedido(Pedido $pedido){

		return LinkBuilder::getActionUrl( "AnularRecibirPedido", array("pedidoOid"=>$pedido->getOid())) ;

	}

	public function getLinkCobrarVentaTarjeta(Venta $venta){

		return LinkBuilder::getPageUrl( "VentaCobrarTarjeta", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkParametros(){

		return LinkBuilder::getPageUrl( "Parametros") ;

	}



	public function getLinkActionModificarParametro(){

		return LinkBuilder::getActionUrl( "ModificarParametro") ;

	}


	public function getLinkPresupuestos(){

		return LinkBuilder::getPageUrl( "Presupuestos") ;

	}

	public function getLinkPresupuestoAgregar($backTo="Presupuestos"){

		return LinkBuilder::getPageUrl( "PresupuestoAgregar", array("backTo" => $backTo )) ;

	}

	public function getLinkActionAgregarPresupuesto(){

		return LinkBuilder::getActionUrl( "AgregarPresupuesto") ;

	}

	public function getLinkPresupuestoAprobar(){

		return LinkBuilder::getPageUrl( "PresupuestoAprobar") ;

	}

	public function getLinkActionAprobarPresupuesto(Presupuesto $presupuesto){

		return LinkBuilder::getActionUrl( "AprobarPresupuesto", array("presupuestoOid"=>$presupuesto->getOid())) ;

	}


	public function getLinkPresupuestoAnular(Presupuesto $presupuesto){

		return LinkBuilder::getPageUrl( "PresupuestoAnular", array("presupuestoOid"=>$presupuesto->getOid())) ;

	}

	public function getLinkActionAnularPresupuesto(Presupuesto $presupuesto){

		return LinkBuilder::getActionUrl( "AnularPresupuesto", array("presupuestoOid"=>$presupuesto->getOid())) ;

	}

	public function getLinkActionDevolverVenta(Venta $venta){

		return LinkBuilder::getActionUrl( "DevolverVenta", array("ventaOid"=>$venta->getOid())) ;

	}

	public function getLinkActionAgregarProductoVenta(Venta $venta){

		return LinkBuilder::getActionUrl( "AgregarProductoVenta", array("ventaOid"=>$venta->getOid())) ;

	}

    public function getLinkActionAgregarProductoPedido(Pedido $pedido){

        return LinkBuilder::getActionUrl( "AgregarProductoPedido", array("pedidoOid"=>$pedido->getOid())) ;

    }

	public function getLinkActionAgregarCombo(){

		return LinkBuilder::getActionUrl( "AgregarCombo") ;

	}

	public function getLinkActionModificarCombo(){

		return LinkBuilder::getActionUrl( "ModificarCombo") ;

	}

	public function getLinkBalanceDia(){

		return LinkBuilder::getPageUrl( "BalanceDia") ;

	}

	public function getLinkBalanceCaja(){

		return LinkBuilder::getPageUrl( "BalanceCaja") ;

	}

	public function getLinkBalanceMes(){

		return LinkBuilder::getPageUrl( "BalanceMes") ;

	}

	public function getLinkBalanceAnio(){

		return LinkBuilder::getPageUrl( "BalanceAnio") ;

	}

	public function getLinkActionAgregarVendedor(){

		return LinkBuilder::getActionUrl( "AgregarVendedor") ;

	}

	public function getLinkActionModificarVendedor(){

		return LinkBuilder::getActionUrl( "ModificarVendedor") ;

	}



	public function getLinkMovimientosPedido(){

		return LinkBuilder::getPageUrl( "MovimientosPedido") ;

	}









}
?>
