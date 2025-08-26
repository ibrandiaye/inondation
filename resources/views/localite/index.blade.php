@extends('welcome')
@section('title', '| localite')


@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Localite </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer un Localite</h4>
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

    <div class="card ">
        <div class="card-header  text-center">LISTE D'ENREGISTREMENT DES LOCALITES
             <div class="float-right">
              @if(Auth::user()->role!="superviseur")  <a href="{{ route('localite.create') }}" class="btn btn-primary">Ajouter une localité</a>@endif
            </div>
        </div>
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered table-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Operation</th>
                            <th>Région </th>
                            <th>Département</th>
                            <th>Arrondissement </th>
                            <th>Commune </th>
                            <th>Localité</th>
                            <th>Nature du bien impacté</th>
                            <th>Cause du sinistre</th>
                            <th>Mesure prise</th>
                            <th>Mesure envisagée</th>
                            <th>Point d’attention</th>
                            <th>Solution préconisée  </th>
                            <th>Besoin</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($localites as $localite)
                        <tr>
                            <td>
                                <div class="btn-group" role="group">
                                   @if(Auth::user()->role!="superviseur")  <a class="btn btn-outline-primary btn-sm" title="Ajouter une personne"
                                    href="{{ route('ajouter.personne', ['localite'=>$localite->id]) }}">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    <a class="btn btn-outline-primary btn-sm" title="Ajouter un opérateur"
                                    href="{{ route('ajouter.operateur', ['localite'=>$localite->id]) }}">
                                        <i class="fas fa-user-cog"></i>
                                    </a>@endif
                                </div>
                            </td>
                            <td>{{ $localite->region }}</td>
                            <td>{{ $localite->departement }}</td>
                            <td>{{ $localite->arrondissement }} </td>
                            <td>{{ $localite->commune }}</td>
                            <td>{{ $localite->localite }}</td>
                            <td>{{ $localite->nature }}</td>
                            <td>{{ $localite->cause }}</td>
                            <td>{{ $localite->mesure }}</td>
                            <td>{{ $localite->mesureen }}</td>
                            <td>{{ $localite->attention }}</td>
                            <td>{{ $localite->solution }}</td>
                            <td>{{ $localite->besoin }}</td>
                            <td>{{ $localite->commentaire }}</td>
                            <td>
                                <a href="{{ route('localite.edit', $localite->id) }}" role="button" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE', 'route'=>['localite.destroy', $localite->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}


                                {{-- <a href="{{ route('localite.show', $localite->id) }}" role="button" class="btn btn-warning"><i toolip="B" class="fas fa-file"></i></a> --}}

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
