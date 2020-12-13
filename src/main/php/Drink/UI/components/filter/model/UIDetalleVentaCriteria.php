<?php
namespace Drink\UI\components\filter\model;


use Drink\UI\components\filter\model\UIDrinkCriteria;
use Drink\Core\utils\DrinkUtils;

use Rasty\utils\RastyUtils;
use Drink\Core\criteria\DetalleVentaCriteria;


/**
 * Representa un criterio de búsqueda
 * para gastos.
 * 
 * @author Marcos
 * @since 12/03/2018
 *
 */
class UIDetalleVentaCriteria extends UIDrinkCriteria{

	
	
	private $ventas;

	private $productos;
	
	
	
	public function __construct(){

		parent::__construct();
		
		

	}
		
	protected function newCoreCriteria(){
		return new DetalleVentaCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		
		$criteria->setVentas( $this->getVentas() );
		$criteria->setProductos( $this->getProductos() );
		
		return $criteria;
	}

	

	public function getVentas()
	{
	    return $this->ventas;
	}

	public function setVentas($ventas)
	{
	    $this->ventas = $ventas;
	}

	public function getProductos()
	{
	    return $this->productos;
	}

	public function setProductos($productos)
	{
	    $this->productos = $productos;
	}
}