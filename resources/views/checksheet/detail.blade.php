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
                                    <h3 class="card-title">{{$itemHead->machine_name}}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-sm-12">
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
                                                        @foreach ($itemDetail as $detail)
                                                        @if ($detail->checksheet_type == 'Preventive Maintanance')
                                                        <tr>
                                                            <td>{{ $detail->item_name }}</td>
                                                            <td>{{ $detail->spec }}</td>
                                                            <td>{{ $detail->act }}</td>
                                                            <td><input type="checkbox" {{ $detail->B == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->R == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->G == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->PP == 1 ? 'checked' : '' }} disabled></td>                                                            
                                                            <td>{{ $detail->judge }}</td>
                                                            <td>{{ $detail->remarks }}</td>
                                                        </tr>
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
                                                        @foreach ($itemDetail as $detail)
                                                        @if ($detail->checksheet_type == 'Predictive Maintanance')
                                                        <tr>
                                                            <td>{{ $detail->item_name }}</td>
                                                            <td>{{ $detail->spec }}</td>
                                                            <td>{{ $detail->act }}</td>
                                                            <td>{{ $detail->act }}</td>
                                                            <td><input type="checkbox" {{ $detail->B == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->R == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->G == 1 ? 'checked' : '' }} disabled></td>
                                                            <td><input type="checkbox" {{ $detail->PP == 1 ? 'checked' : '' }} disabled></td>                                                            
                                                            <td>{{ $detail->judge }}</td>
                                                            <td>{{ $detail->remarks }}</td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
