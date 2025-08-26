<?php
namespace App\Repositories;

use App\Models\Commune;
use App\Models\Departement;
use App\Repositories\RessourceRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommuneRepository extends RessourceRepository{
    public function __construct(Commune $commune){
        $this->model = $commune;
    }
    public function getAllWithdepartement(){
        return Commune::with(['departement','departement.region'])
        ->get();
    }
    public function getOneCommuneWithdepartementAndRegion($id){
        return Commune::with(['departement','departement.region'])
        ->where('id',$id)
        ->first();
    }
    public function getByArrondissementWithRelation($id){
        return Commune::with(['localites'])
        ->where('arrondissement_id',$id)
        ->get();
    }
     public function getByIdWithRelation($id){
        return Commune::with(['localites'])
        ->where('id',$id)
        ->get();
    }
    public function getByDepartement($departement){
        return DB::table("communes")
        ->where("departement_id",$departement)
        ->orderBy("nom","asc")
        ->get();
}
public function getAllOnLy(){
    return DB::table("communes")
    ->orderBy("nom","asc")
    ->get();
}

public function getCommuneByNom($nom){
    return DB::table("communes")->where('nom', 'like', '%'.$nom.'%')->get();
}
public function getByArrondissement($id)
{
    return DB::table("communes")->where("arrondissement_id",$id)->get();
}



public function getOneCommuneWithArrondissementdepartementAndRegion($id){
    return Commune::with(['departement','departement.region','arrondissement'])
    ->where('id',$id)
    ->first();
}


 public function getOnlyById($id)
 {
    return DB::table("communes")->find($id);
 }

 public function getWithRelation()
 {
    return DB::table("communes")
    ->join("arrondissements","communes.arrondissement_id","=","arrondissements.id")
    ->join("departements","communes.departement_id","=","departements.id")
    ->join("regions","departements.region_id","=","regions.id")
    ->select("arrondissements.nom as arrondissement","departements.nom as departement","communes.id","regions.nom as region","communes.nom")
    ->orderBy("regions.nom")
    ->get();

 }
 public function getWithRelationByRegion($region_id)
 {
    return DB::table("communes")
    ->join("arrondissements","communes.arrondissement_id","=","arrondissements.id")
    ->join("departements","communes.departement_id","=","departements.id")
    ->join("regions","departements.region_id","=","regions.id")
    ->select("arrondissements.nom as arrondissement","departements.nom as departement","communes.id","regions.nom as region","communes.nom")
    ->where("regions.id",$region_id)
    ->orderBy("regions.nom")
    ->get();

 }
 public function getWithRelationByDepartement($departement_id)
 {
    return DB::table("communes")
    ->join("arrondissements","communes.arrondissement_id","=","arrondissements.id")
    ->join("departements","communes.departement_id","=","departements.id")
    ->join("regions","departements.region_id","=","regions.id")
    ->select("arrondissements.nom as arrondissement","departements.nom as departement","communes.id","regions.nom as region","communes.nom")
    ->where("departements.id",$departement_id)
    ->orderBy("regions.nom")
    ->get();

 }
 public function getWithRelationByArondissement($arrondissement_id)
 {
    return DB::table("communes")
    ->join("arrondissements","communes.arrondissement_id","=","arrondissements.id")
    ->join("departements","communes.departement_id","=","departements.id")
    ->join("regions","departements.region_id","=","regions.id")
    ->select("arrondissements.nom as arrondissement","departements.nom as departement","communes.id","regions.nom as region","communes.nom")
    ->where("arrondissements.id",$arrondissement_id)
    ->orderBy("regions.nom")
    ->get();

 }
 public function getWithRelationByCommune($commune_id)
 {
    return DB::table("communes")
    ->join("arrondissements","communes.arrondissement_id","=","arrondissements.id")
    ->join("departements","communes.departement_id","=","departements.id")
    ->join("regions","departements.region_id","=","regions.id")
    ->select("arrondissements.nom as arrondissement","departements.nom as departement","communes.id","regions.nom as region","communes.nom")
    ->where("communes.id",$commune_id)
    ->orderBy("regions.nom")
    ->get();

 }
}
