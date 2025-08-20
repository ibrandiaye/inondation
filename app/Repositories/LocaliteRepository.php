<?php
namespace App\Repositories;

use App\Models\Localite;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocaliteRepository extends RessourceRepository{
    public function __construct(Localite $localite){
        $this->model = $localite;
    }

    public function get()
    {
        return DB::table("localites")
        ->join("communes", "localites.commune_id", "=", "communes.id")
        ->join("departements","communes.departement_id","=","departements.id")
        ->join("regions","departements.region_id","=","regions.id")
        ->select("localites.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region","communes.arrondissement_id")
        ->get();


    }

     public function countLocalite(){
         $user = Auth::user();
        if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
            return  DB::table("localites")
            ->count();
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("localites")
            ->join("communes","localites.commune_id","=","communes.id")
            ->where("communes.arrondissement_id",$user->arrondissement_id)
            ->count();
        }
        elseif ($user->role=="prefet") {
            return  DB::table("localites")
            ->join("communes","localites.commune_id","=","communes.id")
            ->where("communes.departement_id",$user->departement_id)
            ->count();
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("localites")
            ->join("communes","localites.commune_id","=","communes.id")
            ->join("departements","communes.departement_id","=","departements.id")

            ->where("departements.region_id",$user->region_id)
            ->count();
        }
    }
     public function countByRegion($id){

        return  DB::table("localites")
        ->join("communes","localites.commune_id","=","communes.id")
        ->join('departements',"communes.departement_id","=","departements.id")
        ->where("departements.region_id",$id)
        ->count();

    }
     public function countByDepartement($id){

            return  DB::table("localites")
            ->join("communes","localites.commune_id","=","communes.id")
            ->where("communes.departement_id",$id)
            ->count();


    }

     public function countByArrondissement($id){
        return  DB::table("localites")
        ->join("communes","localites.commune_id","=","communes.id")

        ->where("communes.arrondissement_id",$id)

        ->count();


    }
    public function countByCommune($id){

        return  DB::table("localites")
        ->where("commune_id",$id)
        ->count();

    }

}
