<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\CommuneRepository;
use App\Repositories\OperateurRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperateurController extends Controller
{
   protected $communeRepository;
    protected $regionRepository;
    protected $operateurRepository;
    protected $arrondissementRepository;

    public function __construct( CommuneRepository $communeRepository,RegionRepository $regionRepository,
    OperateurRepository $operateurRepository,ArrondissementRepository $arrondissementRepository){
        $this->communeRepository = $communeRepository;
        $this->regionRepository = $regionRepository;
        $this->operateurRepository = $operateurRepository;
        $this->arrondissementRepository = $arrondissementRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $operateurs = $this->operateurRepository->get();
       // dd($operateurs);
       $arrondissements = $this->arrondissementRepository->getAllOnLy();
       foreach($operateurs as $operateur)
       {
        foreach($arrondissements as $arrondissement)
        {
            if($operateur->arrondissement_id==$arrondissement->id)
            {
                $operateur->arrondissement = $arrondissement->nom;
            }
        }
       }
        return view('operateur.index',compact('operateurs'));
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
              return view('operateur.addc',compact('regions'));
        }
        else
        {
            $communes = $this->communeRepository->getByArrondissement($user->arrondissement_id);
            //  dd(Auth::user()->arrondissement_id);
              return view('operateur.add',compact('communes',));
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
        $operateurs = $this->operateurRepository->store($request->all());

        return redirect('operateur');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $operateur = $this->operateurRepository->getById($id);
        $user = Auth::user();
        return view('operateur.bordereau',compact('operateur','user'));
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
        $operateur = $this->operateurRepository->getById($id);
        return view('operateur.edit',compact('operateur','communes'));
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
        $this->operateurRepository->update($id, $request->all());
        return redirect('operateur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->operateurRepository->destroy($id);
        return redirect('operateur');
    }
    public function    byCommune($commune){
        $operateurs = $this->operateurRepository->getByCommune($commune);
        return response()->json($operateurs);
    }
}
