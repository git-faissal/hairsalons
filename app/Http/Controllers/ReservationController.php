<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class ReservationController extends Controller
{
    //
    use ApiResponser;
    /**
     * Definition du constructeur
     */

     public $reservationRepository;
     public function __construct(ReservationRepository $ReservationRepository)
     {
        $this->reservationRepository= $ReservationRepository;
     }


     /**
     * fonction de recuperation de tous les instances de la table
     */

     public function index()
     {
        $reservation = $this->reservationRepository->getAll();
        return $this->successResponse($reservation);
     }

      /**
     * fonction enregistrement des reservation
     */

     public function store(Request $request){
        $rules = [
            'categorie' => 'required|string|min:1',
            'specialiste' => 'required|string|min:1',
            'prix' => 'required|string|min:1',
            'heure' => 'required|string|min:1',
            'date' => 'required|string|min:1',
        ];
        $this->validate($request, $rules);

        $infos = $this->reservationRepository->store($request->all());

        return $this->successResponse($infos);

     }

      /**
     * fonction de mise des donnees de reservation
     */

     public function update(Request $request, $id){
        $rules = [
            'name' => 'required|string|max:255',
        ];

        $this->validate($request, $rules);

        $utilisateur = $this->reservationRepository->getById($id);
        $utilisateur->fill($request->all());

        if($utilisateur->isClean())
        {
            return $this->errorResponse("Aucune modification n'a ete effectué",Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $utilisateur->save();
        return $this->successResponse($utilisateur);
     }


     /**
     * fonction affichant details d'un reservation
     */

     public function show($id){
        // recupere les information de l'evenement
        $result = $this->reservationRepository->getById($id);
       //le bon  return $this->successResponse($Evenement);
       //je l'ai remplace par ce return me faicliter la recuperation et la distinction des participants de l'evenement
       return $this->successResponse($result);
       // return $this->successResponse($lesParticipantsDeLevenement);
    
     }
       /**
     * fonction de suppression d'une reservation
     */
    public function delete($id){
         //appel de la fonction de suppression
         $result=$this->reservationRepository->destroy($id);
         if($result)
         {
             $message=1;
             return response()->json([
                 "message" => $message
             ]);
         }
         //si ya erreur
         $message=0;
           //resulatat au format json
           return response()->json([
             "message" => $message
         ]);
    }
}
