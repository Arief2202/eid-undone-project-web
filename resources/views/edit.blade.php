<?php

?>
<!doctype html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Electrindo | Edit</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/dataTables.dataTables.min.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
</head>

<body class="h-100 w-100 p-0 m-0">

    <div class="mt-2 h-100 w-100 p-0 m-0 d-flex justify-content-center d-none d-md-block" style="width:95vw;">
        <div class="row h-100 p-0 m-0" style="width:100vw;">
            <div class="col d-flex align-items-center">
                <a href="/"><img src="/assets/Logo_EID.png" alt="" style="width:10vw;"></a>
            </div>
            <div class="col p-0 m-0 d-flex justify-content-center mt-2">
                <div class="p-0 m-0" style="font-size:3vw"><b>Edit Project</b></div>
            </div>
            <div class="col d-flex justify-content-end align-items-center mt-2">
                <div class="d-flex justify-content-center me-4">
                    <div class="p-2 ps-4 pe-4" id="Time" style="background: rgb(0, 107, 95); background: linear-gradient(144deg, rgba(0, 107, 95,1) 0%, rgb(99, 124, 0) 100%); border-radius:50px; font-size:2.0vw; font-weight:700; background-repeat: no-repeat; width:100%"></div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-body-tertiary d-block d-md-none">
        <div class="container-fluid">
          <a href="/"><img src="/assets/Logo_EID.png" alt="" style="width:10vw;"></a>
          <h3>EDIT SCHEDULE</h3>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" href="/">Home</a>
              @if($user_type == 'admin')<a class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal2">Add Project</a>@endif
              @if($user_type == 'admin')<a class="nav-link active" aria-current="page" href="/edit">Edit Project</a>@endif
              <a class="nav-link" href="/history">History Project</a>
              @if($user_type == 'admin' || $user_type == 'user')<a class="nav-link" href="/logout">Logout</a>@endif
            </div>
          </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center w-100" style="height:70vh;">

        <div class="mt-4 p-0 m-0" style="width:95vw;">
            <div class="w-100">
                <table class="table table-striped table-stripped-electrindo p-0 m-0 disabled nowrap" id="myTable" style="max-width:100vw;">
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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-none d-md-block" style="position:absolute; bottom:0px; width:100vw; padding:0px; margin:0px;">
        <div class="row p-0 m-0 mb-4">
            <div class="col-6">
                <div class="d-flex justify-content-start ms-4">
                    <a href="/" type="button" class="btn btn-primary button-bottom">< Back</a>
                    <button type="button" class="btn btn-primary button-bottom" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Project</button>
                    <a href="/history" type="button" class="btn btn-primary button-bottom">History</a>
                    <!-- <button type="button" class="btn btn-primary button-bottom">Add Project</button> -->
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-end">
                    <a href="/logout" type="button" class="btn btn-primary button-bottom">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action=""> @csrf
                    <input type="hidden" name="id" id="modal_id">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="form1" class="form-label">No SPK</label>
                            <input type="text" class="form-control" id="modal_no_spk" name="no_spk" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Nama Project</label>
                            <input type="text" class="form-control" id="modal_nama_project" name="nama_project" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="modal_keterangan" name="keterangan" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Customer</label>
                            <input type="text" class="form-control" id="modal_customer" name="customer" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">PIC</label>
                            <input type="text" class="form-control" id="modal_pic" name="pic" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="modal_due_date" name="due_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="form1" class="form-label">Status</label>
                            <select class="form-select" name="status" id="modal_status" required>
                                <option value="Planning">Planning</option>
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

    @if($user_type == 'admin')
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/"> @csrf
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
    @endif

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
            xhttp.open("GET", "/api/edit", true);
            xhttp.send();
        }
        loadDoc();
        setInterval(loadDoc, 1000);

        function updateModal(id){
            document.getElementById("modal_id").value = id;
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                const obj = JSON.parse(this.responseText);
                document.getElementById("modal_no_spk").value = obj.no_spk;
                document.getElementById("modal_nama_project").value = obj.nama_project;
                document.getElementById("modal_keterangan").value = obj.keterangan;
                document.getElementById("modal_customer").value = obj.customer;
                document.getElementById("modal_pic").value = obj.pic;
                document.getElementById("modal_due_date").value = obj.due_date;
                document.getElementById("modal_status").value = obj.status;
            }
            xhttp.open("GET", "/project/"+id, true);
            xhttp.send();
        }
    </script>
</body>

</html>
