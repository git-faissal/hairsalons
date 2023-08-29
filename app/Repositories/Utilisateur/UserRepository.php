<?php
namespace App\Repositories\Utilisateur;
use App\Repositories\ResourceRepository;

use App\Models\User;

class UserRepository extends ResourceRepository
{

	public function __construct(User $user)
	{
		$this->model = $user;
	}

	/**
	 * 
	 */
	public function getByEmail($mail)
	{
		return User::where('email', $mail)
					->get()
					->first();
	}

}
