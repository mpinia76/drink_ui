<?php

namespace Drink\UI\components\pdf\producto;

use Datetime;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Drink\UI\components\filter\model\UIProductoCriteria;
use Drink\UI\components\filter\model\UIPackCriteria;
use Drink\UI\components\filter\model\UITipoProductoCriteria;
use Drink\UI\components\filter\model\UIComboCriteria;

use Rasty\utils\LinkBuilder;
use Rasty\render\DOMPDFRenderer;
use Rasty\conf\RastyConfig;
use Rasty\factory\PageFactory;

use Rasty\utils\Logger;


/**
 * para renderizar en pdf listado de precios.
 *
 * @author Marcos
 * @since 28-07-2020
 *
 */
class ProductosPDF extends RastyComponent{



	public function getType(){

		return "ProductosPDF";

	}

	public function __construct(){


	}


	protected function parseXTemplate(XTemplate $xtpl){

		$page = PageFactory::build("Productos");

		$productoCriteria = new UIProductoCriteria();

		$productoFilter = $page->getComponentById("productosFilter");

		$productoFilter->fillFromSaved($productoCriteria);
		$xtpl->assign( "APP_PATH", RastyConfig::getInstance()->getAppPath() );
		$xtpl->assign( "fecha", DrinkUIUtils::formatDateTimeToView(new Datetime()) );
		$oVendedor = UIServiceFactory::getUIVendedorService()->get( $productoCriteria->getVendedor()->getOid() );

		if ($oVendedor->getMayorista()) {
			$productoCriteria->setPorcentajeGanancia2(1);
			$xtpl->assign( "vendedor",'<p style="font-size:12pt;"><span style="font-weight: bold;">Vendedor: </span>'.$oVendedor->getNombre().' - '.$oVendedor->getTelefono().'</p>');
		}
		$xtpl->assign("lbl_detalle_nombre", $this->localize( "venta.detalle.producto" ) );
		$xtpl->assign("lbl_detalle_stock", $this->localize( "producto.stock" ) );
		$xtpl->assign("lbl_detalle_precio", $this->localize( "producto.costo" ) );
		$xtpl->assign("lbl_detalle_total", $this->localize( "venta.detalles.total" ) );


		/*$tipoProductoCriteria = new UITipoProductoCriteria();
		$tipoProductoCriteria->setNombre($productoCriteria->getTipoProducto());
		$tipoProductoCriteria->addOrder('nombre','ASC');
		$tipos = UIServiceFactory::getUITipoProductoService()->getList($tipoProductoCriteria);
		$html ='';
		$packs=array();
		$arrTipos=array();
		$arrProductos=array();
		foreach ($tipos as $tipo) {*/
			//$xtpl->assign( "tipoproducto", $tipo );
			$productoCriteria->addOrder('marcaProducto','ASC');
			//$productoCriteria->setTipoProducto($tipo);
			$productos = UIServiceFactory::getUIProductoService()->getList($productoCriteria);
			$total = 0;
			foreach ($productos as $producto) {
				//if ($producto->getStock()>0){
					$arrProductos[]=$producto->getOid();
					$xtpl->assign( "producto", $producto->getMarcaProducto().' '.$producto->getNombre() );

					/*$xtpl->assign( "precio", DrinkUIUtils::formatMontoToView( ($oVendedor->getMayorista())?$producto->getPrecioLista():$producto->getPrecioEfectivo() ) );*/
					$xtpl->assign( "stock", $producto->getStock());
					$xtpl->assign( "precio", DrinkUIUtils::formatMontoToView( $producto->getCosto() ) );
					$xtpl->assign( "total", DrinkUIUtils::formatMontoToView($producto->getStock()*$producto->getCosto()));
					$total +=$producto->getStock()*$producto->getCosto();
					$xtpl->parse( "main.detalle" );
				//}

				$xtpl->assign( "totales", DrinkUIUtils::formatMontoToView($total ) );



		}




	}







	public function getPDFRenderer(){

		$renderer = new DOMPDFRenderer();
		return $renderer;
	}
}
?>
