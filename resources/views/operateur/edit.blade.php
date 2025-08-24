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
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Opérateur </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer un opérateur</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        {!! Form::model($operateur, ['method'=>'PATCH','route'=>['operateur.update', $operateur->id],'enctype'=>'multipart/form-data']) !!}
            @csrf
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE DE MODIFICATION D'UN OPERATEUR</div>
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
                                            <option value="{{$commune->id}}" {{$operateur->commune_id==$commune->id ? 'selected' : ''}}>{{$commune->nom}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                  <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Localité</label>
                                            <input type="text" name="localite"  value="{{ $operateur->localite }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nature du bien impacté</label>
                                            <input type="text" name="nature"  value="{{ $operateur->nature }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cause du sinistre</label>
                                            <input type="text" name="cause"  value="{{ $operateur->cause }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Prénom</label>
                                            <input type="text" name="prenom"  value="{{ $operateur->prenom }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="nom"  value="{{ $operateur->nom }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Téléphone</label>
                                            <input type="text" name="tel"  value="{{ $operateur->tel }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Superficie sinistrée (ha) Ou quantité</label>
                                            <input type="text" name="superficie"  value="{{ $operateur->superficie }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Source de financement </label>
                                            <input type="text" name="financement"  value="{{ $operateur->financement }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>OP est-elle assurée ? (Oui ou Non)</label>
                                            <select class="form-control" name="op" id="op" >
                                                <option value="">Selectionner</option>
                                                <option value="oui" {{  $operateur->op=="oui" ? 'selected' : '' }}>Oui</option>
                                                <option value="non" {{  $operateur->op=="non" ? 'selected' : '' }}>Non</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Coût des dégâts estimé en FCFA</label>
                                            <input type="text" name="cout"  value="{{ $operateur->cout }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>commentaire</label>
                                            <textarea class="form-control" name="commentaire" required> {{ $operateur->commentaire}} </textarea>
                                        </div>
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
