@extends("backend.layout.app")

@section("title","Sale")
@section("style-section")

<!-- summernote -->
<link rel="stylesheet" href="{{asset('backend/plugins/summernote/summernote-bs4.min.css')}}"> <!-- iCheck for checkboxes
    and radio inputs --> <link rel="stylesheet"
    href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}"> <link rel="stylesheet"
    href="{{asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.29/dist/sweetalert2.css"> @endsection
@section("header-section") <div class="row mb-2">
<div class="col-sm-6"> <h1 class="m-0">Sale Add</h1> </div><!-- /.col -->
<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Sale</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    </div><!-- /.col --> </div><!-- /.row --> 
    @endsection 
    @section("content-section") <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12"> <form action="{{route('backend.sale.update',$sale->id)}}" method="POST"
            enctype="multipart/form-data"> 
            @csrf 
            @method("PUT")
            <div class="card card-primary"> <div class="card-header"> <h3
            class="card-title">Sale Edit</h3>
            <div class="float-sm-right">

        </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

            <div class="row">
            <div class="col-md-12">

                @if($errors->any())

                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">&times;</button>
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
            <div class="col-md-6">

                <div class="form-group">
                <label for="sale_date">Sale Date</label>
                <input type="text" class="form-control datepicker" id="sale_date"
                name="sale_date" placeholder="Enter Sale Date" required
                value="{{old('sale_date',$sale->sale_date)}}">
            </div>
            </div>
            <div class="col-md-6">

            <div class="form-group">
            <label for="customer_id">Customer</label>
            <select class="form-control select2" id="customer_id" name="customer_id" required>
                <option value="">Select a customer</option>
                @foreach ($customers as $customer)
                <option value="{{$customer->id}}" @if(old('customer_id',$sale->customer_id)==$customer->id)
                    selected
                    @endif>{{$customer->name}}</option>
                    @endforeach
            </select>
            </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-6">

        <div class="form-group">
        <label for="invoice_number">Invoice</label>
        <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Enter invoice
            number" value="{{old('invoice_number',$sale->invoice_number)}}"> </div> </div>
        <div class="col-md-6">

        <div class="form-group">
            <label for="sale_code">Sale Code</label>
            <input type="text" class="form-control" id="sale_code" name="sale_code"
            placeholder="Enter sale code" value="{{old('sale_code',$sale->sale_code)}}">
            </div>
            </div>
        </div>
        <div class="row">
        <div class="col-md-12">

        <div class="card card-success">
        <div class="card-header">
        <h3 class="card-title">Sale Details</h3>
        <div class="float-sm-right">

    </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="row">

        <div class="col-md-3">

        <div class="form-group">
            <label for="product_id_all">Product</label>
            <select class="form-control select2" id="product_id_all"
            name="product_id_all">
            <option value="">Select a Product</option>
            @foreach ($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
            </select>
        </div>
        </div>

        <div class="col-md-3">

            <div class="form-group">
            <label for="price">Sale Price</label>
            <input type="text" class="form-control calculate_total" id="price"
            name="price" placeholder="Enter Sale Price">
        </div>
        </div>
        <div class=" col-md-3">

        <div class="form-group">
        <label for="sale_quantity">Quantity</label>
        <input type="text" class="form-control calculate_total" id="sale_quantity" name="sale_quantity"
            placeholder="Enter Sale Quantity"> </div>
        </div>
        <div class="col-md-3">

        <div class="form-group">
        <label for="warranty">Warranty (Months)</label>
        <input type="text" class="form-control" id="warranty" name="warranty" placeholder="Enter warranty in months">
            </div> </div>
        </div>



        <div class="row">
        <div class="col-md-3">

            <div class="form-group">
            <label for="sub_total">Sub Total</label>
            <input type="text" class="form-control" id="sub_total" name="sub_total"
            readonly>
        </div>
        </div>
        <div class="col-md-3">

        <div class="form-group">
        <label for="sale_note">Note</label>
        <textarea class="form-control" id="sale_note" name="sale_note" placeholder="Enter sale
            note"></textarea> </div> </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="sale_serial">Serial (For multiple serial use comma
                                                    (,) to separate)</label>
                                                <div class="row">
                                                    <div class="col-md-8">

                                                        
                                                    <select name="sale_serial" id="sale_serial" class="form-control" multiple>
