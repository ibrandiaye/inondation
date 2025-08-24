<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CommuneRepository;
use App\Repositories\ComptageRepository;
use App\Repositories\DepartementRepository;
use App\Repositories\LocaliteRepository;
use App\Repositories\OperateurRepository;
use App\Repositories\PersonneRepository;
use App\Repositories\RegionRepository;
use App\Repositories\SemaineRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $regionRepository;
    protected $communeRepository;
    protected $departementRepository;
    protected $arrondissementRepository;
    protected $operateurRepository;
    protected $localiteRepository;
    protected $personneRepository;

    public function __construct(RegionRepository $regionRepository,CommuneRepository $communeRepository,
    DepartementRepository $departementRepository,ArrondissementRepository $arrondissementRepository,
    OperateurRepository $operateurRepository,LocaliteRepository $localiteRepository,PersonneRepository $personneRepository)
    {
        $this->middleware('auth');
        $this->regionRepository = $regionRepository;
        $this->communeRepository = $communeRepository;
        $this->departementRepository = $departementRepository;
        $this->arrondissementRepository= $arrondissementRepository;
        $this->operateurRepository = $operateurRepository;
        $this->localiteRepository = $localiteRepository;
        $this->personneRepository = $personneRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $regions =[];
        $departements =[];
        $arrondissements =[];
        $communes =[];
        $tabStats = [];
        $user = Auth::user();
        $nbLocalite = $this->localiteRepository->countLocalite();
        $nbOperateur = $this->operateurRepository->countOperateur();
        $nbPersonne = $this->personneRepository->countPersonne();
        $nonSinistre = $this->localiteRepository->countLocaliteNonSinistre();
        $sommeCout = $this->operateurRepository->sommeCout();

        $sommeByLocalite = $this->operateurRepository->sommeMontantParLocalite();
        //dd($sommeByLocalite);
        $tabStats = $this->operateurRepository->sommeMontantParLocalite();

        if($user->role=="admin" )
        {
            $regions = $this->regionRepository->getALLWithRelation();
            foreach ($regions as $key => $region) {
                foreach ($region->departements as $keyr => $departement) {

                    foreach ($departement->arrondissements as $keya => $arrondissement) {
                        foreach ($arrondissement->communes as $keyc => $commune) {
                            foreach ($commune->localites as $keyl => $localite) {
                                foreach ($tabStats as $keytab => $tabStat) {
                                    if($tabStat->id == $localite->id)
                                    {
                                        $regions[$key]->departements[$keyr]->arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                        $tabStats[$keytab]->{"localite"} = $localite;
                                        $tabStats[$keytab]->{"region"} = $region->nom;
                                        $tabStats[$keytab]->{"departement"} = $departement->nom;
                                          $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                        $tabStats[$keytab]->{"commune"} = $commune->nom;
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
        else if($user->role=="gouverneur")
        {
            $departements = $this->departementRepository->getByRegionWithRelation($user->region_id);
             foreach ($departements as $keyr => $departement) {

                    foreach ($departement->arrondissements as $keya => $arrondissement) {
                        foreach ($arrondissement->communes as $keyc => $commune) {
                            foreach ($commune->localites as $keyl => $localite) {
                                foreach ($tabStats as $keytab => $tabStat) {
                                    if($tabStat->id == $localite->id)
                                    {
                                        $departements[$keyr]->arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                        $tabStats[$keytab]->{"localite"} = $localite;
                                        $tabStats[$keytab]->{"departement"} = $departement->nom;
                                          $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                        $tabStats[$keytab]->{"commune"} = $commune->nom;
                                    }
                                }
                            }
                        }
                    }
                }
        }
        else if($user->role=="prefet")
        {
            $arrondissements = $this->arrondissementRepository->getByDepartementWithRelation($user->departement_id);
            foreach ($arrondissements as $keya => $arrondissement) {
                foreach ($arrondissement->communes as $keyc => $commune) {
                    foreach ($commune->localites as $keyl => $localite) {
                        foreach ($tabStats as $keytab => $tabStat) {
                            if($tabStat->id == $localite->id)
                            {
                                $arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                $tabStats[$keytab]->{"localite"} = $localite;
                                $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                $tabStats[$keytab]->{"commune"} = $commune->nom;
                            }
                        }
                    }
                }
            }
        }
        else if($user->role=="sous_prefet")
        {
            $communes = $this->communeRepository->getByArrondissementWithRelation($user->arrondissement_id);
            foreach ($communes as $keyc => $commune) {
                    foreach ($commune->localites as $keyl => $localite) {
                        foreach ($tabStats as $keytab => $tabStat) {
                            if($tabStat->id == $localite->id)
                            {
                                $communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                $tabStats[$keytab]->{"localite"} = $localite;
                                $tabStats[$keytab]->{"commune"} = $commune->nom;
                            }
                        }
                    }
                }

        }
        if($user->role=="admin" )
        {
            $depts = $this->departementRepository->getAllOnlyOrderByRegion();
        }
        else
        {
           $situationPasDepartements=[];
           $depts=[];
        }
       //dd($tabStats);

        return view('home',compact("regions",
    "departements","arrondissements","communes","nbLocalite"
        ,"nbOperateur","nbPersonne","sommeCout","tabStats","nonSinistre"));
    }

    public function statByCommune($commune)
    {
       $data = $this->comptageRepository->statByComune($commune);
        return response()->json($data);
    }

    public function byRegion($id)
    {
        $localite = $this->localiteRepository->countByRegion($id);
        $operateur = $this->operateurRepository->countByRegion($id);

        $personne = $this->personneRepository->countByRegion($id);
        $sommeCout = $this->operateurRepository->sommeCoutRegion($id);
        $nonSinistre = $this->localiteRepository->countByRegionNonSinistre($id);
        $data = array('localite'=>$localite,'operateur'=>$operateur,
        'sommeCout'=>$sommeCout,'personne'=>$personne,'nonSinistre'=>$nonSinistre);
        return response()->json($data);

    }
    public function byDepartement($id)
    {
        $localite = $this->localiteRepository->countByDepartement($id);
        $operateur = $this->operateurRepository->countByDepartement($id);

        $personne = $this->personneRepository->countByDepartement($id);
         $sommeCout = $this->operateurRepository->sommeCoutDepartement($id);
         $nonSinistre = $this->localiteRepository->countByDepartementNonSinistre($id);
        $data = array('localite'=>$localite,'operateur'=>$operateur,
        'sommeCout'=>$sommeCout,'personne'=>$personne,'nonSinistre'=>$nonSinistre);
        return response()->json($data);

    }
    public function byArrondissement($id)
    {
        $localite = $this->localiteRepository->countByArrondissement($id);
        $operateur = $this->operateurRepository->countByArrondissement($id);

        $personne = $this->personneRepository->countByArrondissement($id);
        $sommeCout = $this->operateurRepository->sommeCoutArrondissement($id);
        $nonSinistre = $this->localiteRepository->countByArrondissementNonSinistre($id);
        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne,
        'sommeCout'=>$sommeCout,'nonSinistre'=>$nonSinistre);
        return response()->json($data);

    }
    public function byCommune($id)
    {
        $localite = $this->localiteRepository->countByCommune($id);
        $operateur = $this->operateurRepository->countByCommune($id);

        $personne = $this->personneRepository->countByCommune($id);
        $sommeCout = $this->operateurRepository->sommeCoutCommune($id);
        $nonSinistre = $this->localiteRepository->countByCommuneNonSinistre($id);
        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne,
    'sommeCout'=>$sommeCout,'nonSinistre'=>$nonSinistre);
        return response()->json($data);


    }

    public function messageByArrondissement(Request $request)
    {
        $user = Auth::user();
       // $communes = $this->communeRepository->getByArrondissement($user->arrondissement_id);
        $arrondissement = $this->arrondissementRepository->getOneArrondissementWithdepartementAndRegion($user->arrondissement_id);
        $communes = $this->communeRepository->getByArrondissementWithRelation($user->arrondissement_id);
        $tabStats=[];
        $tabStats = $this->operateurRepository->sommeMontantParLocaliteDate($user,$request->start,$request->end);
        foreach ($communes as $keyc => $commune) {
                foreach ($commune->localites as $keyl => $localite) {
                    foreach ($tabStats as $keytab => $tabStat) {
                        if($tabStat->id == $localite->id)
                        {
                            $communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                            $tabStats[$keytab]->{"localite"} = $localite;
                            $tabStats[$keytab]->{"commune"} = $commune->nom;
                        }
                    }
                }
            }

            $debut = $request->start;
            $fin = $request->end;
      return view("situation.impression_arrondissement",compact("tabStats","arrondissement",
    "debut","fin"));


    }

    public function messageByDepartement(Request $request)
    {
         $user = Auth::user();
        $departement = $this->departementRepository->getOneWithRelation($user->departement_id);
        $arrondissements = $this->arrondissementRepository->getByDepartementWithRelation($user->departement_id);
         $tabStats=[];
        $tabStats = $this->operateurRepository->sommeMontantParLocaliteDate($user,$request->start,$request->end);
        foreach ($arrondissements as $keya => $arrondissement) {
                foreach ($arrondissement->communes as $keyc => $commune) {
                    foreach ($commune->localites as $keyl => $localite) {
                        foreach ($tabStats as $keytab => $tabStat) {
                            if($tabStat->id == $localite->id)
                            {
                                $arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                $tabStats[$keytab]->{"localite"} = $localite;
                                $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                $tabStats[$keytab]->{"commune"} = $commune->nom;
                            }
                        }
                    }
                }
            }
             $debut = $request->start;
            $fin = $request->end;
        return view("situation.impression_departement",compact("departement","tabStats",
    "debut","fin"));

    }

    public function messageByRegion(Request $request)
    {
        $user = Auth::user();
        $region = $this->regionRepository->getOneWithRelation($user->region_id);


        $departements = $this->departementRepository->getByRegionWithRelation($user->region_id);
         $tabStats=[];
        $tabStats = $this->operateurRepository->sommeMontantParLocaliteDate($user,$request->start,$request->end);
        foreach ($departements as $keyr => $departement) {

            foreach ($departement->arrondissements as $keya => $arrondissement) {
                foreach ($arrondissement->communes as $keyc => $commune) {
                    foreach ($commune->localites as $keyl => $localite) {
                        foreach ($tabStats as $keytab => $tabStat) {
                            if($tabStat->id == $localite->id)
                            {
                                $departements[$keyr]->arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                $tabStats[$keytab]->{"localite"} = $localite;
                                $tabStats[$keytab]->{"departement"} = $departement->nom;
                                $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                $tabStats[$keytab]->{"commune"} = $commune->nom;
                            }
                        }
                    }
                }
            }
        }
         $debut = $request->start;
        $fin = $request->end;
        return view("situation.impression_region",compact("region","tabStats",
    "debut","fin"));

    }

    public function messageByNational(Request $request)
    {
         $user = Auth::user();
        $regions = $this->regionRepository->getALLWithRelation();


     //  dd($situationSemaine,$situationSemaine,$departement);
     foreach ($regions as $keyr => $region) {
        foreach ($region->departements as $keyd => $departement) {
            foreach ($departement->arrondissements as $keya => $arrondissement) {
                foreach ($arrondissement->communes as $keyc => $commune) {
                                 $regions[$keyr]->departements[$keyd]->arrondissements[$keya]->communes[$keyc]->data = "";
                }

            }
         }
     }


     $tabStats = $this->operateurRepository->sommeMontantParLocaliteDate($user,$request->start,$request->end);
        //dd($departement);
            foreach ($regions as $key => $region) {
                foreach ($region->departements as $keyr => $departement) {

                    foreach ($departement->arrondissements as $keya => $arrondissement) {
                        foreach ($arrondissement->communes as $keyc => $commune) {
                            foreach ($commune->localites as $keyl => $localite) {
                                foreach ($tabStats as $keytab => $tabStat) {
                                    if($tabStat->id == $localite->id)
                                    {
                                        $regions[$key]->departements[$keyr]->arrondissements[$keya]->communes[$keyc]->localites[$keyl]->{"montant"} = $tabStat->montant;
                                        $tabStats[$keytab]->{"localite"} = $localite;
                                        $tabStats[$keytab]->{"region"} = $region->nom;
                                        $tabStats[$keytab]->{"departement"} = $departement->nom;
                                          $tabStats[$keytab]->{"arrondissement"} = $arrondissement->nom;
                                        $tabStats[$keytab]->{"commune"} = $commune->nom;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $debut = $request->start;
            $fin = $request->end;
        return view("situation.impression_national",compact("regions","tabStats",
    "debut","fin"));

    }

    public function statByDepartement()
    {
        $depts = $this->departementRepository->getAllOnlyOrderByRegion();
        $situationPasDepartements = $this->comptageRepository->situationGroupByDepartement();
        foreach ($depts as $key => $dept) {
            $depts[$key] = new stdClass;
            $depts[$key]->nom  = $dept->nom;
            $depts[$key]->localite  = 0;
            $depts[$key]->operateur = 0;
            $depts[$key]->personne = 0;
            $depts[$key]->radiation = 0;
            foreach ($situationPasDepartements as $key1 => $situationPasDepartement) {
                if($situationPasDepartement->nom==$dept->nom)
                {
                    $depts[$key]->localite  = $situationPasDepartement->localite;
                    $depts[$key]->personne = $situationPasDepartement->personne;
                    $depts[$key]->operateur = $situationPasDepartement->operateur;
                    $depts[$key]->radiation = $situationPasDepartement->radiation;
                }
            }
        }
        return view("situation.impression_departement_1",compact("depts","situationPasDepartements"));
    }
}

