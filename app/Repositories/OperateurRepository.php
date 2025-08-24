<?php
namespace App\Repositories;

use App\Models\Operateur;
use App\Repositories\RessourceRepository;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OperateurRepository extends RessourceRepository{
    public function __construct(Operateur $operateur){
        $this->model = $operateur;
    }

    public function get()
    {
        $user = Auth::user();
        if ($user->role=="sous_prefet") {
            return  DB::table("operateurs")
            ->join("communes", "operateurs.commune_id", "=", "communes.id")
            ->join("departements","communes.departement_id","=","departements.id")
            ->join("regions","departements.region_id","=","regions.id")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->select("operateurs.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region",
            "communes.arrondissement_id","localites.localite")
            ->where("communes.arrondissement_id",$user->arrondissement_id)
            ->get();
        }
        elseif ($user->role=="prefet") {
            return  DB::table("operateurs")
             ->join("communes", "operateurs.commune_id", "=", "communes.id")
            ->join("departements","communes.departement_id","=","departements.id")
            ->join("regions","departements.region_id","=","regions.id")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->select("operateurs.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region",
            "communes.arrondissement_id","localites.localite")
            ->where("communes.departement_id",$user->departement_id)
            ->get();
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("operateurs")
             ->join("communes", "operateurs.commune_id", "=", "communes.id")
            ->join("departements","communes.departement_id","=","departements.id")
            ->join("regions","departements.region_id","=","regions.id")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->select("operateurs.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region",
            "communes.arrondissement_id","localites.localite")
            ->where("departements.region_id",$user->region_id)
            ->get();
        }
        return DB::table("operateurs")
        ->join("communes", "operateurs.commune_id", "=", "communes.id")
        ->join("departements","communes.departement_id","=","departements.id")
        ->join("regions","departements.region_id","=","regions.id")
        ->join("localites","operateurs.localite_id","=","localites.id")

        ->select("operateurs.*", "communes.nom as commune", "departements.nom as departement", "regions.nom as region",
        "communes.arrondissement_id","localites.localite")
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

    public function sommeCout(){
         $user = Auth::user();
        if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
            return  DB::table("operateurs")
            ->sum("cout");
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.arrondissement_id",$user->arrondissement_id)
            ->sum("operateurs.cout");
        }
        elseif ($user->role=="prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.departement_id",$user->departement_id)
             ->sum("operateurs.cout");
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("departements","communes.departement_id","=","departements.id")

            ->where("departements.region_id",$user->region_id)
            ->sum("operateurs.cout");
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


    public function sommeCoutRegion($id){

        return  DB::table("operateurs")
        ->join("communes","operateurs.commune_id","=","communes.id")
        ->join('departements',"communes.departement_id","=","departements.id")
        ->where("departements.region_id",$id)
        ->sum("operateurs.cout");

    }
     public function sommeCoutDepartement($id){

            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->where("communes.departement_id",$id)
            ->sum("operateurs.cout");


    }

     public function sommeCoutArrondissement($id){
        return  DB::table("operateurs")
        ->join("communes","operateurs.commune_id","=","communes.id")

        ->where("communes.arrondissement_id",$id)

        ->sum("operateurs.cout");


    }
    public function sommeCoutCommune($id){

        return  DB::table("operateurs")
        ->where("commune_id",$id)
        ->sum("operateurs.cout");

    }

public function sommeMontantParLocalite()
    {
         $user = Auth::user();


         if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
             return DB::table("operateurs")
        ->join("localites","operateurs.localite_id","=","localites.id")
        ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
        )
        ->groupBy('localites.id')
        ->get();
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("localites","operateurs.localite_id","=","localites.id")
            ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where( "communes.arrondissement_id",$user->arrondissement_id)
            ->get();

        }
        elseif ($user->role=="prefet") {
            return  DB::table("operateurs")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->join("communes","operateurs.commune_id","=","communes.id")
            ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where("communes.departement_id",$user->departement_id)
            ->get();
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("operateurs")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("departements","communes.departement_id","=","departements.id")
             ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where("departements.region_id",$user->region_id)
            ->get();
        }
    }

    public function sommeMontantParLocaliteDate($user,$start,$end)
    {

        $start = new DateTime($end);
        $start = $start->sub(new DateInterval('P1D'));
        $start = $start->format('Y-m-d');

         if($user->role=="admin" || $user->role=='superviseur' || $user->role=='correcteur')
        {
             return DB::table("operateurs")
        ->join("localites","operateurs.localite_id","=","localites.id")
        ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
        )
        ->groupBy('localites.id')
        ->whereBetween("localites.created_at",[$start,$end])
        ->get();
        }
        elseif ($user->role=="sous_prefet") {
            return  DB::table("operateurs")
            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("localites","operateurs.localite_id","=","localites.id")
            ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where( "communes.arrondissement_id",$user->arrondissement_id)
             ->whereBetween("localites.created_at",[$start,$end])
            ->get();

        }
        elseif ($user->role=="prefet") {
            return  DB::table("operateurs")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->join("communes","operateurs.commune_id","=","communes.id")
            ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where("communes.departement_id",$user->departement_id)
             ->whereBetween("localites.created_at",[$start,$end])
            ->get();
        }
        elseif ($user->role=="gouverneur") {
            return  DB::table("operateurs")
            ->join("localites","operateurs.localite_id","=","localites.id")

            ->join("communes","operateurs.commune_id","=","communes.id")
            ->join("departements","communes.departement_id","=","departements.id")
             ->select(
            'localites.id',
            DB::raw('sum(operateurs.cout) as montant'),
            )
            ->groupBy('localites.id')
            ->where("departements.region_id",$user->region_id)
             ->whereBetween("localites.created_at",[$start,$end])
            ->get();
        }
    }


}
