@extends('welcome')
@section('title', '| operateur')


@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Operateur </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer un Operateur</h4>
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
        <div class="card-header  text-center">LISTE D'ENREGISTREMENT DES Operateurs
             <div class="float-right">
                <a href="{{ route('operateur.create') }}" class="btn btn-primary">Ajouter un opérateur</a>
            </div>
        </div>
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered table-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Région </th>
                            <th>Département</th>
                            <th>Arrondissement </th>
                            <th>Commune </th>
                            <th>Localité</th>
                            <th>Nature du bien impacté</th>
                            <th>Cause du sinistre</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Téléphone</th>
                            <th>Superficie sinistrée (ha) Ou quantité</th>
                            <th>Source de financement</th>
                            <th> OP est-elle assurée ? (Oui ou Non) </th>
                            <th>Coût des dégâts estimé en FCFA</th>
                            <th>Commentaire</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($operateurs as $operateur)
                        <tr>
                            <td>{{ $operateur->region }}</td>
                            <td>{{ $operateur->departement }}</td>
                            <td>{{ $operateur->arrondissement }} </td>
                            <td>{{ $operateur->commune }}</td>
                            <td>{{ $operateur->localite }}</td>
                            <td>{{ $operateur->nature }}</td>
                            <td>{{ $operateur->cause }}</td>
                            <td>{{ $operateur->prenom }}</td>
                            <td>{{ $operateur->nom }}</td>
                            <td>{{ $operateur->tel }}</td>
                            <td>{{ $operateur->superficie }}</td>
                            <td>{{ $operateur->financement }}</td>
                            <td>{{ $operateur->op }}</td>
                            <td>{{ $operateur->cout }}</td>
                            <td>{{ $operateur->commentaire }}</td>
                            <td>
                                <a href="{{ route('operateur.edit', $operateur->id) }}" role="button" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                {!! Form::open(['method' => 'DELETE', 'route'=>['operateur.destroy', $operateur->id], 'style'=> 'display:inline', 'onclick'=>"if(!confirm('Êtes-vous sûr de vouloir supprimer cet enregistrement ?')) { return false; }"]) !!}
                                <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                {!! Form::close() !!}


                                {{-- <a href="{{ route('operateur.show', $operateur->id) }}" role="button" class="btn btn-warning"><i toolip="B" class="fas fa-file"></i></a> --}}

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
