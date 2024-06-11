@extends('layouts.master')

@section('content')


<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-fluid px-4">
            <div class="page-header-content pt-4">
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-fluid px-4 mt-n10">
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
                    <h3 class="card-title">{{$item->machine_name}}</h3>
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
                    <form action="{{ url('/checksheet/store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">No. Document</label>
                                        <input type="text" class="form-control" id="no_document" name="no_document" placeholder="Enter No. Document" value="{{$item->no_document}}" readonly required>
                                    </div>
                                </div>
                                @if($item->type == 'Mechanic')
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department" value="Maintenance" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shop">Shop</label>
                                            <input type="text" class="form-control" id="shop" name="shop" placeholder="Enter Shop" value="Mechanic Stamping" readonly required>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department" value="Manufacturing Engineering Stamping" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shop">Shop</label>
                                            <input type="text" class="form-control" id="shop" name="shop" placeholder="Enter Shop" value="MTC Electric" readonly required>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="">Effective Date</label>
                                        <input type="date" class="form-control" id="effective_date" name="effective_date" placeholder="Enter Effective Date"  value="{{$item->effective_date}}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Revision</label>
                                        <input type="text" class="form-control" id="revision" name="revision" placeholder="Enter Revision" value="{{$item->revision}}" readonly required>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">OP No.</label>
                                        <input type="text" class="form-control" id="op_number" name="op_number" placeholder="Enter OP No." value="{{$item->op_name}}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">Mfg Date</label>
                                        <input value="{{$item->mfg_date}}" type="date" class="form-control" id="mfg_date" name="mfg_date" placeholder="Enter MFG Date" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">Planning Date</label>
                                        <input type="date" class="form-control" id="planning_date" name="planning_date" placeholder="Enter Planning Date" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">Machine Name</label>
                                        <input readonly value="{{$item->machine_name}}" type="text" class="form-control" id="machine_name" name="machine_name" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">Process</label>
                                        <input type="text" class="form-control" id="process" name="process" value="{{$item->process}}" readonly placeholder="Enter Process" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="form-group">
                                        <label for="">Actual Date</label>
                                        <input type="date" class="form-control" id="actual_date" name="actual_date" placeholder="Enter Actual Date" required>
                                    </div>
                                </div>
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



