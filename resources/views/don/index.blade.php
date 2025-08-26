@extends('welcome')
@section('title', '| don')


@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Don </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer un Don</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
         @php
            $user = Auth::user();
        @endphp
    <div class="card ">
        <div class="card-header  text-center">LISTE D'ENREGISTREMENT DES DONS
             <div class="float-right">
                @if(Auth::user()->role!="superviseur") <a href="{{ route('don.create') }}" class="btn btn-primary">Ajouter un Don</a>@endif
            </div>
        </div>
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered table-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            @if($user->role=="gouverneur" || $user->role=="admin" || $user->role=="superviseur")<th>Region  </th>@endif
                             @if($user->role=="prefet" || $user->role=="admin" || $user->role=="superviseur")<th>Département</th>@endif
                             @if($user->role=="sous_prefet" || $user->role=="admin" || $user->role=="superviseur")<th>Arrondissement </th>@endif
                            <th>Réceptionniste  </th>
                            <th>Nature du don </th>
                            <th>Valeur du don en FCFA</th>
                            <th>Donneur</th>
                            <th>Date de réception </th>
                            <th>Cause du sinistre</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dons as $don)
                        <tr>
                            @if($user->role=="gouverneur" || $user->role=="admin"|| $user->role=="superviseur" )<td>@if($don->region){{ $don->region->nom }}@endif</td>@endif
                            @if($user->role=="prefet" || $user->role=="admin" || $user->role=="superviseur")<td>@if($don->departement){{ $don->departement->nom }}@endif</td>@endif
                            @if($user->role=="sous_prefet" || $user->role=="admin" || $user->role=="superviseur")<td>@if($don->arrondissement){{ $don->arrondissement->nom }}@endif </td>@endif
                            <td>{{ $don->receptionniste }}</td>
                            <td>{{ $don->nature }}</td>
                            <td>{{ $don->valeur }}</td>
                            <td>{{ $don->donneur }}</td>
                            <td>{{ $don->date }}</td>
                            <td>{{ $don->cause }}</td>
                            <td>
                                <a href="{{ route('don.edit', $don->id) }}" role="button" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE', 'route'=>['don.destroy', $don->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}


                                {{-- <a href="{{ route('don.show', $don->id) }}" role="button" class="btn btn-warning"><i toolip="B" class="fas fa-file"></i></a> --}}

                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>



            </div>

    </div>
</div>
</div>


@endsection
