@extends('layouts.master')

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                {{-- <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="tool"></i></div>
                            Dropdown App Menu
                        </h1>
                        <div class="page-header-subtitle">Use this blank page as a starting point for creating new pages inside your project!</div>
                    </div>
                    <div class="col-12 col-xl-auto mt-4">Optional page header content</div>
                </div> --}}
            </div>
        </div>
    </header>
<!-- Main page content-->
<div class="container-xl px-4 mt-n10">       
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>    </h1>
          </div>
        </div>
      </div><!-- /.container-fluid --> --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{$machine->machine_name}}</h3>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-sm-12">
                        <button type="button" class="btn btn-dark btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add">
                            <i class="fas fa-plus-square"></i> 
                          </button>
                          
                          <!-- Modal -->
                          <div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modal-add-label">Add Category Checksheet</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/master/checksheet/type/store') }}" method="POST">
                                  @csrf
                                  <div class="modal-body">
                                    <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>
                                    <div class="form-group mb-4">
                                      <input type="text" class="form-control" id="mechine" name="mechine" placeholder="Enter Category Checksheet" required>
                                    </div>
                                    <div class="form-group">
                                      <select name="type" id="type" class="form-control" required>
                                          <option value="">- Please Select Type -</option>
                                          @foreach ($dropdown as $type)
                                              <option value="{{ $type->name_value }}">{{ $type->name_value }}</option>
                                          @endforeach
                                        </select>
                                      </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                  </div>
                                </form>
                              </div>
                            </div>
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
                </div>
                <div class="col-sm-12">
                    <div class="table-responsive"> 
                      <table id="tableChecksheet" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Checkhseet Category</th>
                          <th>Checksheet Type</th>
                          <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                          @php
                            $no=1;
                          @endphp
                          @foreach ($checksheet as $data)
                          <tr>
                              <td>{{ $no++ }}</td>
                              <td>{{$data->checksheet_category}}</td>
                              <td>{{$data->checksheet_type}}</td>
                              
                              <td>
                                <button title="Edit Dropdown" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update{{ $data->checksheet_id }}">
                                  <i class="fas fa-edit"></i>
                                </button>
                                  <button title="Delete Dropdown" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete{{ $data->checksheet_id }}">
                                      <i class="fas fa-trash-alt"></i>
                                  </button>   
                              </td>
                          </tr>
                          
                          {{-- Modal Update --}}
                    <div class="modal fade" id="modal-update{{ $data->checksheet_id }}" tabindex="-1" aria-labelledby="modal-update{{ $data->checksheet_id }}-label" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h4 class="modal-title" id="modal-update{{ $data->checksheet_id }}-label">Edit Checksheet Type</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{ url('/master/checksheet/update/'.$data->checksheet_id) }}" method="POST">
                            @csrf
                            @method('patch')
                            <div class="modal-body">
                              <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>
                              <div class="form-group mb-4">
                                <input value="{{$data->checksheet_category}}" type="text" class="form-control" id="mechine" name="mechine" placeholder="Enter Category Checksheet" required>
                              </div>
                              <div class="form-group">
                                <select name="type" id="type" class="form-control" required>
                                    <option value="{{$data->checksheet_type}}">{{$data->checksheet_type}}</option>
                                    @foreach ($dropdown as $type)
                                        <option value="{{ $type->name_value }}">{{ $type->name_value }}</option>
                                    @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  {{-- Modal Update --}}

                          {{-- Modal Delete --}}
                          <div class="modal fade" id="modal-delete{{ $data->checksheet_id }}" tabindex="-1" aria-labelledby="modal-delete{{ $data->checksheet_id }}-label" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="modal-delete{{ $data->checksheet_id }}-label">Delete Category</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/master/delete/checksheet/'.$data->checksheet_id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>
                                    Are you sure you want to delete <label for="Dropdown">"{{ $data->checksheet_category }}"</label>?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        {{-- Modal Delete --}}

                          @endforeach
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
            <!-- /.card -->
          </div>
          <div class="card mt-4">
            <div class="card-header">
              <h3 class="card-title">Checksheet Item</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">

                  <button type="button" class="btn btn-dark btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modal-add-item">
                    <i class="fas fa-plus-square"></i> 
                  </button>
                  
                  <!-- Modal -->
                  <div class="modal fade" id="modal-add-item" tabindex="-1" aria-labelledby="modal-add-label" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="modal-add-label">Add Item Checksheet</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/master/checksheet/item/store') }}" method="POST">
                          @csrf
                          <div class="modal-body">
                            <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>

                            
                            <div class="form-group mb-4">
                              <select name="type" id="type" class="form-control" required>
                                  <option value="">- Please Select Type -</option>
                                  @foreach ($checksheet as $type)
                                      <option value="{{ $type->checksheet_id }}">{{ $type->checksheet_category }}</option>
                                  @endforeach
                                </select>
                              </div>

                            <!-- HTML -->
                            <div class="input-group mb-4" id="input-container">
                              <input type="text" class="form-control" name="mechine[]" placeholder="Enter Item Checksheet" required>
                              <button type="button" id="add-input" class="btn btn-dark">+</button>
                            </div>

                            <script>
                              // JavaScript/jQuery
                            $(document).ready(function() {
                                // Add input field when the "+" button is clicked
                                $('#add-input').click(function() {
                                    $('#input-container').append('<div class="input-group mt-2 mb-2"><input type="text" class="form-control" name="mechine[]" placeholder="Enter Item Checksheet" required><button type="button" class="btn btn-secondary remove-input">-</button></div>');
                                });

                                // Remove input field when the "-" button is clicked
                                $(document).on('click', '.remove-input', function() {
                                    $(this).closest('.input-group').remove();
                                });
                            });
                            </script>

                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>

                  <div class="table-responsive"> 
                    <table id="tableUser" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>No</th>
                        <th>Item Name</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @php
                          $no=1;
                        @endphp
                        @foreach ($checksheetItem as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$data->item_name}}</td>
                            
                            <td>
                              <button title="Edit Dropdown" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-update-item{{ $data->item_id }}">
                                <i class="fas fa-edit"></i>
                              </button>
                                <button title="Delete Dropdown" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modal-delete-item{{ $data->item_id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>   
                            </td>
                        </tr>
                      
                        {{-- Modal Update --}}
                  <div class="modal fade" id="modal-update-item{{ $data->item_id }}" tabindex="-1" aria-labelledby="modal-update-item{{ $data->item_id }}-label" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title" id="modal-update{{ $data->item_id }}-label">Edit Checksheet Item</h4>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('/master/checksheet/item/update/'.$data->item_id) }}" method="POST">
                          @csrf
                          @method('patch')
                          <div class="modal-body">
                            <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>
                            <div class="form-group mb-4">
                              <select name="type" id="type" class="form-control" required>
                                <?php $checksheet2 = \App\Models\Checksheet::find($data->checksheet_id); ?>
                                    @if($checksheet2)
                                        <option value="{{$data->checksheet_id}}">{{$checksheet2->checksheet_category}}</option>
                                    @endif
                                  @foreach ($checksheet as $type)
                                      <option value="{{ $type->checksheet_id }}">{{ $type->checksheet_category }}</option>
                                  @endforeach
                                </select>
                              </div>
                            <div class="form-group mb-4">
                              <input value="{{$data->item_name}}" type="text" class="form-control" id="mechine" name="mechine" placeholder="Enter Category Checksheet" required>
                            </div>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                {{-- Modal Update --}}
                          {{-- Modal Delete --}}
                          <div class="modal fade" id="modal-delete-item{{ $data->item_id }}" tabindex="-1" aria-labelledby="modal-delete-item{{ $data->item_id }}-label" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h4 class="modal-title" id="modal-delete-item{{ $data->item_id }}-label">Delete Item</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ url('/master/delete/checksheet/item/'.$data->item_id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <div class="modal-body">
                                    <div class="form-group">
                                      <input type="text" name="machine_id" id="" value="{{$machine->id}}" hidden>
                                    Are you sure you want to delete <label for="Dropdown">"{{ $data->item_name }}"</label>?
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                </form>
                            </div>
                            </div>
                        </div>
                        {{-- Modal Delete --}}
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            <div>
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
      $('#tableChecksheet, #tableUser').DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
      });
    });
  </script>
  
@endsection