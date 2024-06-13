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

                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">{{$itemHead->machine_name}}</h3>
                                    @if($itemHead->status == 1)
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approveModal">
                                            Submit
                                        </button>
                                    @endif
                                </div>
                                <!-- Approve Modal -->
                                <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="approveModalLabel">Approve or Remand Checksheet</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ url('/checksheet/checker/store') }}" method="POST">
                                                @csrf
                                                <input type="text" name="id" value="{{$itemHead->id}}" hidden>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Select Action:</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="approvalStatus" id="approveRadio" value="approve" checked>
                                                            <label class="form-check-label" for="approveRadio">Approve</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="approvalStatus" id="remandRadio" value="remand">
                                                            <label class="form-check-label" for="remandRadio">Remand</label>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="remark" class="form-label">Remark:</label>
                                                        <textarea class="form-control" id="remark" name="remark" rows="3" required>{{$itemHead->remark}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="oneClickButton">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                              <!-- /.card-header -->
                              <div class="card-body">
                                <div class="row">
                                    <div class="mb-3 col-sm-12">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">No. Document</label>
                                                        <input type="text" class="form-control" id="no_document" name="no_document" placeholder="Enter No. Document" value="{{$itemHead->no_document}}" readonly required>
                                                    </div>
                                                </div>
                                                @if($itemHead->type == 'Mechanic')
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

                                                <div class="col-md-4 mb-4">
                                                    <div class="form-group">
                                                        <label for="">Effective Date</label>
                                                        <input type="date" class="form-control" id="effective_date" name="effective_date" placeholder="Enter Effective Date"  value="{{$itemHead->effective_date}}" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="">Revision</label>
                                                        <input type="text" class="form-control" id="revision" name="revision" placeholder="Enter Revision" value="{{$itemHead->revision}}" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="">PIC</label>
                                                        <input type="text" class="form-control" id="effective_date" name="effective_date" placeholder="Enter Effective Date"  value="{{$itemHead->pic}}" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 mb-4">
                                                    <div class="form-group">
                                                        <label for="">Remarks</label>
                                                        <input type="text" class="form-control" id="effective_date" name="effective_date" placeholder="Enter Effective Date"  value="{{$itemHead->remark}}" readonly required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">OP No.</label>
                                                        <input type="text" class="form-control" id="op_number" name="op_number" placeholder="Enter OP No." value="{{$itemHead->op_name}}" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">Mfg Date</label>
                                                        <input readonly value="{{$itemHead->manufacturing_date}}" type="date" class="form-control" id="mfg_date" name="mfg_date" placeholder="Enter MFG Date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">Planning Date</label>
                                                        <input readonly value="{{$itemHead->planning_date}}" type="date" class="form-control" id="planning_date" name="planning_date" placeholder="Enter Planning Date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">Machine Name</label>
                                                        <input readonly value="{{$itemHead->machine_name}}" type="text" class="form-control" id="machine_name" name="machine_name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">Process</label>
                                                        <input type="text" class="form-control" id="process" name="process" value="{{$itemHead->process}}" readonly placeholder="Enter Process" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">Actual Date</label>
                                                        <input readonly value="{{$itemHead->actual_date}}" type="date" class="form-control" id="actual_date" name="actual_date" placeholder="Enter Actual Date" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>


                                </div>

                              </div>
                              <!-- /.card-body -->
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $itemHead->machine_name }}</h3>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">
                                            <div class="table-responsive">
                                                <ul class="nav nav-tabs" id="checksheetTabs" role="tablist">
                                                    <!-- Tab for each asset category -->
                                                    @foreach ($groupedResults as $checksheetCategory => $items)
                                                        <li class="nav-item">
                                                            <a style="color: black" class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ Str::slug($checksheetCategory) }}-tab"
                                                                data-bs-toggle="tab" href="#{{ Str::slug($checksheetCategory) }}-content"
                                                                role="tab" aria-controls="{{ Str::slug($checksheetCategory) }}-content"
                                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $checksheetCategory }}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                <div class="tab-content" id="checksheetTabsContent">
                                                    <!-- Tab panel for each asset category -->
                                                    @foreach ($groupedResults as $checksheetCategory => $items)
                                                    @php
                                                        $checksheetType = $items[0]['checksheet_type'];
                                                    @endphp
                                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ Str::slug($checksheetCategory) }}-content" role="tabpanel"
                                                            aria-labelledby="{{ Str::slug($checksheetCategory) }}-tab">
                                                            <br>
                                                            <h1>{{ $checksheetType }}</h1> <!-- Display the asset category -->
                                                            <table class="table table-bordered table-striped">
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
                                                                    @foreach ($items as $item)
                                                                        <tr>
                                                                            <td>{{ $item->item_name }}</td>
                                                                            <td>{{ $item->spec }}</td>
                                                                            <td>{{ $item->act }}</td>
                                                                            <td><input type="checkbox" {{ $item->B ? 'checked' : '' }} disabled></td>
                                                                            <td><input type="checkbox" {{ $item->R ? 'checked' : '' }} disabled></td>
                                                                            <td><input type="checkbox" {{ $item->G ? 'checked' : '' }} disabled></td>
                                                                            <td><input type="checkbox" {{ $item->PP ? 'checked' : '' }} disabled></td>
                                                                            <td>{{ $item->judge }}</td>
                                                                            <td>{{ $item->remarks }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
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
@endsection
