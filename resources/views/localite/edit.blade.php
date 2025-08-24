{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Modifier Région')

@section('content')

<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Localité </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer une localité</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        {!! Form::model($localite, ['method'=>'PATCH','route'=>['localite.update', $localite->id],'enctype'=>'multipart/form-data']) !!}
            @csrf
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE DE MODIFICATION D'UNE LOCALITE</div>
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-6">
                                        <label>Nom Commune</label>
                                        <select class="form-control" name="commune_id" required="">
                                           <option value="">Selectionnez</option>
                                            @foreach ($communes as $commune)
                                            <option value="{{$commune->id}}" {{$localite->commune_id==$commune->id ? 'selected' : ''}}>{{$commune->nom}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Localité</label>
                                            <input type="text" name="localite"  value="{{ $localite->localite }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nature du bien impacté</label>
                                            <select id="nature" name="nature" class="form-control">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="route" {{ $localite->nature == "route" ? 'selected' : '' }}>Route</option>
                                                <option value="pont" {{ $localite->nature == "pont" ? 'selected' : '' }}>Pont</option>
                                                <option value="ecole" {{ $localite->nature == "ecole" ? 'selected' : '' }}>École</option>
                                                <option value="aeroport" {{ $localite->nature == "aeroport" ? 'selected' : '' }}>Aéroports</option>
                                                <option value="sante" {{ $localite->nature == "sante" ? 'selected' : '' }}>Structures sanitaires</option>
                                                <option value="culte" {{ $localite->nature == "culte" ? 'selected' : '' }}>Lieux de cultes</option>
                                                <option value="habitation" {{ $localite->nature == "habitation" ? 'selected' : '' }}>Habitations</option>
                                                <option value="jeux" {{ $localite->nature == "jeux" ? 'selected' : '' }}>Aires de jeux</option>
                                                <option value="transport" {{ $localite->nature == "transport" ? 'selected' : '' }}>Transports</option>
                                                <option value="agriculteur" {{ $localite->nature == "agriculteur" ? 'selected' : '' }}>Agriculteurs</option>
                                                <option value="elevage" {{ $localite->nature == "elevage" ? 'selected' : '' }}>Élevages</option>
                                                <option value="commerce" {{ $localite->nature == "commerce" ? 'selected' : '' }}>Commerces</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cause du sinistre</label>
                                            <input type="text" name="cause"  value="{{ $localite->cause }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Mesure prise</label>
                                            <input type="text" name="mesure"  value="{{ $localite->mesure }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Mesure envisagée</label>
                                            <input type="text" name="mesureen"  value="{{ $localite->mesureen }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Point d’attention</label>
                                            <input type="text" name="attention"  value="{{ $localite->attention }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Solution préconisée</label>
                                            <input type="text" name="solution"  value="{{ $localite->solution }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Besoin </label>
                                            <input type="text" name="besoin"  value="{{ $localite->besoin }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <label>Etat</label>
                                        <select class="form-control" name="etat" id="etat" required="">
                                           <option value="">Selectionnez</option>
                                            <option value="sinistre" {{ old('etat'=='sinistre' ? 'selected' : '') }}>sinistre</option>
                                            <option value="sinistre resolu" {{ old('etat'=='sinistre resolu' ? 'selected' : '') }}>sinistre resolu</option>

                                        </select>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Document </label>
                                            <input type="file" name="document"   class="form-control"  >
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <center>
                                        <button type="submit" class="btn btn-success btn btn-lg "> MODIFIER</button>
                                    </center>
                                </div>


                            </div>
                        </div>
    {!! Form::close() !!}
    </div>
</div>


@endsection
