<?php
namespace App\Repositories;

use App\Models\Operateur;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OperateurRepository extends RessourceRepository{
    public function __construct(Operateur $operateur){
        $this->model = $operateur;
    }

    public function get()
    {
        return DB::table("operateurs")
        ->join("communes", "operateurs.commune_id", "=", "communes.id")
        ->join("departements","communes.departement_id","=","departements.id")
        ->join("regions","departements.region_id","=","regions.id")
        ->select("operateurs.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region","communes.arrondissement_id")
        ->get();

    }

    public function countOperateur(){
         $user = Auth::user();
        if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
            return  DB::table("operateurs")
            ->count();
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.arrondissement_id",$user->arrondissement_id)
            ->count();
        }
        elseif ($user->role=="prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.departement_id",$user->departement_id)
            ->count();
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("departements","communes.departement_id","=","departements.id")

            ->where("departements.region_id",$user->region_id)
            ->count();
        }
    }

    public function countByRegion($id){

        return  DB::table("operateurs")
        ->join("communes","operateurs.commune_id","=","communes.id")
        ->join('departements',"communes.departement_id","=","departements.id")
        ->where("departements.region_id",$id)
        ->count();

    }
     public function countByDepartement($id){

            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.departement_id",$id)
            ->count();


    }

     public function countByArrondissement($id){
        return  DB::table("operateurs")
        ->join("communes","operateurs.commune_id","=","communes.id")

        ->where("communes.arrondissement_id",$id)

        ->count();


    }
    public function countByCommune($id){

        return  DB::table("operateurs")
        ->where("commune_id",$id)
        ->count();

    }


}
