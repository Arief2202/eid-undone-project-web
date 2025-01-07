<?php

?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electrindo | Home</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body class="h-100 w-100 p-0 m-0">

    <div class="mt-2 h-100 w-100 p-0 m-0 d-flex justify-content-center" style="width:95vw;">
        <div class="row h-100 p-0 m-0" style="width:95vw;">
            <div class="col-4 d-flex align-items-center">
                <img src="/assets/Logo_EID.png" alt="" style="width:10vw;">
            </div>
            <div class="col-4 p-0 m-0 d-flex justify-content-center mt-2">
                <div class="p-0 m-0" style="font-size:3vw"><b>UNDONE SCHEDULE</b></div>
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center mt-2">
                <div class="ps-5 pe-5 p-2" id="Time"
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
                            <th scope="col">Sisa Hari</th>
                            <th scope="col">No SPK</th>
                            <th scope="col">Nama Project</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Customer</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datas as $i=>$data){
                            echo "<tr class=\"";

                            $date1 = new DateTime();
                            $date2 = new DateTime($data->due_date);
                            $interval = $date1->diff($date2);
                            $selisih = (int) $interval->format('%R%a');

                            if($selisih < 0) echo "level3";
                            else if($selisih < 14) echo "level2";

                            echo "\">";?>

                            <?php
                                echo "<td>".$selisih."</td>";
                            ?>
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
            <button type="button" class="btn btn-primary button-bottom" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Project</button>
            <a href="/edit" type="button" class="btn btn-primary button-bottom">Edit Project</a>
            <a href="/history" type="button" class="btn btn-primary button-bottom">History</a>
            <!-- <button type="button" class="btn btn-primary button-bottom">Add Project</button> -->
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action=""> @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="form1" class="form-label">No SPK</label>
                            <input type="text" class="form-control" id="form1" name="no_spk" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Nama Project</label>
                            <input type="text" class="form-control" id="form1" name="nama_project" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="form1" name="keterangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="form1" name="customer" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">PIC</label>
                            <input type="text" class="form-control" id="form1" name="pic" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="form1" name="due_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="Planning" Selected>Planning</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Finish">Finish</option>
                                <option value="Cancel">Cancel</option>
                              </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/dataTables.min.js"></script>
    <script src="/js/script.js"></script>
    <script type="text/javascript">
        $('#myTable').DataTable({
            columnDefs: [
                { width: 120, targets: 0 },
                { width: 120, targets: 1},
                { width: 150, targets: 6 },
                { width: 110, targets: 7 },
            ],
        });
    </script>
</body>

</html>
