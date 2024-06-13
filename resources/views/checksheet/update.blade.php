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
                        <form action="{{ url('/checksheet/update/detail') }}" method="POST">
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">{{$itemHead->machine_name}}</h3>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Submit
                                    </button>
                                </div>
                                 <!-- Modal structure -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Input Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="pic" class="form-label">PIC</label>
                            <input type="text" value="{{$itemHead->pic}}" class="form-control" id="pic" name="pic">
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks">{{$itemHead->remark}}</textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="oneClickButton">Save changes</button>
                </div>
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
                                                        <input type="text" class="form-control" id="no_document" name="no_document" placeholder="Enter No. Document" value="{{$itemHead->document_number}}" readonly required>
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

                                                <div class="col-md-6 mb-4">
                                                    <div class="form-group">
                                                        <label for="">Effective Date</label>
                                                        <input type="date" class="form-control" id="effective_date" name="effective_date" placeholder="Enter Effective Date"  value="{{$itemHead->effective_date}}" readonly required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Revision</label>
                                                        <input type="text" class="form-control" id="revision" name="revision" placeholder="Enter Revision" value="{{$itemHead->revision}}" readonly required>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="col-md-4 mb-2">
                                                    <div class="form-group">
                                                        <label for="">OP No.</label>
                                                        <input type="text" class="form-control" id="op_number" name="op_number" placeholder="Enter OP No." value="{{$itemHead->op_number}}" readonly required>
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
                                                        <input  value="{{$itemHead->planning_date}}" type="date" class="form-control" id="planning_date" name="planning_date" placeholder="Enter Planning Date" required>
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
                                                        <input  value="{{$itemHead->actual_date}}" type="date" class="form-control" id="actual_date" name="actual_date" placeholder="Enter Actual Date" required>
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
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">{{$itemHead->machine_name}}</h3>

                                </div>
                                <input type="text" name="id" value="{{$id}}" hidden>
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
                                                                    <td><input type="text" name="items[{{ $item->item_name }}][act]" value="{{ $item->act }}"></td>
                                                                    <td><input type="checkbox" class="checkbox" name="items[{{ $item->item_name }}][B]" value="1" {{ $item->B ? 'checked' : '' }}></td>
                                                                    <td><input type="checkbox" class="checkbox" name="items[{{ $item->item_name }}][R]" value="1" {{ $item->R ? 'checked' : '' }}></td>
                                                                    <td><input type="checkbox" class="checkbox" name="items[{{ $item->item_name }}][G]" value="1" {{ $item->G ? 'checked' : '' }}></td>
                                                                    <td><input type="checkbox" class="checkbox" name="items[{{ $item->item_name }}][PP]" value="1" {{ $item->PP ? 'checked' : '' }}></td>
                                                                    <td><input type="text" name="items[{{ $item->item_name }}][judge]" value="{{ $item->judge }}"></td>
                                                                    <td><input type="text" name="items[{{ $item->item_name }}][remarks]" value="{{ $item->remarks }}"></td>
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
                </form>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
</main>
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
