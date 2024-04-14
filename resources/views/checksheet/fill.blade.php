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
                        <form action="{{ url('/checksheet/store/detail') }}" method="POST">
                            @csrf
                            <input type="text" name="id_header" value="{{$id}}" hidden>
                            <div class="modal-body">
                                <div class="table-responsive"> 
                                    {{-- Table for Preventive Maintenance --}}
                                    <h1>Preventive Maintenance</h1>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Spec</th>
                                                <th>Act</th>
                                                <th>B</th>
                                                <th>R</th>
                                                <th>G</th>
                                                <th>PP</th>
                                                <th>Judge</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; $firstCategoryDone = false; @endphp
                                            @foreach ($groupedResults as $checksheetId => $items)
                                                @php
                                                    $checksheetCategory = $items[0]['checksheet_category'];
                                                    $checksheetType = $items[0]['checksheet_type'];
                                                @endphp
                                                @if ($checksheetType == 'Preventive Maintanance')
                                                    @if (!$firstCategoryDone)
                                                        @php $firstCategoryDone = true; @endphp
                                                    @endif
                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <input type="hidden" name="items[{{ $item['item_name'] }}][checksheet_type]" value="{{ $checksheetType }}">
                                                            <td>{{ $item['item_name'] }}</td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][spec]"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][act]"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][B]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][R]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][G]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][PP]" value="1"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][judge]"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][remarks]"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    {{-- Table for Predictive Maintenance --}}
                                    <h1>Predictive Maintenance</h1>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Spec</th>
                                                <th>Act</th>
                                                <th>B</th>
                                                <th>R</th>
                                                <th>G</th>
                                                <th>PP</th>
                                                <th>Judge</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupedResults as $checksheetId => $items)
                                                @php $checksheetType = $items[0]['checksheet_type']; @endphp
                                                @if ($checksheetType == 'Predictive Maintanance')
                                                    @foreach ($items as $item)
                                                        <tr>
                                                            <input type="hidden" name="items[{{ $item['item_name'] }}][checksheet_type]" value="{{ $checksheetType }}">
                                                            <td>{{ $item['item_name'] }}</td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][spec]"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][act]"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][B]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][R]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][G]" value="1"></td>
                                                            <td><input type="checkbox" class="checkbox" name="items[{{ $item['item_name'] }}][PP]" value="1"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][judge]"></td>
                                                            <td><input type="text" name="items[{{ $item['item_name'] }}][remarks]"></td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
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
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    // Uncheck other checkboxes in the same row
                    const row = this.parentElement.parentElement;
                    const otherCheckboxes = row.querySelectorAll('.checkbox');
                    otherCheckboxes.forEach(otherCheckbox => {
                        if (otherCheckbox !== this) {
                            otherCheckbox.checked = false;
                        }
                    });
                }
            });
        });
    });
</script>
@endsection