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
        $user = Auth::user();
        $nbLocalite = $this->localiteRepository->countLocalite();
        $nbOperateur = $this->operateurRepository->countOperateur();
        $nbPersonne = $this->personneRepository->countPersonne();

        if($user->role=="admin" )
        {
            $regions = $this->regionRepository->getAll();

        }
        else if($user->role=="gouverneur")
        {
            $departements = $this->departementRepository->getByRegion($user->region_id);
        }
        else if($user->role=="prefet")
        {
            $arrondissements = $this->arrondissementRepository->getByDepartement($user->departement_id);
        }
        else if($user->role=="sous_prefet")
        {
            $communes = $this->communeRepository->getByArrondissement($user->arrondissement_id);

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
      // dd($depts);

        return view('home',compact("regions",
    "departements","arrondissements","communes","nbLocalite","nbOperateur","nbPersonne"));
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

        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne);
        return response()->json($data);

    }
    public function byDepartement($id)
    {
        $localite = $this->localiteRepository->countByDepartement($id);
        $operateur = $this->operateurRepository->countByDepartement($id);

        $personne = $this->personneRepository->countByDepartement($id);

        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne);
        return response()->json($data);

    }
    public function byArrondissement($id)
    {
        $localite = $this->localiteRepository->countByArrondissement($id);
        $operateur = $this->operateurRepository->countByArrondissement($id);

        $personne = $this->personneRepository->countByArrondissement($id);

        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne);
        return response()->json($data);

    }
    public function byCommune($id)
    {
        $localite = $this->localiteRepository->countByCommune($id);
        $operateur = $this->operateurRepository->countByCommune($id);

        $personne = $this->personneRepository->countByCommune($id);

        $data = array('localite'=>$localite,'operateur'=>$operateur,'personne'=>$personne);
        return response()->json($data);


    }

    public function messageByArrondissement($id,$date)
    {
        $communes = $this->communeRepository->getByArrondissement($id);
        $situationSemaine = $this->comptageRepository->situationActuelleByArrondissement($id,$date);
        $situationAncienne = $this->comptageRepository->situationAncieneByArrondissement($id,$date);
        $data=array();
        $index = 0;
        foreach ($communes as $key => $value) {
           $ligne = new \stdClass;
           $ligne->insant = 0;
           $ligne->inssem = 0;
           $ligne->cumulins = 0;

           $ligne->modant = 0;
           $ligne->modsem = 0;
           $ligne->cumulmod = 0;

           $ligne->chanant = 0;
           $ligne->chansem = 0;
           $ligne->cumulchan = 0;

           $ligne->radant = 0;
           $ligne->radsem = 0;
           $ligne->cumulrad = 0;

           $ligne->commune = $value->nom;

           foreach ($situationAncienne as $key => $situAnc) {
                if($situAnc->nom==$value->nom)
                {
                    $ligne->insant = $situAnc->localite;
                    $ligne->modant = $situAnc->operateur;
                    $ligne->chanant = $situAnc->personne;
                    $ligne->radant = $situAnc->radiation;
                    $ligne->cumulins =  $ligne->cumulins + $situAnc->localite;
                    $ligne->cumulmod =  $ligne->cumulmod + $situAnc->operateur;
                    $ligne->cumulchan =  $ligne->cumulchan + $situAnc->personne;
                    $ligne->cumulrad =  $ligne->cumulrad + $situAnc->radiation;


                }

            }
            foreach ($situationSemaine as $key => $situSem) {
                if($situSem->nom==$value->nom)
                {
                    $ligne->inssem = $situSem->localite;
                    $ligne->modsem = $situSem->operateur;
                    $ligne->chansem = $situSem->personne;
                    $ligne->radsem = $situSem->radiation;
                    $ligne->cumulins =  $ligne->cumulins + $situSem->localite;
                    $ligne->cumulmod =  $ligne->cumulmod + $situSem->operateur;
                    $ligne->cumulchan =  $ligne->cumulchan + $situSem->personne;
                    $ligne->cumulrad =  $ligne->cumulrad + $situSem->radiation;


                }

            }
            $data[]=$ligne;
        }
        //dd($data);
      //  return view("situation.par_arrondissement",compact("data"));
      $arrondissement = $this->arrondissementRepository->getOneArrondissementWithdepartementAndRegion($id);
      $semaine = $this->semaineRepository->getOneByDebut($date);

      return view("situation.impression_arrondissement",compact("data","arrondissement","semaine"));


    }

    public function messageByDepartement($id,$date)
    {
        $departement = $this->departementRepository->getOneWithRelation($id);
        $situationSemaine = $this->comptageRepository->situationActuelleByDepartement($id,$date);
        $situationAncienne = $this->comptageRepository->situationAncieneByDepartement($id,$date);
       $semaine = $this->semaineRepository->getOneByDebut($date);
        $data=array($situationSemaine,$situationAncienne);
        $index = 0;
     //  dd($situationSemaine,$situationSemaine,$departement);
        foreach ($departement->arrondissements as $keya => $arrondissement) {
            foreach ($arrondissement->communes as $keyc => $commune) {
                $ligne = new \stdClass;
                $ligne->insant = 0;
                $ligne->inssem = 0;
                $ligne->cumulins = 0;

                $ligne->modant = 0;
                $ligne->modsem = 0;
                $ligne->cumulmod = 0;

                $ligne->chanant = 0;
                $ligne->chansem = 0;
                $ligne->cumulchan = 0;

                $ligne->radant = 0;
                $ligne->radsem = 0;
                $ligne->cumulrad = 0;

                $ligne->commune = $commune->nom;

                foreach ($situationAncienne as $keysa => $situAnc) {
                    if($situAnc->nom==$commune->nom)
                    {
                        $ligne->insant = $situAnc->localite;
                        $ligne->modant = $situAnc->operateur;
                        $ligne->chanant = $situAnc->personne;
                        $ligne->radant = $situAnc->radiation;
                        $ligne->cumulins =  $ligne->cumulins + $situAnc->localite;
                        $ligne->cumulmod =  $ligne->cumulmod + $situAnc->operateur;
                        $ligne->cumulchan =  $ligne->cumulchan + $situAnc->personne;
                        $ligne->cumulrad =  $ligne->cumulrad + $situAnc->radiation;


                    }

                }
                foreach ($situationSemaine as $keyss => $situSem) {
                    if($situSem->nom==$commune->nom)
                    {
                        $ligne->inssem = $situSem->localite;
                        $ligne->modsem = $situSem->operateur;
                        $ligne->chansem = $situSem->personne;
                        $ligne->radsem = $situSem->radiation;
                        $ligne->cumulins =  $ligne->cumulins + $situSem->localite;
                        $ligne->cumulmod =  $ligne->cumulmod + $situSem->operateur;
                        $ligne->cumulchan =  $ligne->cumulchan + $situSem->personne;
                        $ligne->cumulrad =  $ligne->cumulrad + $situSem->radiation;


                    }

                }
               // $data[]=$ligne;
                $departement->arrondissements[$keya]->communes[$keyc]->data = $ligne;
            }

        }
        //dd($departement);
        return view("situation.impression_departement",compact("departement","semaine"));

    }

    public function messageByRegion($id,$date)
    {
        $region = $this->regionRepository->getOneWithRelation($id);
        $situationSemaine = $this->comptageRepository->situationActuelleByRegion($id,$date);
        $situationAncienne = $this->comptageRepository->situationAncieneByRegion($id,$date);
       $semaine = $this->semaineRepository->getOneByDebut($date);
        $data=array($situationSemaine,$situationAncienne);
        $index = 0;
     //  dd($situationSemaine,$situationSemaine,$departement);
     foreach ($region->departements as $keyd => $departement) {
        foreach ($departement->arrondissements as $keya => $arrondissement) {
            foreach ($arrondissement->communes as $keyc => $commune) {
                $ligne = new \stdClass;
                $ligne->insant = 0;
                $ligne->inssem = 0;
                $ligne->cumulins = 0;

                $ligne->modant = 0;
                $ligne->modsem = 0;
                $ligne->cumulmod = 0;

                $ligne->chanant = 0;
                $ligne->chansem = 0;
                $ligne->cumulchan = 0;

                $ligne->radant = 0;
                $ligne->radsem = 0;
                $ligne->cumulrad = 0;

                $ligne->commune = $commune->nom;

                foreach ($situationAncienne as $keysa => $situAnc) {
                    if($situAnc->nom==$commune->nom)
                    {
                        $ligne->insant = $situAnc->localite;
                        $ligne->modant = $situAnc->operateur;
                        $ligne->chanant = $situAnc->personne;
                        $ligne->radant = $situAnc->radiation;
                        $ligne->cumulins =  $ligne->cumulins + $situAnc->localite;
                        $ligne->cumulmod =  $ligne->cumulmod + $situAnc->operateur;
                        $ligne->cumulchan =  $ligne->cumulchan + $situAnc->personne;
                        $ligne->cumulrad =  $ligne->cumulrad + $situAnc->radiation;


                    }

                }
                foreach ($situationSemaine as $keyss => $situSem) {
                    if($situSem->nom==$commune->nom)
                    {
                        $ligne->inssem = $situSem->localite;
                        $ligne->modsem = $situSem->operateur;
                        $ligne->chansem = $situSem->personne;
                        $ligne->radsem = $situSem->radiation;
                        $ligne->cumulins =  $ligne->cumulins + $situSem->localite;
                        $ligne->cumulmod =  $ligne->cumulmod + $situSem->operateur;
                        $ligne->cumulchan =  $ligne->cumulchan + $situSem->personne;
                        $ligne->cumulrad =  $ligne->cumulrad + $situSem->radiation;


                    }

                }
               // $data[]=$ligne;
                $region->departements[$keyd]->arrondissements[$keya]->communes[$keyc]->data = $ligne;
            }

        }
     }

        //dd($departement);
        return view("situation.impression_region",compact("region","semaine"));

    }

    public function messageByNational($date)
    {
        $regions = $this->regionRepository->getALLWithRelation();
        $situationSemaine = $this->comptageRepository->situationActuelleByNational($date);
        $situationAncienne = $this->comptageRepository->situationAncieneByNational($date);
       $semaine = $this->semaineRepository->getOneByDebut($date);
        $data=array($situationSemaine,$situationAncienne);
        $index = 0;
     //  dd($situationSemaine,$situationSemaine,$departement);
     foreach ($regions as $keyr => $region) {
        foreach ($region->departements as $keyd => $departement) {
            foreach ($departement->arrondissements as $keya => $arrondissement) {
                foreach ($arrondissement->communes as $keyc => $commune) {
                    $ligne = new \stdClass;
                    $ligne->insant = 0;
                    $ligne->inssem = 0;
                    $ligne->cumulins = 0;

                    $ligne->modant = 0;
                    $ligne->modsem = 0;
                    $ligne->cumulmod = 0;

                    $ligne->chanant = 0;
                    $ligne->chansem = 0;
                    $ligne->cumulchan = 0;

                    $ligne->radant = 0;
                    $ligne->radsem = 0;
                    $ligne->cumulrad = 0;

                    $ligne->commune = $commune->nom;

                    foreach ($situationAncienne as $keysa => $situAnc) {
                        if($situAnc->nom==$commune->nom)
                        {
                            $ligne->insant = $situAnc->localite;
                            $ligne->modant = $situAnc->operateur;
                            $ligne->chanant = $situAnc->personne;
                            $ligne->radant = $situAnc->radiation;
                            $ligne->cumulins =  $ligne->cumulins + $situAnc->localite;
                            $ligne->cumulmod =  $ligne->cumulmod + $situAnc->operateur;
                            $ligne->cumulchan =  $ligne->cumulchan + $situAnc->personne;
                            $ligne->cumulrad =  $ligne->cumulrad + $situAnc->radiation;


                        }

                    }
                    foreach ($situationSemaine as $keyss => $situSem) {
                        if($situSem->nom==$commune->nom)
                        {
                            $ligne->inssem = $situSem->localite;
                            $ligne->modsem = $situSem->operateur;
                            $ligne->chansem = $situSem->personne;
                            $ligne->radsem = $situSem->radiation;
                            $ligne->cumulins =  $ligne->cumulins + $situSem->localite;
                            $ligne->cumulmod =  $ligne->cumulmod + $situSem->operateur;
                            $ligne->cumulchan =  $ligne->cumulchan + $situSem->personne;
                            $ligne->cumulrad =  $ligne->cumulrad + $situSem->radiation;


                        }

                    }
                   // $data[]=$ligne;
                    $regions[$keyr]->departements[$keyd]->arrondissements[$keya]->communes[$keyc]->data = $ligne;
                }

            }
         }
     }


        //dd($departement);
        return view("situation.impression_national",compact("regions","semaine"));

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

