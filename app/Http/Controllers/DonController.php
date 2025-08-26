<?php

namespace App\Http\Controllers;

use App\Repositories\ArrondissementRepository;
use App\Repositories\DepartementRepository;
use App\Repositories\DonRepository;
use App\Repositories\RegionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonController extends Controller
{
    protected $regionRepository;
    protected $departementRepository;
    protected $arrondissementRepository;
    protected $donRepository;

    public function __construct(RegionRepository $regionRepository,
    DepartementRepository $departementRepository,ArrondissementRepository $arrondissementRepository,
    DonRepository $donRepository)
    {
        $this->regionRepository = $regionRepository;
        $this->departementRepository = $departementRepository;
        $this->arrondissementRepository= $arrondissementRepository;
        $this->donRepository = $donRepository;

    }

    public function index()
    {

        $user = Auth::user();
        if($user->role == 'admin' || $user->role=="superviseur") {
            $dons = $this->donRepository->getAll();
        }
        else{
            $dons = $this->donRepository->getDonByUser($user);
        }
        //$dons = $this->donRepository->getAll();
        return view('don.index',compact('dons'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('don.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $user = Auth::user();
         if($user->role == 'gouverneur') {
            $request->merge(['region_id' => $user->region_id]);
         }
         elseif ($user->role == 'prefet') {
            $request->merge(['departement_id' => $user->departement_id]);
         }
          elseif ($user->role == 'sous_prefet') {
            $request->merge(['arrondissement_id' => $user->arrondissement_id]);
         }
        $dons = $this->donRepository->store($request->all());
        return redirect('don');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $don = $this->donRepository->getById($id);
        return view('don.show',compact('don'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $don = $this->donRepository->getById($id);
        return view('don.edit',compact('don'));
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

        $this->donRepository->update($id, $request->all());
        return redirect('don');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->donRepository->destroy($id);
        return redirect('don');
    }
}
