<?php

namespace Drink\UI\components\stats\balance;

use DateTime;
use Drink\UI\components\filter\model\UIGastoCriteria;
use Drink\UI\service\UIVentaService;

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

/**
 * Balance del anio.
 *
 * @author Marcos
 * @since 07-10-2019
 */
class BalanceAnio extends RastyComponent{

	private $fecha;

	public function getType(){

		return "BalanceAnio";

	}

	public function __construct(){
		$fecha = new DateTime();
		$this->setFecha($fecha);

	}

	protected function parseLabels(XTemplate $xtpl){

		$xtpl->assign("lbl_anio",  $this->localize( "balanceAnio.anio" ) );
		$xtpl->assign("lbl_mes",  $this->localize( "balanceAnio.mes" ) );
		$xtpl->assign("lbl_ventas",  $this->localize( "balanceAnio.ventas" ) );

		$xtpl->assign("lbl_ganancia",  $this->localize( "balanceAnio.ganancia" ) );
		$xtpl->assign("lbl_comisiones",  $this->localize( "venta.comision" ) );
        $xtpl->assign("lbl_gastos",  $this->localize( "balanceDia.gastos" ) );
		$xtpl->assign("lbl_saldo",  $this->localize( "balanceDia.saldo" ) );
		$xtpl->assign("detalle_mes_legend",  $this->localize( "balanceAnio.detalle_mes.legend" ) );


	}

	protected function parseXTemplate(XTemplate $xtpl){
		ini_set('max_execution_time', '0');
		$componentConfig = new ComponentConfig();
	    $componentConfig->setId( "filter" );
		$componentConfig->setType( $this->getFilterType() );

	    $this->filter = ComponentFactory::buildByType($componentConfig, $this);



		$this->filter->fill( );

		$criteria = $this->filter->getCriteria();

		/*labels*/
		$this->parseLabels($xtpl);

		$fecha = $criteria->getFecha();
		if(empty($fecha))
			$fecha = new DateTime();


        $serviceGasto = UIServiceFactory::getUIGastoService();
        $criteriaGasto = new UIGastoCriteria();
        $criteriaGasto->setFiltroPredefinido(0);
        $criteriaGasto->setYear($fecha);

        $gastoSaldo = $serviceGasto->getTotales($criteriaGasto);


		$criteriaVenta = new UIVentaCriteria();

		$criteriaVenta->setYear( $fecha);
		$criteriaVenta->setCliente( $criteria->getCliente());
		$criteriaVenta->setVendedor( $criteria->getVendedor());

		$saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVenta, $criteria,1 );

		//$balance = UIServiceFactory::getUIBalanceService()->getBalanceAnio($fecha);


		$balances = array();

		$anio = $fecha->format("Y");

		$meses = DrinkUIUtils::getMeses();

		for ($mes = 1; $mes <=12; $mes++) {
			$balances[$mes] = array( "ventas" => 0,

										"ganancias" => 0,
										"mes_nombre" => $meses[$mes]);
		}


