<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CommuneRepository;
use App\Repositories\LocaliteRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocaliteController extends Controller
{
       protected $communeRepository;
    protected $regionRepository;
    protected $localiteRepository;
    protected $arrondissementRepository;

    public function __construct( CommuneRepository $communeRepository,RegionRepository $regionRepository,
    LocaliteRepository $localiteRepository,ArrondissementRepository $arrondissementRepository){
        $this->communeRepository = $communeRepository;
        $this->regionRepository = $regionRepository;
        $this->localiteRepository = $localiteRepository;
        $this->arrondissementRepository = $arrondissementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localites = $this->localiteRepository->get();
       // dd($localites);
       $arrondissements = $this->arrondissementRepository->getAllOnLy();
       foreach($localites as $localite)
       {
        foreach($arrondissements as $arrondissement)
        {
            if($localite->arrondissement_id==$arrondissement->id)
            {
                $localite->arrondissement = $arrondissement->nom;
            }
        }
       }
        return view('localite.index',compact('localites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if($user->role=="correcteur" || $user->role=="admin" )
        {
            $regions = $this->regionRepository->getAllOnLy();
            //  dd(Auth::user()->arrondissement_id);
              return view('localite.addc',compact('regions'));
        }
        else
        {
            $communes = $this->communeRepository->getByArrondissement($user->arrondissement_id);
            //  dd(Auth::user()->arrondissement_id);
              return view('localite.add',compact('communes',));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'commune_id' => 'required',

        ]);

        $user = Auth::user();
        $localites = $this->localiteRepository->store($request->all());

        return redirect('localite');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $localite = $this->localiteRepository->getById($id);
        $user = Auth::user();
        return view('localite.bordereau',compact('localite','user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        if($user->role=="prefet" || $user->role=="sous_prefet")
        {
            $communes = $this->communeRepository->getByArrondissement(Auth::user()->arrondissement_id);

        }
        else
        {
            $communes =$this->communeRepository->getAllOnLy();
        }
        $localite = $this->localiteRepository->getById($id);
        return view('localite.edit',compact('localite','communes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->localiteRepository->update($id, $request->all());
        return redirect('localite');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->localiteRepository->destroy($id);
        return redirect('localite');
    }}
