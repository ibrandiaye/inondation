{{-- \resources\views\permissions\create.blade.php --}}
@extends('welcome')

@section('title', '| Enregister Utilisateur')

@section('content')
<div class="row">

    <div class="col-12">
        <div class="page-title-box">

            <h4 class="page-title">Tableau de bords</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card widget-box-one border border-success bg-soft-success">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-home font-30 widget-icon rounded-circle avatar-title text-success"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="User Today">Localite</p>
                    <h2><span data-plugin="counterup" id="localite">{{ $nbLocalite  }}</span> <i class="mdi mdi-arrow-up text-success font-24"></i></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-xl-4 col-md-6">
        <div class="card widget-box-one border border-warning bg-soft-warning">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-account-edit font-30 widget-icon rounded-circle avatar-title text-warning"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="User This Month">Opérateur</p>
                    <h2><span data-plugin="counterup" id="operateur">{{ $nbOperateur }} </span> <i class="mdi mdi-arrow-collapse text-success font-24"></i></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->
    <div class="col-xl-4 col-md-6">
        <div class="card widget-box-one border border-primary bg-soft-primary">
            <div class="card-body">
                <div class="float-right avatar-lg rounded-circle mt-3">
                    <i class="mdi mdi-account-switch font-30 widget-icon rounded-circle avatar-title text-primary"></i>
                </div>
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-weight-bold text-muted" title="Statistics">Personne</p>
                    <h2><span data-plugin="counterup" id="personne">{{  $nbPersonne}}</span> <i class="mdi mdi-account-switch text-success font-24"></i></h2>
                </div>
            </div>
        </div>
    </div>
    <!-- end col -->




    <!-- end col -->


</div>
<div class="row">
    <div class="col-12">

    @php
        $user = Auth::user();
    @endphp
    <div class="card">
        <div class="card-header">
            Carte ELectorale
        </div>
        <div class="card-body">
            <div class="row">
                @if ($user->role=="admin" || $user->role=='superviseur' || $user->role=="correcteur")
                <div class="col-lg-3">
                    <label>Region</label>
                    <select class="form-control" name="region_id" id="region_id" required="">
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
                    <select class="form-control" name="departement_id" id="departement_id" required="">
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
                    <select class="form-control" name="arrondissement_id" id="arrondissement_id" required="">
                        @foreach ($arrondissements as $arrondissement)
                            <option value="{{$arrondissement->id}}">{{$arrondissement->nom}}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="col-lg-3">
                    <label>Commune</label>
                    <select class="form-control" name="commune_id" id="commune_id" >
                        @foreach ($communes as $commune)
                            <option value="{{$commune->id}}">{{$commune->nom}}</option>
                        @endforeach
                    </select>


                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div>
    <div class="row">
        <div class="col-md-8">
            <canvas id="myChartbar"></canvas>
        </div>
        <div class="col-md-2">
            <canvas id="myChart"></canvas>
        </div>

    </div>
  </div>
  {{--  @if ($user->role=="admin")
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header  text-center">LISTE D'ENREGISTREMENT DES Comptages</div>
                    <div class="card-body">

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <th>Departement</th>
                                    <th>Localite</th>
                                    <th>Operateur</th>
                                    <th>Personne</th>
                                    <th>Radiation</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($depts as $key=> $comptage)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $comptage->nom }}</td>
                                    <td>{{ $comptage->localite }}</td>
                                    <td>{{ $comptage->operateur }}</td>
                                    <td>{{ $comptage->personne }}</td>
                                    <td>{{ $comptage->radiation }}</td>


                                </tr>
                                @endforeach

                            </tbody>
                        </table>



                    </div>
                </div>
            </div>
        </div>
    @endif --}}