</select>
                                                    </div>
                                                    <div class="col-md-4">

                                                        <a href="#" id="add_serial" class="btn btn-warning">Add
                                                            Serial</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="sale_serial">Serial</label>
                                                <input type="hidden" name="sale_serial_all" id="sale_serial_all"
                                                    value="">
                                                <div id="serials">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <a href="#" id="add_details" class="btn btn-success">Add Sale
                                            Details</a>
                                    </div>

                                    <hr>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Warranty</th>
                                                <th>Total</th>
                                                <th>Serials</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sale_details">
                                            @if(old("product_id"))
                                            @for($i = 0; $i < count(old("product_id")); $i++) 
                                                        <tr>
                                                <td>
                                                    {{old("product_name")[$i]}}
                                                    <input type="hidden" name="product_id[]"
                                                        value="{{old('product_id')[$i]}}">
                                                    <input type="hidden" name="product_name[]"
                                                        value="{{old('product_name')[$i]}}">
                                                </td>
                                                <td>
                                                    {{old('sale_price')[$i]}}
                                                    <input type="hidden" name="sale_price[]"
                                                        value="{{old('sale_price')[$i]}}">
                                                </td>
                                                <td>
                                                    {{old('quantity')[$i]}}
                                                    <input type="hidden" name="quantity[]"
                                                        value="{{old('quantity')[$i]}}">
                                                </td>
                                                <td>
                                                    {{old('warranty_info')[$i]}}
                                                    <input type="hidden" name="warranty_info[]"
                                                        value="{{old('warranty_info')[$i]}}">
                                                </td>
                                                <td>
                                                    {{old('quantity')[$i] * old('sale_price')[$i]}}
                                                    <input type="hidden" name="total_amount[]"  class="total_amount"
                                                        value="{{old('quantity')[$i] * old('sale_price')[$i]}}">
                                                </td>
                                                <td>
                                                    @if(old('serials')[$i])
                                                    @php
                                                    $serial_data=explode(',',old('serials')[$i]);

                                                    @endphp
                                                    @foreach($serial_data as $serial)
                                                    <span class="badge badge-success mr-2"
                                                        style="font-size:100%">{{$serial}}</span>
                                                    @endforeach
                                                    @endif
                                                    <input type="hidden" name="serials[]"
                                                        value="{{old('serials')[$i]}}">
                                                </td>
                                                <td> <a href="#" class=" btn btn-danger remove"> X </a></td>

                                                <input type="hidden" name="note[]" value="${note}">
                                                </tr>
                                                @endfor
                                                @else
                                                
                                            @foreach($sale->details as $details)
                                            
                                            <tr>
                                                <td>
                                                    {{$details->product->name}}
                                                    <input type="hidden" name="product_id[]"
                                                        value="{{$details->product->id}}">
                                                    <input type="hidden" name="product_name[]"
                                                        value="{{$details->product->name}}">
                                                </td>
                                                <td>
                                                    {{$details->sale_price}}
                                                    <input type="hidden" name="sale_price[]"
                                                        value="{{$details->sale_price}}">
                                                </td>
                                                <td>
                                                    {{$details->quantity}}
                                                    <input type="hidden" name="quantity[]"
                                                        value="{{$details->quantity}}">
                                                </td>
                                                <td>
                                                    {{$details->warranty_info}}
                                                    <input type="hidden" name="warranty_info[]"
                                                        value="{{$details->warranty_info}}">
                                                </td>
                                                <td>
                                                    {{$details->total_amount}}
                                                    <input type="hidden" name="total_amount[]" class="total_amount"
                                                        value="{{$details->total_amount}}">
                                                </td>
                                                <td>
                                                    @php
                                                    $serial_data=implode(',',$details->serial->pluck("serial_number")->toArray());

                                                    @endphp
                                                    @if($details->serial && count($details->serial) > 0)
                                                    @foreach($details->serial as $serial)
                                                    <span class="badge badge-success mr-2"
                                                        style="font-size:100%">{{$serial->serial_number}}</span>
                                                    @endforeach
                                                    @endif
                                                    <input type="hidden" name="serials[]"
                                                        value="{{($serial_data && count($details->serial)>0)?$serial_data:''}}">
                                                </td>
                                                <td> <a href="#" class=" btn btn-danger remove"> X </a></td>

                                                <input type="hidden" name="note[]" value="{{$details->note}}">
                                                </tr>
                                                @endforeach
                                                @endif
                                        </tbody>
                                    </table>



                                </div>

                            </div>


                        </div>





                    </div>
                    <div class="row">
                        <div class="col-md-3"><label for="sale_note">Sub Total</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="total" name="total"
                                value="{{old('total',$sale->total_amount)}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><label for="sale_note">Discount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" id="discount" name="discount"
                                value="{{old('discount',$sale->discount)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="sale_note">Payable Amount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="payable_amount"
                                name="payable_amount" value="{{old('payable_amount',$sale->payable_amount)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="sale_note">Paid Amount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" id="paid_amount"
                                name="paid_amount" value="{{old('paid_amount',$sale->paid_amount)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="sale_note">DUE</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="due_amount"
                                name="due_amount" value="{{old('due_amount',$sale->due_amount)}}">
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(function () {

        //$('#descr').summernote();
        $('.select2').select2();
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
        });

        // $('#description').summernote();

        $("input[data-bootstrap-switch]").each(function () {
            // $(this).bootstrapSwitch('state', $(this).prop('checked'));
            $(this).bootstrapSwitch();
        })
        $(".calculate_total").change(function () {
            var quantity = $("#sale_quantity").val();
            var price = $("#price").val();
            $("#sub_total").val(quantity * price);

        });
        $(document).ready(function () {
            $("#add_details").click(function (e) {
                var product_id = $("#product_id_all option:selected").val();
                if (!product_id) {
                    swal({
                        title: "Please select a product",
                        text: "Data Missing",
                        icon: "warning",
                        button: true,
                        dangerMode: false,
                    }).then((isConfirm) => {
                        $("#product_id_all").focus();
                    });
                    // swal("Data Missing", "Please select a product", "warning");
                    return;
                }
                var product_name = $("#product_id_all option:selected").text();
                var price = $("#price").val();

                if (!(price > 0)) {
                    swal({
                        title: "Price Must be greater than  0",
                        text: "Data Missing",
                        icon: "warning",
                        button: true,
                        dangerMode: false,
                    }).then((isConfirm) => {
                        $("#price").focus();
                    });
                    return;
                }
                var quantity = $("#sale_quantity").val();
                if (!(quantity > 0)) {
                    swal({
                        title: "Quantity Must be greater than  0",
                        text: "Data Missing",
                        icon: "warning",
                        button: true,
                        dangerMode: false,
                    }).then((isConfirm) => {
                        $("#sale_quantity").focus();
                    });
                    return;
                }
                var warranty = $("#warranty").val();
                var serial = $("#sale_serial_all").val();
                var note = $("#sale_note").val();
                var serial_array = $("#sale_serial_all").val().split(",");
                var serial_data = '';
                $.each(serial_array, function (key, value) {
                    serial_data +=
                        `<span class="badge badge-success mr-2" style="font-size:100%" >${value}</span>`;
                });
                $("#sale_details").append(`
                
                <tr>
                                                <td>
                                                ${product_name}
                                                    <input type="hidden" name="product_id[]" value="${product_id}">
                                                    <input type="hidden" name="product_name[]" value="${product_name}">
                                                </td>
                                                <td>
                                                ${price}
                                                    <input type="hidden" name="sale_price[]" value="${price}">
                                                </td>
                                                <td>
                                                ${quantity}
                                                    <input type="hidden" name="quantity[]" value="${quantity}">
                                                </td>
                                                <td>
                                                ${warranty}
                                                    <input type="hidden" name="warranty_info[]" value="${warranty}">
                                                </td>
                                                <td>
                                                ${quantity * price}
                                                    <input type="hidden" name="total_amount[]"  class="total_amount" value="${quantity * price}">
                                                </td>
                                                <td>
                                                ${serial_data}
                                                    <input type="hidden" name="serials[]" value="${serial}">
                                                </td>
                                                <td> <a href="#" class=" btn btn-danger remove"> X </a></td>
                                                
                                                <input type="hidden" name="note[]" value="${note}">
                                            </tr>
                `);
                debugger;
                // var total = $("#total").val();
                // $("#total").val(parseFloat(total) + parseFloat($('#sub_total').val()));
                calculate_total_amount();
                $("#payable_amount").val($("#total").val());
                $('#product_id_all').val("");
                $('#product_id_all option:first').prop('selected', true);
                $("#price").val("");
                $("#sale_quantity").val("");
                $("#warranty").val("");
                $("#sale_serial_all").val("");
                $("#serials").html("");
                $('#product_id_all').focus();

                $('#sub_total').val("");
            });
            function calculate_total_amount() {
                debugger;
                var total = 0;
                $("#total").val(0);
                $(".total_amount").each(function (key, value) {
                    debugger;
                    $("#total").val(parseFloat($("#total").val()) + parseFloat(value.value));
                });
                $("#total").change();
                
            }
            $("#total").change(function () {
                var discount = $("#discount").val();
                var total = $("#total").val();
                $("#payable_amount").val(total - discount);
                var paid = $("#paid_amount").val();
                $("#due_amount").val(total - discount - paid);
            });
        $("#discount").change(function () {
                // var discount = $("#discount").val();
                // var total = $("#total").val();
                // $("#payable_amount").val(total - discount);
                $("#total").change();
            });
            $("#paid_amount").change(function () {
                // var payable_amount = $("#payable_amount").val();
                // var paid = $("#paid_amount").val();
                // $("#due_amount").val(payable_amount - paid);
                $("#total").change();
            });
            $(document).on("click", ".remove", function (e) {
                e.preventDefault();
                e.target.parentNode.parentNode.remove();
                $("#discount").change();
                calculate_total_amount();
                debugger;
            });
            
            $("#add_serial").click(function (e) {
                e.preventDefault();
                var serial_array = $("#sale_serial").val();
                // if (serial.indexof(',') > 0)
                // var serial_array = serial.split(',');
                $.each(serial_array, function (key, value) {
                    $("#serials").append(
                        `<span class="badge badge-success mr-2 serial" style="font-size:100%" >${value}</span>`
                    )

                });
                var val = [];
                var all = $(".serial").each(function (key, value) {
                    debugger;
                    val.push(value.innerText);
                });

                debugger;
                $("#sale_serial_all").val(val.join(','));
                $("#sale_serial").val("");

                $("#sale_serial").focus();
                // var all = val.join(',');
            });
        });


        
    $("#product_id_all").change(function(){
        debugger;
        var url="{{route('backend.sale.get_unsold_serials','*')}}";
        $("#sale_serial").empty();
        var product_id = $("#product_id_all option:selected").val();
        $.ajax({
                    url: url.replace('*',product_id),
                    type: "get",
                    data: {
                        "_token": '{{csrf_token()}}',
                    },
                    success: function(data) {
                        debugger;
                        var sale_serial='';
                        $.each(data,function(key,value){
                            debugger;
                            $("#sale_serial").append(`
                            <option value="${value.serial_number}">${value.serial_number}</option>
                            `)
                        });
                        $("#sale_serial").select2();
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal("Error deleting!", "Please try again", "error");
                    }
                });
    })
    });
</script>
@endsection