<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Sales Page</h1>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/add_sales" class="btn btn-primary float-end">New Sale</a>
                        <h5 class="card-title mb-0">Sales Table</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Transaction ID</th>
                                        <th>Product Name</th>
                                        <th>Customer Name</th>
                                        <th>Purchase total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($sales as $sale): ?>
                                        <tr>
                                            <td><?= esc($sale->transaction_id) ?></td>
                                            <td><?= esc($sale->product_name) ?></td>
                                            <td><?= esc(ucwords($sale->customer_name)) ?></td>
                                            <td><?= esc($sale->purchase_total_price) ?></td>
                                            <td>
                                            <button type="button" class="confirm_del btn btn-danger" value="<?= $sale->id ?>">Delete</button>
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
                text: "Category info will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) 
                {
                    $.ajax({
                        url: "/category/delete/"+id,
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