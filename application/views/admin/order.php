<div class="page-wrapper my-4">
    <?php $this->load->view('admin/flash_message'); ?>

    <div class="page-body">
        <div class="mx-4">
            <div class="card">
                <div class="card-status-top bg-blue"></div>
                <h3 class="card-header">
                    Order
                </h3>
                <div class="card-body border-bottom py-3">
                    <form class="row" action="<?php echo base_url('admin/Order/index/add'); ?>" method="post" id="myFormId">
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-label">Customber :</label>
                                        <select class="form-select select2 customer_id" name="customer_id">
                                            <option class=""></option>
                                            <?php
                                            $customer = $this->db->get('customber')->result();
                                            foreach ($customer as $value) {
                                            ?>
                                                <option value="<?= $value->cid; ?>" data-number="<?= $value->number; ?>"><?= $value->name; ?></option> <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-2">
                                    <label class="form-label" for="date">Date :</label>
                                    <input class="form-control" type="date" name="date" id="date" value="<?= date('Y-m-d') ?>" required>
                                </div>
                                <div class="col-sm-2">
                                    <label class="form-label" for="date">Mobile_no:</label>
                                    <input class="form-control number" type="number" name="number" data-number="55" placeholder="  Customer number" />
                                </div>
                                <div class="parent my-4" id="paste">
                                    <div class="sectiontocopy">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="form-label">Product :</label>
                                                <select class="form-select select2 product_id" name="product_id[]">
                                                    <option class=""></option>
                                                    <?php
                                                    $product = $this->db->get('product')->result();
                                                    foreach ($product as $value) {
                                                    ?>
                                                        <option value="<?= $value->id; ?>" data-price="<?= $value->price; ?>" <?php if (isset($update_data) && $value->id == $update_data['product_id']) {
                                                                                                                                    echo 'selected';
                                                                                                                                } ?>><?= $value->name; ?></option> <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="form-label">Quantity :</label>
                                                    <input class="form-control quantity" type="number" name="quantity[]" id="quantity" placeholder="product quantity" value="<?php if (isset($update_data)) {
                                                                                                                                                                                    echo $update_data['quantity'];
                                                                                                                                                                                } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="form-label">Price :</label>
                                                    <input class="form-control price" type="text" name="price[]" data-price="55" placeholder="product price" value="<?php if (isset($update_data)) {
                                                                                                                                                                        echo $update_data['price'];
                                                                                                                                                                    } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="form-label">Total Price :</label>
                                                    <input class="form-control totalprice" type="text" name="totalprice[]" placeholder="product totalprice" readonly value="<?php if (isset($update_data)) {
                                                                                                                                                                                echo $update_data['totalprice'];
                                                                                                                                                                            } ?>" />
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <label class="form-label" for="prd"> &nbsp </label>
                                                <button type="button" class="btn btn-danger del">X</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <label class="form-label" for="prd"> &nbsp </label>
                                    <button type="button" class="btn btn-primary" id="add">+</button>
                                </div>
                            </div>
                            <div class="row my-4">
                                <div class="col-sm-3">
                                    <label for="subtotal"><b>Sub Total :</b></label>
                                    <input type="text" class="subtotal" name="subtotal" placeholder="subtotal" readonly />
                                </div>
                            </div>

                            <div class="row my-2">
                                <div class="col-sm-4">
                                    <label for="totalquantity"><b>Total Quantity :</b></label>
                                    <input type="text" class="totalquantity" name="totalquantity" placeholder="totalquantity" readonly />

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 ">
                                    <label class="form-label" for="prd"> &nbsp </label>
                                    <input class="btn btn-primary" id="submit" type="submit" value="ADD CART">
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById('myFormId').onsubmit = function() {
        document.getElementById("submit").disabled = true;
    }
</script>

<script>
    var main_row = '';
    $(document).ready(function() {
        main_row = $(".parent").html();
        $(document).on('change', '.product_id,.quantity,.price,.customer_id', function() {
            var ref = $(this).parent().parent().parent();
            var price = ref.find(":selected").data('price');
            ref.find(".price").val(price);

            var number = ref.find(":selected").data('number');
            ref.find(".number").val(number);

            var qty = ref.find(".quantity").val();
            var price = ref.find(".price").val();
            var total = qty * price;
            ref.find(".totalprice").val(total);
            maintotal();
            totalquantity();
        });

        $(document).on('keyup', '.quantity,.price', function() {
            var refrow = $(this).parent().parent().parent();
            var qty = refrow.find(".quantity").val();
            var price = refrow.find(".price").val();
            var total = qty * price;
            refrow.find(".totalprice").val(total);
            maintotal();
            totalquantity();

        });

        $(document).on('click', '.del ', function() {

            maintotal();
            totalquantity();

        });

        function maintotal() {
            var subtotal = 0;

            var totalpricelength = $(".totalprice").length;

            for (var i = 0; i < totalpricelength; i++) {
                subtotal += parseFloat($($(".totalprice")[i]).val()) || 0;
            }

            // console.log(subtotal);
            $('.subtotal').val(subtotal);
        }

        function totalquantity() {
            var totalquantity = 0;

            var totalquantitylength = $(".quantity").length;

            for (var i = 0; i < totalquantitylength; i++) {
                totalquantity += parseFloat($($(".quantity")[i]).val()) || 0;
            }
            $('.totalquantity').val(totalquantity);
        }

    });

    $("#add").click(function() {
        $("#paste").append(main_row);
        $(".product_id").select2();
    });

    $(document).on('click', '.del', function() {
        var product = $(".product_id").length;
        if (product > 1) {
            $(this).parent().parent().remove();
        }

    });
</script>