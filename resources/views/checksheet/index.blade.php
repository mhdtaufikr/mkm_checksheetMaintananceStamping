@extends('layouts.master')

@section('content')


<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">       
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Scan QR Machine</h3>
              </div>
              <div class="col-sm-12">
                <!--alert success -->
                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>{{ session('status') }}</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
              @endif

              @if (session('failed'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>{{ session('failed') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div> 
            @endif
              
                <!--alert success -->
                <!--validasi form-->
                  @if (count($errors)>0)
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <ul>
                            <li><strong>Data Process Failed !</strong></li>
                            @foreach ($errors->all() as $error)
                                <li><strong>{{ $error }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
                <!--end validasi form-->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                    <form action="{{ url('/checksheet/scan') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="text" class="form-control" id="mechine" name="mechine" placeholder="Enter Mechine Name" required>
                       
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer">
                          
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </form>
                    
                </div>
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
</main>
<!-- For Datatables -->
<script>
    $(document).ready(function() {
      var table = $("#tableUser").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      });
    });
  </script>
@endsection