@endsection
@section("js")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
      const ctx = document.getElementById('myChart');
      const ctxbar = document.getElementById('myChartbar');
      url_app = '{{ config('app.url') }}';
    url_api = '{{ config('app.api') }}';
    localite = 0;
    operateur = 0;
    personne = 0;
    let chart;
    let myChartbar;
    $(document).ready(function() {
        char(localite, operateur, personne, radiation);
    });
    $("#region_id").change(function () {
    // alert("ibra");
    var region_id =  $("#region_id").children("option:selected").val();
        var departement = "<option value=''>Veuillez selectionner</option>";
        $("#commune_id").empty();
        $("#arrondissement_id").empty();
        $("#departement_id").empty();

        $("#localite").empty();
        $("#operateur").empty();
        $("#personne").empty();
        localite = 0;
        operateur = 0;
        personne =  0;
        radiation = 0;
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

        $.ajax({
            type:'GET',
            url:url_app+'/api/by/region/'+region_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {

               console.log(data);
                $("#localite").append(data.localite);
                $("#operateur").append(data.operateur);
                $("#personne").append(data.personne);


                localite = data.localite;
                operateur = data.operateur;
                personne =  data.personne;

                radiation = data.radiation;
                chart.destroy();
                myChartbar.destroy();
                char(localite, operateur, personne, radiation);
                console.log(localite);

            }
        });
    });
    $("#departement_id").change(function () {
        $("#commune_id").empty();
        $("#arrondissement_id").empty();
        var departement_id =  $("#departement_id").children("option:selected").val();
        var commune = "<option value=''>Veuillez selectionner</option>";
        var arrondissement = "<option value=''>Veuillez selectionner</option>";
        $("#localite").empty();
        $("#operateur").empty();
        $("#personne").empty();

        localite = 0;
        operateur = 0;
        personne =  0;
        radiation = 0;
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
        $.ajax({
            type:'GET',
            url:url_app+'/api/by/departement/'+departement_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {

               console.log(data);
                $("#localite").append(data.localite);
                $("#operateur").append(data.operateur);
                $("#personne").append(data.personne);


                localite = data.localite;
                operateur = data.operateur;
                personne =  data.personne;

                radiation = data.radiation;
                chart.destroy();
                myChartbar.destroy();
                char(localite, operateur, personne, radiation);
            }
        });
    });

    $("#arrondissement_id").change(function () {

        $("#commune_id").empty();
        $("#localite").empty();
        $("#operateur").empty();
        $("#personne").empty();

        localite = 0;
        operateur = 0;
        personne =  0;
        radiation = 0;
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
        $.ajax({
            type:'GET',
            url:url_app+'/api/by/arrondissement/'+arrondissement_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {

               console.log(data);
                $("#localite").append(data.localite);
                $("#operateur").append(data.operateur);
                $("#personne").append(data.personne);


                localite = data.localite;
                operateur = data.operateur;
                personne =  data.personne;

                radiation = data.radiation;
                chart.destroy();
                myChartbar.destroy();
                char(localite, operateur, personne, radiation);


            }
        });
    });




    $("#commune_id").change(function () {

        var commune_id =  $("#commune_id").children("option:selected").val();
        var departement_id =  $("#departement_id").children("option:selected").val();
        $("#localite").empty();
        $("#operateur").empty();
        $("#personne").empty();

        localite = 0;
        operateur = 0;
        personne =  0;
        radiation = 0;
        $.ajax({
            type:'GET',
            url:url_app+'/api/by/commune/'+commune_id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data) {

               console.log(data);
                $("#localite").append(data.localite);
                $("#operateur").append(data.operateur);
                $("#personne").append(data.personne);


                localite = data.localite;
                operateur = data.operateur;
                personne =  data.personne;

                radiation = data.radiation;
                chart.destroy();
                myChartbar.destroy();
                char(localite, operateur, personne, radiation);


            }
        });
    });
  /*  function char(localite, operateur, personne, radiation)
    {


        myChartbar = new Chart(ctxbar, {
            type: 'bar',
            data: {
            labels: ['Localite', 'Operateur', 'Personne', 'Radiation'],
            datasets: [{
                label: 'nb personnes ',
                data: [localite, operateur, personne, radiation],
                borderWidth: 1,
                backgroundColor: [
                'rgb(161, 255, 165)',
                'rgb(255, 252, 161)',
                'rgb(103, 167, 253)',
                'rgb(253, 103, 103)',

                ],
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    }

  */
</script>
@endsection


