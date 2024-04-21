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
                                                    <div class="form-group mb-4">
                                                        <input type="text" class="form-control" id="mechine" name="mechine" placeholder="Enter Mechine Name" required>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <div id="qr-reader" style="width:500px"></div>
                                                        <div id="qr-reader-results"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
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
                    <form id="signatureForm{{ $data->id }}" action="{{ url('/checksheet/signature') }}" method="POST">
                        @csrf
                        <input type="hidden" name="checksheet_id" value="{{ $data->id }}">
                        <!-- Hidden input fields for signature data -->
                        @for ($i = 1; $i <= 4; $i++)
                            <input type="hidden" id="signature{{ $i }}{{ $data->id }}" name="signature{{ $i }}" value="{{ $data->{"signature$i"} ?? '' }}">
                        @endfor
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
                                                <div id="signature-pad-1{{ $data->id }}" class="signature-pad">
                                                    @if ($data->signature1)
                                                        <img style="width: 150px; height: 100px;" src="{{ $data->signature1 }}" alt="Signature">
                                                    @else
                                                        <canvas style="width: 150px; height: 100px;"></canvas>
                                                        <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Checked -->
                                    <td colspan="2">
                                        <div class="border p-3 mb-3">
                                            <h5 class="text-center mb-3">Checked</h5>
                                            <div class="row">
                                                @for ($j = 2; $j <= 3; $j++)
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label for="signature{{ $j }}" class="form-label">Checked by Person {{ $j }}:</label>
                                                            <div id="signature-pad-{{ $j }}{{ $data->id }}" class="signature-pad">
                                                                @if ($data->{"signature$j"})
                                                                    <img style="width: 150px; height: 100px;" src="{{ $data->{"signature$j"} }}" alt="Signature">
                                                                @else
                                                                    <canvas style="width: 150px; height: 100px;"></canvas>
                                                                    <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </td>
                                    <!-- Arranged -->
                                    <td>
                                        <div class="border p-3 mb-3">
                                            <h5 class="text-center mb-3">Arranged</h5>
                                            <div class="mb-3">
                                                <label for="signature4" class="form-label">Arranged by Person 4:</label>
                                                <div id="signature-pad-4{{ $data->id }}" class="signature-pad">
                                                    @if ($data->signature4)
                                                        <img style="width: 150px; height: 100px;" src="{{ $data->signature4 }}" alt="Signature">
                                                    @else
                                                        <canvas style="width: 150px; height: 100px;"></canvas>
                                                        <button type="button" class="btn btn-danger btn-sm clear-btn">Clear</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
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
    // Pastikan untuk menginisialisasi SignaturePad setelah dokumen HTML dimuat sepenuhnya

    @foreach ($item as $data)
    var signaturePads{{ $data->id }} = [];

    // Initialize Signature Pads for Persons
    for (var i = 1; i <= 4; i++) {
        var canvas{{ $data->id }} = document.querySelector(`#signature-pad-${i}{{ $data->id }} canvas`);
        var signaturePad{{ $data->id }};

        // Pastikan canvas ditemukan sebelum menginisialisasi SignaturePad
        if (canvas{{ $data->id }}) {
            signaturePad{{ $data->id }} = new SignaturePad(canvas{{ $data->id }});
            var clearButton{{ $data->id }} = document.querySelector(`#signature-pad-${i}{{ $data->id }} .clear-btn`);

            signaturePads{{ $data->id }}.push({
                pad: signaturePad{{ $data->id }},
                clearButton: clearButton{{ $data->id }}
            });

            clearButton{{ $data->id }}.addEventListener('click', function (index) {
                return function () {
                    signaturePads{{ $data->id }}[index].pad.clear();
                };
            }(i - 1));
        }
    }

    // Capture and store signatures when form is submitted
    var form{{ $data->id }} = document.querySelector('#signatureForm{{ $data->id }}');
    if (form{{ $data->id }}) {
        form{{ $data->id }}.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Convert signatures to JSON
            var signatureData{{ $data->id }} = {
                "signature1": signaturePads{{ $data->id }}[0].pad.isEmpty() ? null : signaturePads{{ $data->id }}[0].pad.toDataURL(),
                "signature2": signaturePads{{ $data->id }}[1].pad.isEmpty() ? null : signaturePads{{ $data->id }}[1].pad.toDataURL(),
                "signature3": signaturePads{{ $data->id }}[2].pad.isEmpty() ? null : signaturePads{{ $data->id }}[2].pad.toDataURL(),
                "signature4": signaturePads{{ $data->id }}[3].pad.isEmpty() ? null : signaturePads{{ $data->id }}[3].pad.toDataURL()
            };

            // Set the signature values to the hidden inputs
            document.querySelector('#signature1{{ $data->id }}').value = JSON.stringify(signatureData{{ $data->id }});

            // Submit the form
            form{{ $data->id }}.submit();
        });
    }
    @endforeach
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    function docReady(fn) {
        if (document.readyState === "complete" || document.readyState === "interactive") {
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var lastResult, countResults = 0;

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Set the scanned value to the input field
                document.getElementById('mechine').value = decodedText;
                // Automatically submit the form
                document.getElementById('submitBtn').click();
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
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
