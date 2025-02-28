<?php

namespace Drink\UI\components\stats\balance;

use DateTime;
use Drink\UI\components\filter\model\UIGastoCriteria;
use Drink\UI\utils\DrinkUIUtils;

use Drink\UI\service\UIServiceFactory;

use Rasty\components\RastyComponent;
use Rasty\utils\RastyUtils;

use Rasty\utils\XTemplate;

use Drink\Core\model\Caja;

use Rasty\utils\LinkBuilder;

use Rasty\factory\ComponentConfig;

use Rasty\factory\ComponentFactory;

use Drink\UI\components\filter\model\UIVentaCriteria;

use Rasty\utils\Logger;

/**
 * Balance de un mes.
 *
 * @author Bernardo
 * @since 28-04-2015
 */
class BalanceMes extends RastyComponent{

	private $fecha;

	public function getType(){

		return "BalanceMes";

	}

	public function __construct(){


	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_mes",  $this->localize( "balanceMes.mes" ) );
		$xtpl->assign("lbl_ventas",  $this->localize( "balanceMes.ventas" ) );

		$xtpl->assign("lbl_ganancias",  $this->localize( "balanceDia.ganancias" ) );
		$xtpl->assign("lbl_comisiones",  $this->localize( "venta.comision" ) );
        $xtpl->assign("lbl_gastos",  $this->localize( "balanceDia.gastos" ) );
		$xtpl->assign("lbl_saldo",  $this->localize( "balanceDia.saldo" ) );
	}

	protected function parseXTemplate(XTemplate $xtpl){


		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "filter" );
		$componentConfig->setType( $this->getFilterType() );

	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);



		$this->filter->fill( );

		$criteria = $this->filter->getCriteria();

		/*labels*/
		$this->parseLabels($xtpl);


		$fecha = $criteria->getFecha();
		if(empty($fecha)){
			$fecha = new DateTime();
		}

        $serviceGasto = UIServiceFactory::getUIGastoService();
        $criteriaGasto = new UIGastoCriteria();
        $criteriaGasto->setFiltroPredefinido(0);
        $criteriaGasto->setMes($criteria->getFecha());

        $gastoSaldo = $serviceGasto->getTotales($criteriaGasto);

		$criteriaVenta = new UIVentaCriteria();

		$criteriaVenta->setMes( $criteria->getFecha());
		$criteriaVenta->setCliente( $criteria->getCliente());
		$criteriaVenta->setVendedor( $criteria->getVendedor());
		$saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVenta, $criteria ,1 );//pongo uno como si fuera anula para que no muestre el chorizo de clientes

		//Logger::logObject($saldos);

		$meses = DrinkUIUtils::getMeses();
		$mes = $fecha->format("n");





		//$balance = UIServiceFactory::getUIBalanceService()->getBalanceMes($fecha);

		$xtpl->assign("mes",  $meses[$mes] . " " . $fecha->format("Y") );

		$xtpl->assign("ventas",  'Negocio: '.DrinkUIUtils::formatMontoToView($saldos["ventas"]).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["ventashielo"]) );
        /*if ($criteria->getVendedor())  {
            $ganancia = ($criteria->getVendedor()->getOid()==1)?$saldos['ganancias']-$gastoSaldo:$saldos['ganancias'];
        }
        else $ganancia =$saldos['ganancias']-$gastoSaldo;*/
        $ganancia =$saldos['ganancias'];
			$xtpl->assign("ganancias",  'Negocio: '.DrinkUIUtils::formatMontoToView($ganancia).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["gananciashielo"])  );
			$xtpl->assign("comisiones",  'Negocio: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisiones"]).' - Hielo: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisioneshielo"])  );
        $xtpl->assign("gastos",  DrinkUIUtils::formatMontoToView((-1)*$gastoSaldo)  );

		$mitadHielo = $saldos["gananciashielo"]/2;
		$saldo = $ganancia + $mitadHielo - ($saldos["comisiones"]+$saldos["comisioneshielo"]+$gastoSaldo);

		$xtpl->assign("saldo",  DrinkUIUtils::formatMontoToView($saldo)  .' - Mitad Hielo '.DrinkUIUtils::formatMontoToView($mitadHielo));


		//Logger::logObject($saldos);
		if ($saldos['productos']) {
			$productos='';

			foreach ($saldos['productos']['cant'] as $key => $cantidad) {
				//print_r($producto);
				$productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
			}
			$xtpl->assign("productos",  $productos);
		}
		if ($saldos['clientes']) {
			$clientes='';
			$clienteIdAnt='';
			foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
				$arrayKey = explode('-', $key);
				if ($clienteIdAnt!=$arrayKey[0]) {
					$clientes .=$saldos['clientes']['cliente'][$arrayKey[0]].'<br>';
				}
				$clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
				$clienteIdAnt=$arrayKey[0];
			}
			$xtpl->assign("clientes",  $clientes);
		}

	}


	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	protected function initObserverEventType(){
		//TODO $this->addEventType( "Venta" );
	}

	public function getFilterType()
	{
	    return $this->filterType;
	}

	public function setFilterType($filterType)
	{
	    $this->filterType = $filterType;
	}
}
?>
