@extends("backend.layout.app")

@section("title","Product")
@section("style-section")

<link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.29/dist/sweetalert2.css">
@endsection
@section("header-section")
<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Product
            <a href="{{route('backend.product.create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Add New</a>
        </h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Product</li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->

@if($message = Session::get('success'))

<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Success!</h5>
    {{ $message }}
</div>
@endif
@if($message = Session::get('danger'))

<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fas fa-check"></i> Error!</h5>
    {{ $message }}
</div>
@endif
@endsection


@section("content-section")

<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Product List</h3>
                <div class="float-right">

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="get">
                    <div class="row mb-2">
                        <div class="col-md-3 text-right"><label>Search Product</label></div>
                        <div class="col-md-6">
                            <input type="text" name="search_text" class="form-control" value="{{Request::get('search_text')}}">
                        </div>
                        <div class="col-md-3"><button type="submit" class="btn btn-info">Search</button> </div>
                    </div>
                </form>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Logo</th>
                            <th>Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $index=(((Request::get("page")?Request::get("page"):1)-1)*20)+1;
                        @endphp
                        @foreach($products as $product)
                        <tr>
                            <td>{{$index++}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->brand->name}}</td>
                            <td>{{$product->unit->name}}</td>
                            <td>
                                @if ($product->image)
                                <img src="{{asset($product->image)}}" width="80px">
                                @else
                                N/A
                                @endif

                            </td>
                            <td>
                                <b class="">
                                    @if($product->is_active==1)
                                    <span class="badge badge-success" style="font-size:100%">YES</span>
                                    @else
                                    <span class="badge badge-danger" style="font-size:100%">NO</span>
                                    @endif</b>
                            </td>
                            <td>
                                <a href="{{route('backend.product.edit',$product->id)}}" class="btn btn-icon btn-warning"><i class="fas fa-edit"></i></a>
                                <a href="" data-id="{{$product->id}}" data-url="{{route('backend.product.destroy',$product->id)}}" class="btn_delete btn btn-icon btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Unit</th>
                            <th>Logo</th>
                            <th>Active</th>
                            <th>Action</th>

                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-sm-center">
                {{$products->withQueryString()->links()}}
            </div>
        </div>
    </div>
    <!-- /.card -->
</div>
<!-- /.row (main row) -->
@endsection

@section("script-section")

<script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {
        $(".btn_delete").click(function(e) {
            e.preventDefault();

            var url = $(this).data("url");
            var id = $(this).data("id");
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((isConfirm) => {
                if (!isConfirm) return;
                var csrf = "csrf_token()";
                debugger;
                $.ajax({
                    url: url,
                    type: "DELETE",
                    data: {
                        "id": id,
                        "_token": '{{csrf_token()}}',
                    },
                    success: function(data) {
                        swal({
                            title: "Done!",
                            text: "It was succesfully deleted!",
                            icon: "success",
                            button: true,
                            dangerMode: false,
                        }).then((isConfirm) => {

                            location.reload();
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error deleting!", "Please try again", "error");
                    }
                });
            });
        })

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "bPaginate": false,
            "bInfo": false,
            "autoWidth": false,
            "searching": false,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }); //.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
    $(function() {

    });
</script>
@endsection