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
        <form action="{{ route('localite.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
             <div class="card ">
                        <div class="card-header text-center">FORMULAIRE D'ENREGISTREMENT D'UNE LOCALITE</div>
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
                                    <div class="col-lg-6">
                                        <label>Region</label>
                                        <select class="form-control" name="region_id" id="region_id" required="">
                                            <option value="">Selectionnez</option>
                                            @foreach ($regions as $region)
                                            <option value="{{$region->id}}">{{$region->nom}}</option>
                                                @endforeach

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Departement</label>
                                        <select class="form-control" name="departement_id" id="departement_id" required="">

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Arrondissement</label>
                                        <select class="form-control" name="arrondissement_id" id="arrondissement_id" required="">

                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label>Commune</label>
                                        <select class="form-control" name="commune_id" id="commune_id" >

                                        </select>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Localité</label>
                                            <input type="text" name="localite"  value="{{ old('localite') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nature du bien impacté</label>
                                            <select id="nature" name="nature" class="form-control">
                                                <option value="">-- Sélectionner --</option>
                                                <option value="route" {{ old('nature') == "route" ? 'selected' : '' }}>Route</option>
                                                <option value="pont" {{ old('nature') == "pont" ? 'selected' : '' }}>Pont</option>
                                                <option value="ecole" {{ old('nature') == "ecole" ? 'selected' : '' }}>École</option>
                                                <option value="aeroport" {{ old('nature') == "aeroport" ? 'selected' : '' }}>Aéroports</option>
                                                <option value="sante" {{ old('nature') == "sante" ? 'selected' : '' }}>Structures sanitaires</option>
                                                <option value="culte" {{ old('nature') == "culte" ? 'selected' : '' }}>Lieux de cultes</option>
                                                <option value="habitation" {{ old('nature') == "habitation" ? 'selected' : '' }}>Habitations</option>
                                                <option value="jeux" {{ old('nature') == "jeux" ? 'selected' : '' }}>Aires de jeux</option>
                                                <option value="transport" {{ old('nature') == "transport" ? 'selected' : '' }}>Transports</option>
                                                <option value="agriculteur" {{ old('nature') == "agriculteur" ? 'selected' : '' }}>Agriculteurs</option>
                                                <option value="elevage" {{ old('nature') == "elevage" ? 'selected' : '' }}>Élevages</option>
                                                <option value="commerce" {{ old('nature') == "commerce" ? 'selected' : '' }}>Commerces</option>
                                            </select>
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
                                            <label>Mesure prise</label>
                                            <input type="text" name="mesure"  value="{{ old('mesure') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                     <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Mesure envisagée</label>
                                            <input type="text" name="mesureen"  value="{{ old('mesureen') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Point d’attention</label>
                                            <input type="text" name="attention"  value="{{ old('attention') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Solution préconisée</label>
                                            <input type="text" name="solution"  value="{{ old('solution') }}" class="form-control"  required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Besoin </label>
                                            <input type="text" name="besoin"  value="{{ old('besoin') }}" class="form-control"  required>
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
                                            <label>commentaire</label>
                                            <textarea class="form-control" name="commentaire" required> {{ old('commentaire') }} </textarea>
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
                                        <button id="enregistrer" type="submit" class="btn btn-success btn btn-lg "> ENREGISTRER</button>
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

        $("#region_id").change(function () {
        // alert("ibra");
        var region_id =  $("#region_id").children("option:selected").val();
        $(".region").val(region_id);
        $(".departement").val("");
        $(".commune").val("");
            var departement = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/departement/by/region/'+region_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {

                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        departement +="<option value="+row.id+">"+row.nom+"</option>";

                    });

                    $("#departement_id").empty();
                    $("#departement_id").append(departement);
                }
            });
        });
        $("#departement_id").change(function () {
            $("#rts").empty();
            $("#centrevote_id").empty();
            $("#commune_id").empty();
            $("#arrondissement_id").empty();
            var departement_id =  $("#departement_id").children("option:selected").val();
            $(".departement").val(departement_id);
            $(".commune").val("");
            var commune = "<option value=''>Veuillez selectionner</option>";
            var arrondissement = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/commune/by/departement/'+departement_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        commune +="<option value="+row.id+">"+row.nom+"</option>";

                    });




                    $("#commune_id").append(commune);
                }
            });
            $.ajax({
                type:'GET',
                url:url_app+'/arrondissement/by/departement/'+departement_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        arrondissement +="<option value="+row.id+">"+row.nom+"</option>";

                    });




                    $("#arrondissement_id").append(arrondissement);
                }
            });
        });

        $("#arrondissement_id").change(function () {
            $("#rts").empty();
            $("#centrevote_id").empty();
            $("#commune_id").empty();

            var arrondissement_id =  $("#arrondissement_id").children("option:selected").val();
            $(".departement").val(departement_id);
            $(".commune").val("");
            var commune = "<option value=''>Veuillez selectionner</option>";
            $.ajax({
                type:'GET',
                url:url_app+'/commune/by/arrondissement/'+arrondissement_id,
                data:'_token = <?php echo csrf_token() ?>',
                success:function(data) {
                    console.log(data)
                    $.each(data,function(index,row){
                        //alert(row.nomd);
                        commune +="<option value="+row.id+">"+row.nom+"</option>";

                    });




                    $("#commune_id").append(commune);
                }
            });

        });



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



