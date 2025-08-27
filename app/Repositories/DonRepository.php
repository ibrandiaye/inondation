<?php
namespace App\Repositories;

use App\Models\Don;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\DB;

class DonRepository extends RessourceRepository{
    public function __construct(Don $don){
        $this->model = $don;
    }

    public function getDonByUser($user){
        if($user->role=="gouverneur")
        {
            return Don::with(["region","departement","arrondissement"])->where('region_id', $user->region_id)->get();
        }
        else if($user->role=="prefet")
        {
            //dd("fff");
            return Don::with(["region","departement","arrondissement"])
           // ->whereNotNull('departement_id')
            ->where('departement_id', $user->departement_id)
            ->get();
        }
        else if($user->role=="sous_prefet")
        {
          return Don::with(["region","departement","arrondissement"])->where('arrondissement_id', $user->arrondissement_id)->get();
        }



    }

    public function sommeDon($user){

        if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
            return  DB::table("dons")
           ->sum("dons.valeur");
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("dons")
            ->join("arrondissements","dons.arrondissement_id","=","arrondissements.id")
            ->where("dons.arrondissement_id",$user->arrondissement_id)
            ->sum("dons.valeur");
        }
        elseif ($user->role=="prefet") {
            return  DB::table("dons")
            ->join("departements","dons.departement_id","=","departements.id")
            ->where("dons.departement_id",$user->departement_id)
            ->sum("dons.valeur");
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("dons")
            ->join("regions","dons.region_id","=","regions.id")

            ->where("regions.id",$user->region_id)
            ->sum("dons.valeur");
        }
    }

     public function sommeDonByRegion($id){

      return  DB::table("dons")
            ->join("regions","dons.region_id","=","regions.id")

            ->where("regions.id",$id)
            ->sum("dons.valeur");

    }
     public function sommeDonByDepartement($id){

             return  DB::table("dons")
            ->join("departements","dons.departement_id","=","departements.id")
            ->where("dons.departement_id",$id)
            ->sum("dons.valeur");


    }

     public function sommeDonByArrondissement($id){
         return  DB::table("dons")
            ->join("arrondissements","dons.arrondissement_id","=","arrondissements.id")
            ->where("dons.arrondissement_id",$id)
            ->sum("dons.valeur");


    }

}
