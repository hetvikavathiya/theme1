<div class="container">
    <form class="row" action="<?php if (isset($update_data)) {
                                    echo base_url('admin/ItemController/index/update');
                                } else {
                                    echo base_url('admin/ItemController/index/add');
                                } ?>" method="post">
        <input type="hidden" name="id" value="<?php if (isset($update_data)) {
                                                    echo $update_data['id'];
                                                } ?>">
        <div class="row mt-4">
            <div class="col-sm-12">
                <label for="itemSelect">Select an item:</label>
                <select id="itemSelect" class="form-select select2" name="category_id">
                    <option value="">Select an item</option>
                </select>
            </div>
        </div>
        <div class="col-md-2 ">
            <label class="form-label" for="prd"> &nbsp </label>
            <input class="btn btn-primary" type="submit" value="<?= isset($update_data) ? "UPDATE" : "ADD" ?> ITEM">
        </div>
    </form>
</div>
<div class="container-fluid">
    <div class="col-12">
        <div class="card mx-4">
            <div class="card-header">
                <h3 class="card-title">View itemselect </h3>
            </div>
            <div class="card-body border-bottom py-3">
                <div class="table-responsive">
                    <table id="example1" class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>Serial No </th>
                                <th>Action</th>
                                <th>itemselect</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            if (count($data)) {

                                foreach ($data as $data) {
                            ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td>
                                            <div>

                                                <a class="btn btn-primary" id="editButton" href="<?= base_url('admin/ItemController/index/edit/') . $data['id'] ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit " width="50" height="50" viewBox="0 0 25 25" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                        <path d="M16 5l3 3"></path>
                                                    </svg>

                                                    Edit
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a class="btn btn-danger" onclick="return confirm('Are you sure want to Delete.?');" href="<?= base_url('admin/ItemController/index/delete/') . $data['id'] ?>">

                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M3 3l18 18"></path>
                                                        <path d="M4 7h3m4 0h9"></path>
                                                        <path d="M10 11l0 6"></path>
                                                        <path d="M14 14l0 3"></path>
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l.077 -.923"></path>
                                                        <path d="M18.384 14.373l.616 -7.373"></path>
                                                        <path d="M9 5v-1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                    </svg>
                                                    Delete
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <?= $data['category']; ?>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var dropdown = $("#itemSelect");

        var previousValue = dropdown.val();

        $.ajax({
            url: "<?php echo base_url('admin/ItemController/fetch_items'); ?>",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var select = $("#itemSelect");
                dropdown.empty();
                $.each(data, function(key, value) {
                    select.append($("<option></option>")
                        .attr("value", value.id)
                        .text(value.name));
                });

                // if (previousValue) {
                //     if (dropdown.find('option[value="' + previousValue + '"]').length > 0) {
                //         dropdown.val(previousValue);
                //     }
                // }
            }
        });
    });
</script>