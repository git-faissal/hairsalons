<?php
namespace App\Repositories;

use App\Repositories\ResourceRepository;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

class ReservationRepository extends ResourceRepository
{

	public function __construct(Reservation $Reservation)
	{
		$this->model = $Reservation;
	}

	public function getByIdEvenUser($id_user, $etat)
	{
		return $this->model->select('*')
					->where('evenements.user_id',$id_user)	
					->where('evenements.etat',$etat)	
					->get();
	}

	/**
	 * Fonction de recuperation de la liste des evenements avec leur etat actif
	 */
	public function getByEtat($etat)
	{
		return $this->model::where('etat', $etat)
					->get();
	}

}
