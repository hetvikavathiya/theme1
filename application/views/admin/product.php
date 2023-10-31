<div class="page-wrapper">
    <?php $this->load->view('admin/flash_message'); ?>

    <div class="page-body">
        <div class="mx-4">
            <div class="card">
                <div class="card-status-top bg-blue"></div>
                <h3 class="card-header">
                    Add Product
                </h3>
                <div class="card-body border-bottom py-3">
                    <form class="row" action="<?php if (isset($update_data)) {
                                                    echo base_url('admin/product/index/update');
                                                } else {
                                                    echo base_url('admin/product/index/add');
                                                } ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?php if (isset($update_data)) {
                                                                            echo $update_data['id'];
                                                                        } ?>">

                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label" for="prd">Title </label>
                                <input class="form-control" type="text" name="title" placeholder="enter your title" id="title" value="<?= isset($update_data) ? $update_data['title'] : null ?>" required>
                            </div>

                            <div class="col-sm-4">
                                <label class="form-label" for="prd">Name : </label>
                                <input class="form-control" type="text" name="name" placeholder="enter your product name" id="name" value="<?= isset($update_data) ? $update_data['name'] : null ?>" required>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">category</label>
                                    <select class="form-select select2 " name="category_id" id="category">
                                        <option value="" selected>Select category</option>
                                        <?php
                                        $category = $this->db->get('category')->result();
                                        foreach ($category as $value) {
                                        ?>
                                            <option value="<?= $value->id; ?>" <?php if (isset($update_data) && $value->id == $update_data['category_id']) {
                                                                                    echo 'selected';
                                                                                } ?>><?= $value->name; ?></option> <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row my-4">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form-label">Subcategory</label>
                                    <select class="form-select select2" name="subcategory_id" id="subcategory">
                                        <option selected>Select subcategory</option>
                                        <?php
                                        $subcategory = $this->db->where('category_id', $name)->get('subcategory')->result();
                                        foreach ($subcategory as $value) {

                                        ?>

                                            <option value="<?= $value->id; ?>" <?php if (isset($update_data) && $value->id == $update_data['subcategory_id']) {
                                                                                    echo 'selected';
                                                                                } ?>><?= $value->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">Description </label>
                                <input class="form-control" type="textarea" name="description" placeholder="enter description" id="description" value="<?= isset($update_data) ? $update_data['description'] : null ?>" required>

                            </div>
                            <div class="col-sm-3">
                                <label class="form-label">Product Image </label>
                                <input class="form-control" type="file" name="productimage" id="productimage" value="<?php if (isset($update_data)) {
                                                                                                                            echo 'required';
                                                                                                                        } ?>">

                            </div>
                            <div class="col-sm-3">
                                <label class="form-label" for="prd">Price: </label>
                                <input class="form-control" type="number" name="price" placeholder="enter your product price" id="price" value="<?= isset($update_data) ? $update_data['price'] : null ?>" required>

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12 ">
                                <label class="form-label" for="prd"> &nbsp </label>
                                <input class="btn btn-primary " type="submit" value="<?= isset($update_data) ? "UPDATE" : "ADD" ?> PRODUCT">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="container-fuild my-4">
            <div class="row">
                <div class="col-sm-12 mt-2">
                    <div class="card mx-4">
                        <div class="card-header">
                            <h3 class="card-title">View product </h3>
                            <h3 class="ms-5 card-title">Select category:</h3>
                            <div class="form-group ms-1">
                                <select class="form-select select2 " id="filtercategory">
                                    <option value="">Select category</option>
                                    <?php
                                    $category = $this->db->get('category')->result();
                                    foreach ($category as $value) {
                                    ?>
                                        <option value="<?= $value->id; ?>" <?php if (isset($update_data) && $value->id == $update_data['category_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?= $value->name; ?></option> <?php } ?>
                                </select>

                            </div>



                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="table-responsive">
                                <table id="product" class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th>Serial No </th>
                                            <th>Title</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>subcategory</th>
                                            <th>Description</th>
                                            <th>Image</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- subcategory depended category -->
        <script>
            $(document).ready(function() {

                $("#category").on('change', function() {
                    var categoryId = $(this).val();
                    $.ajax({
                        method: "post",
                        url: "<?= base_url('admin/product/getsubcategory'); ?>",
                        data: {
                            id: categoryId
                        },

                        success: function(response) {
                            response = JSON.parse(response);
                            $("#subcategory").html(response.html);
                        }


                    });

                });

                if ($('#category').val()) {
                    var categoryId = $('#category').val();
                    $.ajax({
                        method: "post",
                        url: "<?= base_url('admin/product/getsubcategory'); ?>",
                        data: {
                            id: categoryId
                        },

                        success: function(response) {
                            response = JSON.parse(response);
                            $("#subcategory").html(response.html);
                        }


                    });
                }

            });
        </script>
        <!-- datatable ajax  -->
        <script>
            $(document).ready(function() {

                var table = $('#product').DataTable({
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
                        'url': "<?= base_url(); ?>admin/product/getlist",
                        'data': function(data) {
                            data.category = $('#filtercategory').val();

                        }
                    },
                    "columns": [{
                            data: 'id'
                        },
                        {
                            data: 'title'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: 'category'
                        },
                        {
                            data: 'subcategory'
                        },
                        {
                            data: 'description'
                        },
                        {
                            data: 'productimage'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action'
                        },

                    ],
                });
                $('#filtercategory').on('change', function() {
                    table.clear()
                    table.draw()
                });
            });
        </script>