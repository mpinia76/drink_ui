<?php
namespace Drink\UI\components\filter\model;


use Drink\UI\components\filter\model\UIDrinkCriteria;

use Rasty\utils\RastyUtils;
use Drink\Core\criteria\ConceptoMovimientoCriteria;

/**
 * Representa un criterio de búsqueda
 * para conceptoMovimientos.
 * 
 * @author Marcos
 * @since 12/03/2018
 *
 */
class UIConceptoMovimientoCriteria extends UIDrinkCriteria{


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
		return new ConceptoMovimientoCriteria();
	}
	
	public function buildCoreCriteria(){
		
		$criteria = parent::buildCoreCriteria();
				
		$criteria->setNombre( $this->getNombre() );
		
		return $criteria;
	}

}