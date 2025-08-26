{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Utilisateur')

@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">

            <h4 class="page-title">Rapport</h4>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">

    @php
        $user = Auth::user();
    @endphp
    <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
            @if ($user->role=="admin" || $user->role=="superviseur" )
                <form action="{{ route('message.national') }}" method="POST">
            @elseif($user->role=="gouverneur")
                <form action="{{ route('message.region') }}" method="POST">
            @elseif($user->role=="prefet")
                <form action="{{ route('message.departement') }}" method="POST">
            @elseif($user->role=="sous_prefet")
                <form action="{{ route('message.arrondissement') }}" method="POST">
            @endif
                @csrf
                    <div class="row">
                        @if ($user->role=="admin" || $user->role=='superviseur' || $user->role=="correcteur")
                        <div class="col-lg-3">
                            <label>Region</label>
                            <select class="form-control" name="region_id" id="region_id">
                                <option value="">Selectionnez</option>
                                @foreach ($regions as $region)
                                <option value="{{$region->id}}">{{$region->nom}}</option>
                                    @endforeach

                            </select>
                        </div>

                        @endif
                        @if ($user->role=="admin"  || $user->role=="gouverneur" || $user->role=='superviseur' || $user->role=="correcteur")
                        <div class="col-lg-3">
                            <label>Departement</label>
                            <select class="form-control" name="departement_id" id="departement_id" >
                                <option value="">Selectionner</option>
                                @foreach ($departements as $departement)
                                    <option value="{{$departement->id}}">{{$departement->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        @if ($user->role=="admin" || $user->role=="prefet" || $user->role=="gouverneur" || $user->role=='superviseur' || $user->role=="correcteur")
                        <div class="col-lg-3">
                            <label>Arrondissement</label>
                            <select class="form-control" name="arrondissement_id" id="arrondissement_id" >
                                <option value="">Selectionner</option>
                                @foreach ($arrondissements as $arrondissement)
                                    <option value="{{$arrondissement->id}}">{{$arrondissement->nom}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-lg-3">
                            <label>Commune</label>
                            <select class="form-control" name="commune_id" id="commune_id" >
                                <option value="">Selectionner</option>
                                @foreach ($communes as $commune)
                                    <option value="{{$commune->id}}">{{$commune->nom}}</option>
                                @endforeach
                            </select>


                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="field-3" class="control-label">Date Debut</label>
                                <input type="date" class="form-control" id="field-3" placeholder="Mot "  name="start" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="field-7" class="control-label">Date Fin</label>
                            <input type="date" name="end" class="form-control" id="field-3" required>
                        </div>
                    </div>
                    <button type="submint" class="btn btn-primary">Valider</button>

                </form>
        </div>
    </div>
</div>

@endsection
@section("js")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
      const ctx = document.getElementById('myChart');
      const ctxbar = document.getElementById('myChartbar');
      url_app = '{{ config('app.url') }}';
    url_api = '{{ config('app.api') }}';


    $("#region_id").change(function () {
    // alert("ibra");
    var region_id =  $("#region_id").children("option:selected").val();
        var departement = "<option value=''>Veuillez selectionner</option>";
        $("#commune_id").empty();
        $("#arrondissement_id").empty();
        $("#departement_id").empty();


        $.ajax({
            type:'GET',
            url:url_app+'/departement/by/region/'+region_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {

                $.each(data,function(index,row){
                    //alert(row.nomd);
                    departement +="<option value="+row.id+">"+row.nom+"</option>";

                });

                $("#departement_id").append(departement);
            }
        });


    });
    $("#departement_id").change(function () {
        $("#commune_id").empty();
        $("#arrondissement_id").empty();
        var departement_id =  $("#departement_id").children("option:selected").val();
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

        $("#commune_id").empty();

        var arrondissement_id =  $("#arrondissement_id").children("option:selected").val();

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





</script>
@endsection


