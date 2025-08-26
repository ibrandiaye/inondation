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
        {!! Form::model($don, ['method'=>'PATCH','route'=>['don.update', $don->id],'enctype'=>'multipart/form-data']) !!}
            @csrf
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE DE MODIFICATION D'UN DON</div>
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
                                        <div class="form-group">
                                            <label>Réceptionniste </label>
                                            <input type="text" name="receptionniste"  value="{{ $don->receptionniste }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nature du don </label>
                                            <input type="text" name="nature"  value="{{ $don->nature }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Valeur du don en FCFA</label>
                                            <input type="number" name="valeur"  value="{{ $don->valeur }}" class="form-control"  required>
                                        </div>
                                    </div>
                                      <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Donneur</label>
                                            <input type="text" name="donneur"  value="{{ $don->donneur }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Date de réception </label>
                                            <input type="date" name="date"  value="{{ $don->date }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cause du sinistre</label>
                                            <input type="text" name="cause"  value="{{ $don->cause }}" class="form-control"  required>
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
