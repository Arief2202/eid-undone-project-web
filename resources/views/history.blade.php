<?php

?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electrindo | History</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body class="h-100 w-100 p-0 m-0">

    <div class="mt-2 h-100 w-100 p-0 m-0 d-flex justify-content-center" style="width:95vw;">
        <div class="row h-100 p-0 m-0" style="width:95vw;">
            <div class="col d-flex align-items-center">
                <a href="/"><img src="/assets/Logo_EID.png" alt="" style="width:10vw;"></a>
            </div>
            <div class="col p-0 m-0 d-flex justify-content-center mt-2">
                <div class="p-0 m-0" style="font-size:3vw"><b>HISTORY</b></div>
            </div>
            <div class="col-md d-flex justify-content-end align-items-center mt-2">
                <div class="ps-5 pe-5 p-2 d-none d-xl-block" id="Time"
                    style="background: rgb(0, 107, 95); background: linear-gradient(144deg, rgba(0, 107, 95,1) 0%, rgb(99, 124, 0) 100%); border-radius:50px; font-size:2.0vw; font-weight:700; background-repeat: no-repeat;">
                    2024-12-27 15:45:12</div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center w-100" style="height:70vh;">

        <div class="mt-4 p-0 m-0" style="width:95vw;">
            <div class="w-100">
                <table class="table table-striped table-stripped-electrindo p-0 m-0" id="myTable" class="display">
                    <thead class="">
                        <tr class="table-electrindo" style="background-color:#24ab24;">
                            <th scope="col">No SPK</th>
                            <th scope="col">Nama Project</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Customer</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php foreach($datas as $i=>$data){?>
                        <tr class="history">
                            <td>{{ $data->no_spk }}</td>
                            <td>{{ $data->nama_project }}</td>
                            <td>{{ $data->keterangan }}</td>
                            <td>{{ $data->customer }}</td>
                            <td>{{ $data->pic }}</td>
                            <td>{{ date('d M Y', strtotime($data->due_date)) }}</td>
                            <td>
                                {{ $data->status}}
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="position:absolute; bottom:0px; width:100vw; background-color:" class="d-flex justify-content-center">
        <div style="width:95vw;" class="d-flex justify-content-start mb-4">
            <a href="/" type="button" class="btn btn-primary button-bottom">< Back</a>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/dataTables.min.js"></script>
    <script src="/js/script.js"></script>
    <script type="text/javascript">
        var lastLength = 0;
        $('#myTable').DataTable({

        });
        function loadDoc() {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                if(lastLength != this.responseText.length){
                    $('#myTable').DataTable().destroy();
                    document.getElementById("tbody").innerHTML=this.responseText;
                    $('#myTable').DataTable().draw();
                }
                lastLength = this.responseText.length;
            }
            xhttp.open("GET", "/api/history", true);
            xhttp.send();
        }
        loadDoc();
        setInterval(loadDoc, 1000);
    </script>
</body>

</html>
