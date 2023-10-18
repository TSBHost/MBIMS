@extends("backend.layout.app")

@section("title","Supplier")
@section("style-section")

<!-- summernote -->
<link rel="stylesheet" href="{{asset('backend/plugins/summernote/summernote-bs4.min.css')}}">

<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection
@section("header-section")

<div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Supplier Add</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Supplier</a></li>
            <li class="breadcrumb-item active">Add New </li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row -->
@endsection


@section("content-section")
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <form action="{{route('backend.supplier.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card  card-primary">
                <div class="card-header">
                    <h3 class="card-title">Supplier Add New</h3>
                    <div class="float-sm-right">

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">

                            @if($errors->any())

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Error!</h5>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md 12">
                            <div class="form-group">
                                <label for="name">Supplier Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Supplier Name" required value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label for="contact_person">Contct Person</label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Enter Contact Person Name" required value="{{old('contact_person')}}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" class="form-control" name="address">{{old('address')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Mobile No" required value="{{old('phone')}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control" name="description">{{old('description')}}</textarea>
                            </div>


                            <div class="form-group">
                                <input type="checkbox" id="is_active" name="is_active" @if(old("is_active",1)==1)checked @endif data-bootstrap-switch data-off-color="danger" data-on-color="success" data-on-text="Yes" data-off-text="No" value="1">
                                <label for="is_active">Is Active</label>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div>
<!-- /.row (main row) -->
@endsection

@section("script-section")

<!-- Summernote -->
<script src="{{asset('backend/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- Bootstrap Switch -->
<script src="{{asset('backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
<script src="{{asset('backend/plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function() {

        //$('#descr').summernote();
        $('.select2').select2();

        $('#description').summernote();

        $("input[data-bootstrap-switch]").each(function() {
            // $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $(this).bootstrapSwitch();
        })
    });
</script>
@endsection