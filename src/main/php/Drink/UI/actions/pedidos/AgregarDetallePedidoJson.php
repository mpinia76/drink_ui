<?php
namespace Drink\UI\actions\pedidos;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIProductoService;

use Drink\UI\components\filter\model\UIProductoCriteria;

use Drink\UI\service\UIServiceFactory;

use Drink\Core\model\DetallePedido;

use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

/**
 * se agrega un detalle de pedido para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 10-07-2020
 */
class AgregarDetallePedidoJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {

			//creamos el detalle de pedido.
			$detalle = new DetallePedido();

			$productoCodigo = RastyUtils::getParamPOST("producto");
			$cantidad = RastyUtils::getParamPOST("cantidad");
			$precio = $value = str_replace(',', '.', RastyUtils::getParamPOST("precio"));
			
			$uiCriteria = new UIProductoCriteria();
			$uiCriteria->setCodigoExacto( $productoCodigo );
		
			$oProducto = UIServiceFactory::getUIProductoService()->getByCriteria( $uiCriteria );
			
			
			$detalle->setProducto( $oProducto );
			$detalle->setCantidad( $cantidad );
			$detalle->setPrecioUnitario( $precio );
			
			//tomamos los detalles de sesión y agregamos el nuevo.
			DrinkUIUtils::agregarDetallePedidoSession($detalle);			
			
			$detalles = DrinkUIUtils::getDetallesPedidoSession();
			$result["detalles"] = $detalles;
			
			$result["cantidad"] = 0;
			$result["importe"] = 0;
			foreach ($detalles as $detallejson) {
				$result["importe"] += $detallejson["subtotal"];
				$result["cantidad"] += $detallejson["cantidad"];
			}
			
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>