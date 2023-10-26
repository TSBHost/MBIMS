@extends("backend.layout.app")

@section("title","Purchase")
@section("style-section")

<!-- summernote -->
<link rel="stylesheet" href="{{asset('backend/plugins/summernote/summernote-bs4.min.css')}}">
<!-- iCheck for checkboxes
    and radio inputs -->
<link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.29/dist/sweetalert2.css"> @endsection
@section("header-section") <div class="row mb-2">
    <div class="col-sm-6">
        <h1 class="m-0">Purchase Add</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Purchase</a></li>
            <li class="breadcrumb-item active">Add New </li>
        </ol>
    </div><!-- /.col -->
</div><!-- /.row --> @endsection @section("content-section")
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-md-12">
        <form action="{{route('backend.purchase.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Purchase Add New</h3>
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
                                <label for="purchase_date">Purchase Date</label>
                                <input type="text" class="form-control datepicker" id="purchase_date"
                                    name="purchase_date" placeholder="Enter Purchase
    Date" required value="{{old('purchase_date')}}">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select class="form-control select2" id="supplier_id" name="supplier_id" required>
                                    <option value="">Select a supplier</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}" @if(old('supplier_id')==$supplier->id) selected
                                        @endif>{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="invoice_number">Invoice</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number"
                                    placeholder="Enter invoice number" value="{{old('invoice_number')}}">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="purchase_code">Purchase Code</label>
                                <input type="text" class="form-control" id="purchase_code" name="purchase_code"
                                    placeholder="Enter purchase code" value="{{old('purchase_code')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="card  card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Purchase Details</h3>
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
                                                <label for="price">Purchase Price</label>
                                                <input type="text" class="form-control calculate_total" id="price"
                                                    name="price" placeholder="Enter Purchase Price">
                                            </div>
                                        </div>
                                        <div class=" col-md-3">

                                            <div class="form-group">
                                                <label for="purchase_quantity">Quantity</label>
                                                <input type="text" class="form-control calculate_total"
                                                    id="purchase_quantity" name="purchase_quantity"
                                                    placeholder="Enter Purchase Quantity">
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="warranty">Warranty (Months)</label>
                                                <input type="text" class="form-control" id="warranty" name="warranty"
                                                    placeholder="Enter warranty in months">
                                            </div>
                                        </div>
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
                                                <label for="purchase_note">Note</label>
                                                <textarea class="form-control" id="purchase_note" name="purchase_note"
                                                    placeholder="Enter purchase note"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="form-group">
                                                <label for="purchase_serial">Serial (For multiple serial use comma
                                                    (,) to separate)</label>
                                                <div class="row">
                                                    <div class="col-md-8">

                                                        <input class="form-control" id="purchase_serial"
                                                            name="purchase_serial" placeholder="Enter purchase serial">
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
                                                <label for="purchase_serial">Serial</label>
                                                <input type="hidden" name="purchase_serial_all" id="purchase_serial_all"
                                                    value="">
                                                <div id="serials">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <a href="#" id="add_details" class="btn btn-success">Add Purchase
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
                                        <tbody id="purchase_details">
                                            @if(old("product_id"))
                                            @for($i = 0; $i < count(old("product_id")); $i++) <tr>
                                                <td>
                                                    {{old("product_name")[$i]}}
                                                    <input type="hidden" name="product_id[]"
                                                        value="{{old('product_id')[$i]}}">
                                                    <input type="hidden" name="product_name[]"
                                                        value="{{old('product_name')[$i]}}">
                                                </td>
                                                <td>
                                                    {{old('purchase_price')[$i]}}
                                                    <input type="hidden" name="purchase_price[]"
                                                        value="{{old('purchase_price')[$i]}}">
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
                                                    {{old('quantity')[$i] * old('purchase_price')[$i]}}
                                                    <input type="hidden" name="total_amount[]"  class="total_amount"
                                                        value="{{old('quantity')[$i] * old('purchase_price')[$i]}}">
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
                                                @endif
                                        </tbody>
                                    </table>



                                </div>

                            </div>


                        </div>





                    </div>
                    <div class="row">
                        <div class="col-md-3"><label for="purchase_note">Sub Total</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="total" name="total" value="{{old('total',0)}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"><label for="purchase_note">Discount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" id="discount" name="discount"
                                value="0{{old('discount',0)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="purchase_note">Payable Amount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="payable_amount" name="payable_amount"
                                value="{{old('payable_amount',0)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="purchase_note">Paid Amount</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" id="paid_amount"
                                name="paid_amount" value="{{old('paid_amount',0)}}"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><label for="purchase_note">DUE</label></div>
                        <div class="col-md-3"><input type="text" class="form-control" readonly id="due_amount" name="due_amount" value="{{old('due_amount',0)}}">
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
$(function() {

    //$('#descr').summernote();
    $('.select2').select2();
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
    });

    // $('#description').summernote();

    $("input[data-bootstrap-switch]").each(function() {
        // $(this).bootstrapSwitch('state', $(this).prop('checked'));
        $(this).bootstrapSwitch();
    })
    $(".calculate_total").change(function() {
        var quantity = $("#purchase_quantity").val();
        var price = $("#price").val();
        $("#sub_total").val(quantity * price);

    });
    $(document).ready(function() {
        $("#add_details").click(function(e) {
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
            var quantity = $("#purchase_quantity").val();
            if (!(quantity > 0)) {
                swal({
                    title: "Quantity Must be greater than  0",
                    text: "Data Missing",
                    icon: "warning",
                    button: true,
                    dangerMode: false,
                }).then((isConfirm) => {
                    $("#purchase_quantity").focus();
                });
                return;
            }
            var warranty = $("#warranty").val();
            var serial = $("#purchase_serial_all").val();
            var note = $("#purchase_note").val();
            var serial_array = $("#purchase_serial_all").val().split(",");
            var serial_data = '';
            $.each(serial_array, function(key, value) {
                serial_data +=
                    `<span class="badge badge-success mr-2" style="font-size:100%" >${value}</span>`;
            });
            $("#purchase_details").append(`
                
                <tr>
                                                <td>
                                                ${product_name}
                                                    <input type="hidden" name="product_id[]" value="${product_id}">
                                                    <input type="hidden" name="product_name[]" value="${product_name}">
                                                </td>
                                                <td>
                                                ${price}
                                                    <input type="hidden" name="purchase_price[]" value="${price}">
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
            $("#purchase_quantity").val("");
            $("#warranty").val("");
            $("#purchase_serial_all").val("");
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
        $("#discount").change(function() {
            // var discount = $("#discount").val();
            // var total = $("#total").val();
            // $("#payable_amount").val(total - discount);
            $("#total").change();
        });
        $("#paid_amount").change(function() {
            // var payable_amount = $("#payable_amount").val();
            // var paid = $("#paid_amount").val();
            // $("#due_amount").val(payable_amount - paid);
            $("#total").change();
        });
        $(document).on("click", ".remove", function(e) {
            e.preventDefault();
            e.target.parentNode.parentNode.remove();
                calculate_total_amount();
            debugger;
        });
        
        $("#add_serial").click(function(e) {
            e.preventDefault();
            var serial = $("#purchase_serial").val();
            // if (serial.indexof(',') > 0)
            var serial_array = serial.split(',');
            $.each(serial_array, function(key, value) {
                $("#serials").append(
                    `<span class="badge badge-success mr-2 serial" style="font-size:100%" >${value}</span>`
                )

            });
            var val = [];
            var all = $(".serial").each(function(key, value) {
                debugger;
                val.push(value.innerText);
            });

            debugger;
            $("#purchase_serial_all").val(val.join(','));
            $("#purchase_serial").val("");

            $("#purchase_serial").focus();
            // var all = val.join(',');
        });
    });
});
</script>
@endsection