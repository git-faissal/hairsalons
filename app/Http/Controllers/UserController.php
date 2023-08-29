<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\User;
use App\Repositories\Utilisateur\UserRepository;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    use ApiResponser;
     /**
     * Definition du constructeur
     */
    protected $userRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->userRepository = $UserRepository;
    }

     /**
     * fonction de recuperation de tous les instances de la table
     */
    public function index(){

        $utilisateurs = $this->userRepository->getAll();
        return $this->successResponse($utilisateurs);
    }

       /**
     * fonction inscription des differents utilisateur
     */

     public function inscription(Request $request){
          //verification de la validite des donnee recus
        $utilisateurDonnee = $request->validate([
            "name" => ['string', 'max:255'],
            "telephone" => ["required", "string", "min:2"],
            "email" => ["required", "email","unique:users,email"],
            "password" => ["required", "string", "min:8", "max:38", "confirmed"]
        ]);

          //envoie des donnees valide dans un tableau
          $userData = [
            "name" => $utilisateurDonnee["name"],
            "telephone" => $utilisateurDonnee["telephone"],
            "email" => $utilisateurDonnee["email"],
            "password" => bcrypt($utilisateurDonnee["password"])
        ];

         //insertion du user dans la table
         $utilisateurs = $this->userRepository->store($userData);

         //Resultat format json
         return response($utilisateurs, 201);
     }

      /**
     * fonction connexion des differents utilisateurs
     */

     public function connexion(Request $request){

        //verification des different donnee recus
        $utilisateurDonnee = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required", "string", "min:8", "max:30"],

        ]);
        //recuperation du user a partir de email envoye
        $utilisateur = $this->userRepository->getByEmail($request->email);
        //verification de identite de user recupere
        if(!$utilisateur) return response(["message" => "Aucun utilisateur trouver pour l'email suivant $utilisateurDonnee[email]"], 401);
        if (!Hash::check($request->password, $utilisateur->password))
        {
            return response()->json(["message" => "Identifient incorrect"], 401);
        }
        //creation du token pour l'utilisateur connecte
         $token = $utilisateur->createToken("CLE_SECRETE")->plainTextToken;
        //message de success
        $message="connexion reussie";
        //resulatat au format json
        return response()->json([
            "utilisateur" => $utilisateur,
            "token" => $token,
            "message" => $message
        ], 200);
     }
     /**
     * fonction de mise des donnees de l'utilisateur
     */

     public function update(Request $request, $id){

        $rules = [
            'name' => 'required|string|max:255',
        ];

        $this->validate($request, $rules);

        $utilisateur = $this->userRepository->getById($id);
        $utilisateur->fill($request->all());

        if($utilisateur->isClean())
        {
            return $this->errorResponse("Aucune modification n'a ete effectué",Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $utilisateur->save();
        return $this->successResponse($utilisateur);

     }

      /**
     * fonction de suppression d'un utilisateur
     */

     public function destroy($id){

        //appel de la fonction de suppression
        $result=$this->userRepository->destroy($id);
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

      /**
     * fonction affichant details d'un utilisateur
     */

     public function show($id){

        if($id){
            
            $result = $this->userRepository->getById($id);
            return $this->successResponse($result);
                
            }
            $message="error";
            return response()->json([
                "message" => $message
            ]);

     }

        /**
     * Fonction de deconnexion de l'utilisateur
     */

     public function logout(){

        // suppression du token du user authentifier
        auth()->user()->tokens()->delete();
        //resulatat au format json
        return response()->json([
            "message" => "success"
        ]);
     }
}
