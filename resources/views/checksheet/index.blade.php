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
                                    <!-- Alert success -->
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

                                    <!-- Validasi form -->
                                    @if (count($errors) > 0)
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
                                    <!-- End validasi form -->
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
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <div class="card mt-4">
                                <div class="card-header">
                                    <h3 class="card-title">List Checksheet</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">
                                            <div class="table-responsive"> 
                                                <table id="tableUser" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Machine Name (OP No.)</th>
                                                            <th>Department (Shop)</th>
                                                            <th>Created By</th>
                                                            <th>Mfg.Date</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                        $no = 1;
                                                        @endphp
                                                        @foreach ($item as $data)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{$data->machine_name}} ({{$data->op_number}})</td>
                                                            <td>{{$data->department}} ({{$data->shop}})</td>
                                                            <td>{{$data->created_by}}</td>
                                                            <td>{{$data->manufacturing_date}}</td>
                                                            <td>{{$data->status}}</td>
                                                            <td>
                                                                <a href="checksheet/detail/{{ encrypt($data->id) }}" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-info"></i></a>
                                                                <button title="Signature Approval" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal-signature{{ $data->id }}">
                                                                    <i class="fas fa-file-signature"></i>
                                                                </button>
                                                                <button title="Delete Dropdown" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->id }}">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>   
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            @foreach ($item as $data)
                            <!-- Modal -->
                            <div class="modal fade" id="modal-signature{{ $data->id }}" tabindex="-1" aria-labelledby="modal-signature-label" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="modal-signature-label">{{$data->machine_name}} ({{$data->op_number}})</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                              <form action="{{ url('/checksheet/signature') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="checksheet_id" value="{{ $data->id }}">
                                  <table class="table table-bordered">
                                      <thead>
                                          <tr>
                                              <th>Approval</th>
                                              <th colspan="2">Checked</th>
                                              <th>Arranged</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <!-- Approval -->
                                              <td>
                                                  <div class="border p-3 mb-3">
                                                      <h5 class="text-center mb-3">Approval</h5>
                                                      <div class="mb-3">
                                                          <label for="signature1" class="form-label">Approved by Person 1:</label>
                                                          <div id="signature-pad-1" class="signature-pad">
                                                              <canvas style="width: 150px; height: 100px;"></canvas>
                                                              <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                          </div>
                                                          <input type="hidden" id="signature1" name="signature1" class="form-control">
                                                      </div>
                                                  </div>
                                              </td>
                                              <!-- Checked -->
                                              <td colspan="2">
                                                  <div class="border p-3 mb-3">
                                                      <h5 class="text-center mb-3">Checked</h5>
                                                      <div class="row">
                                                          <!-- First signature pad for Person 2 -->
                                                          <div class="col-md-6">
                                                              <div class="mb-3">
                                                                  <label for="signature2" class="form-label">Checked by Person 2:</label>
                                                                  <div id="signature-pad-2" class="signature-pad">
                                                                      <canvas style="width: 150px; height: 100px;"></canvas>
                                                                      <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                                  </div>
                                                                  <input type="hidden" id="signature2" name="signature2" class="form-control">
                                                              </div>
                                                          </div>
                                                          <!-- Second signature pad for Person 3 -->
                                                          <div class="col-md-6">
                                                              <div class="mb-3">
                                                                  <label for="signature3" class="form-label">Checked by Person 3:</label>
                                                                  <div id="signature-pad-3" class="signature-pad">
                                                                      <canvas style="width: 150px; height: 100px;"></canvas>
                                                                      <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                                  </div>
                                                                  <input type="hidden" id="signature3" name="signature3" class="form-control">
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </td>
                                              <!-- Arranged -->
                                              <td>
                                                  <div class="border p-3 mb-3">
                                                      <h5 class="text-center mb-3">Arranged</h5>
                                                      <div class="mb-3">
                                                          <label for="signature4" class="form-label">Arranged by Person 4:</label>
                                                          <div id="signature-pad-4" class="signature-pad">
                                                              <canvas style="width: 150px; height: 100px;"></canvas>
                                                              <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                          </div>
                                                          <input type="hidden" id="signature4" name="signature4" class="form-control">
                                                      </div>
                                                  </div>
                                              </td>
                                          </tr>
                                      </tbody>
                                  </table>
                                  <button type="submit" class="btn btn-primary">Submit</button>
                              </form>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                        @endforeach


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

<!-- Include Signature Pad library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Signature Pad for Person 1
        var canvas1 = document.querySelector('#signature-pad-1 canvas');
        var signaturePad1 = new SignaturePad(canvas1);
        var clearButton1 = document.querySelector('#signature-pad-1 .clear-btn');
        clearButton1.addEventListener('click', function () {
            signaturePad1.clear();
        });

        // Initialize Signature Pad for Person 2
        var canvas2 = document.querySelector('#signature-pad-2 canvas');
        var signaturePad2 = new SignaturePad(canvas2);
        var clearButton2 = document.querySelector('#signature-pad-2 .clear-btn');
        clearButton2.addEventListener('click', function () {
            signaturePad2.clear();
        });

        // Initialize Signature Pad for Person 3
        var canvas3 = document.querySelector('#signature-pad-3 canvas');
        var signaturePad3 = new SignaturePad(canvas3);
        var clearButton3 = document.querySelector('#signature-pad-3 .clear-btn');
        clearButton3.addEventListener('click', function () {
            signaturePad3.clear();
        });

        // Initialize Signature Pad for Person 4
        var canvas4 = document.querySelector('#signature-pad-4 canvas');
        var signaturePad4 = new SignaturePad(canvas4);
        var clearButton4 = document.querySelector('#signature-pad-4 .clear-btn');
        clearButton4.addEventListener('click', function () {
            signaturePad4.clear();
        });

       // Capture and store signatures when form is submitted
    var form = document.querySelector('#signatureForm');
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent the form from submitting normally
        
        // Convert signatures to Base64
        var signature1 = signaturePad1.isEmpty() ? null : signaturePad1.toDataURL();
        var signature2 = signaturePad2.isEmpty() ? null : signaturePad2.toDataURL();
        var signature3 = signaturePad3.isEmpty() ? null : signaturePad3.toDataURL();
        var signature4 = signaturePad4.isEmpty() ? null : signaturePad4.toDataURL();
        
        // Set the signature values to the hidden inputs
        document.querySelector('#signature1').value = signature1;
        document.querySelector('#signature2').value = signature2;
        document.querySelector('#signature3').value = signature3;
        document.querySelector('#signature4').value = signature4;

        // Submit the form
        form.submit();
        });
    });
</script>



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
