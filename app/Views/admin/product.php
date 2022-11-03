<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Products Page</h1>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/add_product" class="btn btn-primary float-end">New Product</a>
                        <h5 class="card-title mb-0">Product Table</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Product Quantity</th>
                                        <th>Product Total Price</th>
                                        <th>Description</th>
                                        <th>Date added</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                        <tr>
                                            <td><?= $product->product_id ?></td>
                                            <td><?= esc(ucwords($product->product_name)) ?></td>
                                            <td><?= esc($product->product_qty) ?></td>
                                            <td><?= esc($product->product_total_price) ?></td>
                                            <td><?= esc(ucwords($product->description)) ?></td>
                                            <td><?= get_date($product->date_added) ?></td>
                                            <td>
                                                <a href="/admin/edit_product/<?= $product->id ?>" class="btn btn-success">Edit</a>
                                                <button type="button" class="confirm_del btn btn-danger" value="<?= $product->id ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>

    $(document).ready(function () {
        $('.confirm_del').click(function (e) { 
            e.preventDefault();
            var id = $(this).val();//"this" means it will get the value of .confirm_del_btn once the user click that btn
            
            Swal.fire({
                title: 'Are you sure?',
                text: "Product info will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) 
                {
                    $.ajax({
                        url: "/product/delete/"+id,
                        success: function (response) {
                            Swal.fire({
                                title: response.status,
                                text: response.status_text,
                                icon: response.status_icon,
                                timer: 2000,
                            }).then((success) => {
                                window.location.reload();
                            });
                        }
                    });
                }
            })
        });
    });

</script>


<?= $this->endSection() ?>