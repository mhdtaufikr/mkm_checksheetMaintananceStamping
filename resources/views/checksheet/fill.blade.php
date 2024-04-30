@extends('layouts.master')

@section('content')
<main>
    <!-- Page header -->
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
            </div>
        </div>
    </header>

    <!-- Main page content -->
    <div class="container-fluid px-4 mt-n10">
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{ url('/checksheet/store/detail') }}" method="POST">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Scan QR Machine</h3>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-sm-12">
                                    <!-- Alert messages -->
                                    @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session('status') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if (session('failed'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>{{ session('failed') }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif

                                    @if (count($errors)>0)
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                        <ul>
                                            <li><strong>Data Process Failed !</strong></li>
                                            @foreach ($errors->all() as $error)
                                            <li><strong>{{ $error }}</strong></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <!-- End of alert messages -->
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">

                                                @csrf
                                                <input type="text" name="id_header" value="{{$id}}" hidden>
                                                <div class="modal-body">
                                                    <ul class="nav nav-tabs" id="checksheetTabs" role="tablist">
                                                        <!-- Tab for each checksheet category -->
                                                        @php $firstCategory = true; @endphp
                                                        @foreach ($groupedResults as $checksheetId => $items)
                                                        @php
                                                        $checksheetCategory = $items[0]['checksheet_category'];
                                                        $tabId = str_replace(' ', '_', $checksheetCategory);
                                                        @endphp
                                                        <li class="nav-item">
                                                            <a style="color: black;" class="nav-link{{ $firstCategory ? ' active' : '' }}"
                                                                id="{{ $tabId }}-tab" data-bs-toggle="tab"
                                                                href="#{{ $tabId }}" role="tab"
                                                                aria-controls="{{ $tabId }}"
                                                                aria-selected="{{ $firstCategory ? 'true' : 'false' }}">
                                                                {{ $checksheetCategory }}</a>
                                                        </li>
                                                        @php $firstCategory = false; @endphp
                                                        @endforeach
                                                    </ul>
                                                    <div class="tab-content" id="checksheetTabsContent">
                                                        <!-- Tab panel for each checksheet category -->
                                                        @php $firstCategory = true; @endphp
                                                        @foreach ($groupedResults as $checksheetId => $items)
                                                        @php
                                                        $checksheetCategory = $items[0]['checksheet_category'];
                                                        $tabId = str_replace(' ', '_', $checksheetCategory);
                                                        $checksheetType = $items[0]['checksheet_type'];
                                                        @endphp
                                                        <div class="tab-pane fade{{ $firstCategory ? ' show active' : '' }}" id="{{ $tabId }}" role="tabpanel"
                                                            aria-labelledby="{{ $tabId }}-tab">
                                                            <br>

                                                            <h1>{{ $checksheetType }}</h1> <!-- Display the category type -->
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

                                                                        <input type="hidden"
                                                                            name="items[{{ $item['item_name'] }}][checksheet_type]"
                                                                            value="{{ $item['checksheet_type'] }}">
                                                                            <input type="hidden"
                                                                            name="items[{{ $item['item_name'] }}][checksheet_category]"
                                                                            value="{{ $item['checksheet_category'] }}">
                                                                        <td>{{ $item['item_name'] }}</td>
                                                                        <td>{{ $item['spec'] }}</td>
                                                                        <td><input type="text"
                                                                                name="items[{{ $item['item_name'] }}][act]">
                                                                        </td>
                                                                        <td><input type="checkbox" class="checkbox"
                                                                                name="items[{{ $item['item_name'] }}][B]"
                                                                                value="1"></td>
                                                                        <td><input type="checkbox" class="checkbox"
                                                                                name="items[{{ $item['item_name'] }}][R]"
                                                                                value="1"></td>
                                                                        <td><input type="checkbox" class="checkbox"
                                                                                name="items[{{ $item['item_name'] }}][G]"
                                                                                value="1"></td>
                                                                        <td><input type="checkbox" class="checkbox"
                                                                                name="items[{{ $item['item_name'] }}][PP]"
                                                                                value="1"></td>
                                                                        <td><input type="text"
                                                                                name="items[{{ $item['item_name'] }}][judge]">
                                                                        </td>
                                                                        <td><input type="text"
                                                                                name="items[{{ $item['item_name'] }}][remarks]">
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        @php $firstCategory = false; @endphp
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
<!-- For Datatables -->
<script>
    $(document).ready(function () {
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
