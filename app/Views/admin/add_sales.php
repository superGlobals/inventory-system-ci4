<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0 offset-3">

        <h1 class="h3 mb-3">Add sales page</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/sales" class="btn btn-primary float-end">Back</a>
                        <h5 class="card-title mb-0">Add Sales</h5>
                    </div>
                    <div class="card-body">
                        <form action="/sales/store" method="POST">
                            <?= csrf_field() ?>
                            <div class="row">
                            <div class="mb-3">
                                    <label for="contact" class="form-label">Customer Name</label>
                                    <input type="text" class="form-control" name="customer" value="<?= set_value('customer') ?>" placeholder="Customer Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'customer') : '' ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Product Name</label>
                                    <select name="product_name" class="form-select">
                                        <option value="<?= set_value('product_name') ?>"><?= isset($_POST['product_name']) ? set_value('product_name') : '--Select Product--'; ?> </option>
                                        <?php foreach($product_name as $product): ?>

                                            <option value="<?= $product->id ?>"><?= $product->product_name ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Number of orders</label>
                                    <input type="number" class="form-control" name="number_of_orders" value="<?= set_value('number_of_orders') ?>" placeholder="Quantity here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'number_of_orders') : '' ?></span>
                                </div>
                            </div>
                            <button type="submit" class="col-md-12 btn btn-primary">Add Sales</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>