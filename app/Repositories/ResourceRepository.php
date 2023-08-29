<?php

namespace App\Repositories;


abstract class ResourceRepository
{

    protected $model;

	/**
	 * recupere le nombre d'instance du modele passeé en parametre
	 * dans le model
	 */
    public function getPaginate($n)
	{
		return $this->model->paginate($n);
	}

	/**
	 * retourne toutes les instances du modele
	 * enregistreé en BD
	 */
	public function getAll()
	{
		return $this->model::All();
	}

	/**
	 * Enregistre un /de instance(s) 
	 */
	public function store(Array $inputs)
	{
       //return $this->model->$inputs->saveOrFail();
		return $this->model->create($inputs);
	}

	/**
	 * Recupere une instance a partir de l'id
	 */
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}
	

	/**
	 * Met a jour la table a partir de l'id recu 
	 */
	public function update($id, Array $inputs)
	{
		$this->getById($id)->update($inputs);
	}

	/**
	 * Supprime une instance de la table a partir de l'id recu
	 */
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

}