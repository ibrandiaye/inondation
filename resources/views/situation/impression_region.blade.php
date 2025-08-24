<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Situation</title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .header, .sub-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .gray {
            background-color: red;
            color: white;
        }
        .page-break{
                page-break-after: always;
            }
    </style>
</head>

<body>
    <div class="container">
        <!-- Titre principal -->
        <div class="header">
            <h2  style="margin-bottom: 0px;margin-top: 0px;padding-bottom: 0px;">REPUBLIQUE DU SENEGAL </h2>
             <h6 style="margin-bottom: 0px;margin-top: 5px;padding-bottom: 0px;">   Un Peuple - un But - une Foi</h6>
            <h3 style="margin-bottom: 0px;margin-top: 5px;padding-bottom: 0px;">  {{$region->nom}}</h3>
            <h3 style="margin-bottom: 0px;margin-top: 5px;padding-bottom: 0px;"> Gouvernance </h3>
        </div>
        <hr>
        <div class="sub-header">
            <h4>MESSAGE DEPART</h4>
        </div>
        <div>
            <h4><b>EXPEDITEUR : </b>GOUVERNEUR  DE  {{$region->nom}} </h4>
            <h4><b>DESTINATAIRE  : </b>MINISTERE DE L'INTERIEUR </h4>
            <h4><b>NUMERO : ..................................</b></h4>
        </div>

         <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>

                               <th>Departement</th>
                                <th>Arrondissement</th>
                                <th>Commune</th>
                                <th>Localite</th>
                                <th>Type de Dégât</th>
                                <th>Mesure prise</th>
                                <th>Mesure envisagé</th>
                                <th>Coût des dégâts estimé en FCFA</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($tabStats as $key=> $tabStat)
                            <tr>

                               <td>{{ $tabStat->departement }}</td>
                                <td>{{ $tabStat->arrondissement }}</td>
                                <td>{{ $tabStat->commune }}</td>
                                <td>{{ $tabStat->localite->localite }}</td>
                                <td>{{ $tabStat->localite->nature }}</td>
                                <td>{{ $tabStat->localite->mesure }}</td>
                                <td>{{ $tabStat->localite->mesureen }}</td>
                                <td>{{ $tabStat->montant }}</td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

<br><br><br>
        <center>
            Le Gouverneur
        </center>
</body>
<script>
    window.print();
</script>
</html>
