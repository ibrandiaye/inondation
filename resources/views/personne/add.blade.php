{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Département')

@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tableau de bord</a></li>
                    <li class="breadcrumb-item active"><a href="javascript: void(0);">Personne </a></li>
                </ol>
            </div>
            <h4 class="page-title">Enregistrer une Personne</h4>
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
        <form action="{{ route('personne.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="localite_id" value="{{ $localite }}">
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE D'ENREGISTREMENT D'UNE PERSONNE</div>
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
                                <div class="row" id="rtse">

                                </div>
                                <div class="row">
                                    {{-- <div class="col-lg-6">
                                        <label>Nom Commune</label>
                                        <select class="form-control" name="commune_id" id="commune_id" required="">
                                           <option value="">Selectionnez</option>
                                            @foreach ($communes as $commune)
                                            <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Localité</label>
                                            <input type="text" name="localite"  value="{{ old('localite') }}" class="form-control"  required>
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nature du bien impacté</label>
                                            <input type="text" name="nature"  value="{{ old('nature') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Cause du sinistre</label>
                                            <input type="text" name="cause"  value="{{ old('cause') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Prénom</label>
                                            <input type="text" name="prenom"  value="{{ old('prenom') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nom</label>
                                            <input type="text" name="nom"  value="{{ old('nom') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <label>Sexe</label>
                                        <select class="form-control" name="genre" id="genre" required="">
                                           <option value="">Selectionnez</option>
                                            <option value="homme"  {{ old('genre')=="homme" ? 'selected' :'' }}>Homme</option>
                                           <option value="femme" {{ old('genre')=="femme" ? 'selected' :'' }}>Femme</option>


                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Décès</label>
                                        <select class="form-control" name="deces" id="deces" required="">
                                           <option value="">Selectionnez</option>
                                           <option value="oui" {{ old('deces')=="oui" ? 'selected' :'' }}>Oui</option>
                                           <option value="non" {{ old('deces')=="non" ? 'selected' :'' }}>Non </option>

                                        </select>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Téléphone</label>
                                            <input type="text" name="tel"  value="{{ old('tel') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>N° CNI</label>
                                            <input type="text" name="cni"  value="{{ old('cni') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Besoin</label>
                                            <textarea class="form-control" name="besoin" required> {{ old('besoin') }} </textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>commentaire</label>
                                            <textarea class="form-control" name="commentaire" required> {{ old('commentaire') }} </textarea>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Piece Jointe</label>
                                            <input type="file" name="document"   class="form-control"  >
                                        </div>
                                    </div>


                                </div>


                                <div>
                                    <center>
                                        <button type="submit" id="enregistrer" class="btn btn-success btn btn-lg "> ENREGISTRER</button>
                                    </center>
                                </div>
                            </div>

                            </div>

            </form>

    </div>
</div>


@endsection


@section('js')
    <script>
        url_app = '{{ config('app.url') }}';


        $("#commune_id").change(function () {

            var commune_id =  $("#commune_id").children("option:selected").val();
            $("#rtse").empty();
            $.ajax({
                type:'GET',
                url:url_app+'/stat/by/commune/'+commune_id,
                //data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)

                    if(data.id)
                    {
                        $("#rtse").append("<div class='col-md-4'><h6>Periode de  : "+data.debut+" à "+data.fin+" </h6></div>"+
                        "<div class='col-md-2'><h6>Inscription : "+data.inscription+"</h6></div>"+
                        "<div class='col-md-2'><h6>Modification : "+data.modification+"</h6></div>"+
                        "<div class='col-md-2'><h6>Changement : "+data.changement+"</h6></div>"+
                        "<div class='col-md-2'><h6>Radiation : "+data.radiation+"</h6></div>");

                    }

                }
            });
        });


// Exemple d'utilisation


    $(document).ready(function() {
        $('#enregistrer').click(function() {
            $.blockUI(
               {
                message: "<h3>Enregistrement en cours ...<h3>",
                css: { color: 'green', borderColor: 'green' } ,
            }
            );

            setTimeout($.unblockUI, 2000);
        });
    });
</script>

@endsection

