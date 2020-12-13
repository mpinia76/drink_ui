<?php
namespace Drink\UI\actions\ventas;

use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIProductoService;

use Drink\UI\service\UIServiceFactory;

use Drink\Core\model\DevolucionVenta;

use Drink\UI\components\filter\model\UIProductoCriteria;

use Rasty\actions\JsonAction;
use Rasty\utils\RastyUtils;
use Rasty\exception\RastyException;

use Rasty\security\RastySecurityContext;

use Rasty\i18n\Locale;
use Rasty\factory\PageFactory;

use Rasty\app\RastyMapHelper;
use Rasty\factory\ComponentFactory;
use Rasty\factory\ComponentConfig;

use Rasty\utils\Logger;

/**
 * se agregar un devolucion de venta para la edición
 * en sesión.
 * 
 * @author Marcos
 * @since 28/04/2019
 */
class AgregarDevolucionVentaJson extends JsonAction{

	
	public function execute(){

		$rasty= RastyMapHelper::getInstance();
		
		try {
			
			//creamos el devolucion de venta.
			$devolucion = new DevolucionVenta();

			$productoCodigo = RastyUtils::getParamPOST("producto");
			$cantidad = RastyUtils::getParamPOST("cantidad");
			$precio = $value = str_replace(',', '.', RastyUtils::getParamPOST("precio"));
			$costo = $value = str_replace(',', '.', RastyUtils::getParamPOST("costo"));
			
			$uiCriteria = new UIProductoCriteria();
			$uiCriteria->setCodigoExacto( $productoCodigo );
		
			$oProducto = UIServiceFactory::getUIProductoService()->getByCriteria( $uiCriteria );
			
			$devolucion->setProducto($oProducto  );
			$devolucion->setCantidad( $cantidad );
			$devolucion->setPrecioUnitario( $precio );
			$devolucion->setCosto( $costo );
			$devolucion->setStockActualizado(2);
			
			//tomamos los devoluciones de sesión y agregamos el nuevo.
			DrinkUIUtils::agregarDevolucionVentaSession($devolucion);			
			
			$devoluciones = DrinkUIUtils::getDevolucionesVentaSession();
			$result["devoluciones"] = $devoluciones;
			
			$result["cantidad"] = 0;
			$result["importe"] = 0;
			
			foreach ($devoluciones as $devolucionjson) {
				//print_r($devolucionjson);
				$result["importe"] += $devolucionjson["subtotal"];
				$result["cantidad"] += $devolucionjson["cantidad"];
			}
			
						
		} catch (RastyException $e) {
		
			$result["error"] = $e->getMessage();
		}
		
		return $result;
		
	}

}
?>