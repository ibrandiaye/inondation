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
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Departement </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer un Departement</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        {!! Form::model($localite, ['method'=>'PATCH','route'=>['localite.update', $localite->id],'enctype'=>'multipart/form-data']) !!}
            @csrf
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE DE MODIFICATION D'une Localite</div>
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
                                            <input type="text" name="nature"  value="{{ $localite->nature }}" class="form-control"  required>
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