		$xtpl->assign("anio",  $fecha->format("Y"));
		/*$xtpl->assign("totalGastos",  DrinkUIUtils::formatMontoToView($balance["gastos"]) );
		$xtpl->assign("totalPagos",  DrinkUIUtils::formatMontoToView($balance["pagos"]) );*/
		$xtpl->assign("totalVentas",  'Negocio: '.DrinkUIUtils::formatMontoToView($saldos["ventas"]).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["ventashielo"]) );
		//$xtpl->assign("totalComisiones",  DrinkUIUtils::formatMontoToView($balance["comisiones"]) );
        /*if ($criteria->getVendedor())  {
            $ganancia = ($criteria->getVendedor()->getOid()==1)?$saldos['ganancias']-$gastoSaldo:$saldos['ganancias'];
        }
        else $ganancia =$saldos['ganancias']-$gastoSaldo;*/
        $ganancia =$saldos['ganancias'];
		$xtpl->assign("totalGanancia",  'Negocio: '.DrinkUIUtils::formatMontoToView($ganancia).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["gananciashielo"])  );
		$xtpl->assign("totalComisiones",  'Negocio: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisiones"]).' - Hielo: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisioneshielo"])  );
        $xtpl->assign("totalGastos",  DrinkUIUtils::formatMontoToView((-1)*$gastoSaldo)  );

		$mitadHielo = $saldos["gananciashielo"]/2;
		$saldo = $ganancia + $mitadHielo - ($saldos["comisiones"]+$saldos["comisioneshielo"]+$gastoSaldo);

		$xtpl->assign("totalSaldo",  DrinkUIUtils::formatMontoToView($saldo)  .' - Mitad Hielo '.DrinkUIUtils::formatMontoToView($mitadHielo));

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

		$detalles = $balances;

		for ($mes = 1; $mes <=12; $mes++) {

			$xtpl->assign("mes",  $detalles[$mes]["mes_nombre"] );

            $year = DrinkUIUtils::yearOfDate($criteria->getFecha());

            $fecha = new DateTime($year.'-'.$mes.'-01');

            $criteriaGastoMes = new UIGastoCriteria();
            $criteriaGastoMes->setFiltroPredefinido(0);
            $criteriaGastoMes->setMes($fecha);

            $gastoSaldoMes = $serviceGasto->getTotales($criteriaGastoMes);


			$criteriaVentaMes = new UIVentaCriteria();







			$criteriaVentaMes->setMes( $fecha);
			$criteriaVentaMes->setCliente( $criteria->getCliente());
            $criteriaVentaMes->setVendedor( $criteria->getVendedor());
			$saldos = UIServiceFactory::getUIVentaService()->getGananciasProducto($criteriaVentaMes, $criteria,1 );

            /*if ($criteria->getVendedor())  {
                $ganancias = ($criteria->getVendedor()->getOid()==1)?$saldos['ganancias']-$gastoSaldoMes:$saldos['ganancias'];
            }
            else $ganancias =$saldos['ganancias']-$gastoSaldoMes;*/
            $ganancias =$saldos['ganancias'];
			$xtpl->assign("ventas",  'Negocio: '.DrinkUIUtils::formatMontoToView($saldos["ventas"]).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["ventashielo"]) );
			/*$xtpl->assign("gastos",  DrinkUIUtils::formatMontoToView($detalles[$mes]["gastos"]) );
			$xtpl->assign("pagos",  DrinkUIUtils::formatMontoToView($detalles[$mes]["pagos"]) );
			*/

			$xtpl->assign("ganancia",  'Negocio: '.DrinkUIUtils::formatMontoToView($ganancias).' - Hielo: '.DrinkUIUtils::formatMontoToView($saldos["gananciashielo"])  );
			$xtpl->assign("comisiones",  'Negocio: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisiones"]).' - Hielo: '.DrinkUIUtils::formatMontoToView((-1)*$saldos["comisioneshielo"])  );
            $xtpl->assign("gastos",  DrinkUIUtils::formatMontoToView((-1)*$gastoSaldoMes)  );

			$mitadHielo = $saldos["gananciashielo"]/2;
			$saldo = $ganancias + $mitadHielo - ($saldos["comisiones"]+$saldos["comisioneshielo"]+$gastoSaldoMes);

			$xtpl->assign("saldo",  DrinkUIUtils::formatMontoToView($saldo)  .' - Mitad Hielo '.DrinkUIUtils::formatMontoToView($mitadHielo));


			if ($saldos['productos']) {
				$productos='';

				foreach ($saldos['productos']['cant'] as $key => $cantidad) {
					//print_r($producto);
					$productos .=$saldos['productos']['nombre'][$key].' Vendidos: '.$cantidad.' <br>';
				}
				$xtpl->assign("producto",  $productos);
			}
			if ($saldos['clientes']) {
				$clientes='';
				$clienteIdAnt='';
				foreach ($saldos['clientes']['cant'] as $key => $cantidad) {
					$arrayKey = explode('-', $key);
					if ($clienteIdAnt!=$arrayKey[0]) {
						$clientes .='<strong>'.$saldos['clientes']['cliente'][$arrayKey[0]].'</strong><br>';
					}
					$clientes .='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saldos['productos']['nombre'][$arrayKey[1]].' Vendidos: '.$cantidad.' <br>';
					$clienteIdAnt=$arrayKey[0];
				}
				$xtpl->assign("cliente",  $clientes);
			}
			$xtpl->parse("main.detalle_mes.mes");

		}

		$xtpl->parse("main.detalle_mes");

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
