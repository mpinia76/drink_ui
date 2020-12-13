<?php
namespace Drink\UI\components\filter\model;


use Drink\UI\components\filter\model\UIDrinkCriteria;

use Rasty\utils\RastyUtils;
use Drink\Core\criteria\TipoProductoCriteria;

/**
 * Representa un criterio de búsqueda
 * para tiposProducto.
 * 
 * @author Marcos
 * @since 05/03/2018
 *
 */
class UITipoProductoCriteria extends UIDrinkCriteria{


	private $nombre;
	
	
	
	public function __construct(){

		parent::__construct();

	}
		
	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	
	protected function newCoreCriteria(){
		return new TipoProductoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setNombre( $this->getNombre() );
		
		
		return $criteria;
	}


	
}