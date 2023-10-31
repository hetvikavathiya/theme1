<div class="container-fuild my-4">
    <div class="row">
        <?php $this->load->view('admin/flash_message'); ?>

        <div class="col-sm-12 mt-2">
            <div class="card mx-4">
                <div class="card-header">
                    <h3 class="card-title">View Purchase_selected2 report </h3>
                </div>

                <div class="card-body border-bottom py-3">
                    <div class="row ">
                        <div class="col-sm-2">
                            <label>From date:</label> <br>
                            <input type="date" id="fromdate" name="fromdddate" class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <label>To date:</label> <br>
                            <input type="date" id="todate" name="todate" class="form-control">
                        </div>
                        <div class="col-sm-2 ">
                            <div class="form-group ms-1 ">
                                <label>Select customber:</label>
                                <select class="form-select select2" id="filtercustomber">
                                    <option value="">Select customber</option>
                                    <?php
                                    $customber = $this->db->get('customber')->result();
                                    foreach ($customber as $value) {
                                    ?>
                                        <option value="<?= $value->cid; ?>" <?php if (isset($update_data) && $value->id == $update_data['customber_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?= $value->name; ?></option> <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br></br>
                    <div class="table-responsive">

                        <table id="purchase_selected2" class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>Serial No </th>
                                    <th>Action</th>
                                    <th>Date</th>
                                    <th>Sales Id</th>
                                    <th>Customer </th>
                                    <th>Product </th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Total Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- datatable ajax  -->

<script>
    $(document).ready(function() {
        var table = $('#purchase_selected2').DataTable({
            "iDisplayLength": 5,
            "lengthMenu": [
                [5, 10, 25, 50, 100, 500, 1000, 5000],
                [5, 10, 25, 50, 100, 500, 1000, 5000]
            ],
            'processing': true,
            'serverSide': true,
            'destroy': true,
            'serverMethod': 'post',
            'searching': true,
            "ajax": {
                'url': "<?= base_url(); ?>admin/purchase_selected2/getlist",
                'data': function(data) {
                    data.customber = $('#filtercustomber').val();
                    data.todate = $('#todate').val();
                    data.fromdate = $('#fromdate').val();
                }
            },
            "columns": [{
                    data: 'id'
                },
                {
                    data: 'action'
                },
                {
                    data: 'date'
                },
                {
                    data: 'sales_id'
                },
                {
                    data: 'customber'
                },
                {
                    data: 'product'
                },
                {
                    data: 'price'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'total_price'
                },
                {
                    data: 'total_pcs'
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
                },

            ],

        });
        $('#filtercustomber').on('change', function() {
            table.clear()
            table.draw()
        });
        $('#todate').on('change', function() {
            table.clear()
            table.draw()
        })
        $('#fromdate').on('change', function() {
            table.clear()
            table.draw()
        })

    });
</script>