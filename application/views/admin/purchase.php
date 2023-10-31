<div class="page-wrapper my-4">
    <?php $this->load->view('admin/flash_message'); ?>

    <div class="page-body">
        <div class="mx-4">

            <div class="card">
                <div class="card-status-top bg-blue"></div>
                <h3 class="card-header">
                    Add Purchase
                </h3>
                <div class="card-body border-bottom py-3">

                    <form class="row" action="<?php if (isset($update_data)) {
                                                    echo base_url('admin/purchase/index/update');
                                                } else {
                                                    echo base_url('admin/purchase/index/add');
                                                } ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?php if (isset($update_data)) {
                                                                            echo $update_data['id'];
                                                                        } ?>">

                        <div class="row">
                            <div class="col-sm-3">
                                <label class="form-label" for="prd">Date :</label>
                                <input class="form-control" type="date" name="date" id="date" value="<?php if (isset($update_data)) {
                                                                                                            echo $update_data['date'];
                                                                                                        } ?>" required>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Customber :</label>
                                    <select class="form-select select2" name="customber_id" id="customber_id">
                                        <option class=""></option>
                                        <?php
                                        $customber = $this->db->get('customber')->result();
                                        foreach ($customber as $value) {
                                        ?>
                                            <option value="<?= $value->cid; ?>" <?php if (isset($update_data) && $value->cid == $update_data['customber_id']) {
                                                                                    echo 'selected';
                                                                                } ?>><?= $value->name; ?></option> <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Product :</label>
                                        <select class="form-select select2 product_id" name="product_id">
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
                                </div>
                                <div class="col-sm-3"   >
                                    <div class="form-group">
                                        <label class="form-label">Quantity :</label>
                                        <input class="form-control calc" data-mqty="5555" type="number" name="quantity" id="quantity" placeholder="product quantity" value="<?php if (isset($update_data)) {
                                                                                                                                                                                echo $update_data['quantity'];
                                                                                                                                                                            } ?>" />

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Price :</label>
                                        <input class="form-control price" type="text" name="price" data-price="55" placeholder="product price" value="<?php if (isset($update_data)) {
                                                                                                                                                            echo $update_data['price'];
                                                                                                                                                        } ?>" />


                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label">Total Price :</label>
                                        <input class="form-control" type="text" name="totalprice" id="totalprice" placeholder="product totalprice" readonly value="<?php if (isset($update_data)) {
                                                                                                                                                                        echo $update_data['totalprice'];
                                                                                                                                                                    } ?>" />

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 ">
                                <label class="form-label" for="prd"> &nbsp </label>
                                <input class="btn btn-primary " type="submit" value="<?= isset($update_data) ? "UPDATE" : "ADD" ?> CART">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.product_id').on('change', function() {
            var price = $(this).find(':selected').data('price');
            $(".price").val(price);
            // var product_id = $(this).val();
            // $.ajax({
            //     method: "post",
            //     url: "<?= base_url('admin/purchase/getprice'); ?>",
            //     type: 'json',
            //     data: {
            //         product_id: product_id,
            //     },
            //     success: function(response) {
            //         $("#price").val(response);
            //     }
            // });
        });

        $(".calc").keyup(function() {
            var qty = $("#quantity").val();
            var price = $(".price").val();
            var total = qty * price;
            $("#totalprice").val(total);
        });

    });
</script>