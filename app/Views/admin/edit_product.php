<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Edit Product <?= esc(ucwords($product->product_name)) ?></h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 offset-1">
                            <img src="/uploads/<?= $product->product_image ?>" alt="" width="230" height="200">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/product" class="btn btn-primary float-end">Back</a>
                        <h5 class="card-title mb-0">Edit Product</h5>
                    </div>
                    <div class="card-body">
                        <form action="/product/update/<?= $product->id ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT" />
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="firstname" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" value="<?= esc($product->product_name) ?>" placeholder="Product Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'product_name') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="exampleInputPassword1" class="form-label">Category Name</label>
                                    <select name="category" class="form-select">
                                        <option value="<?= esc($product->category) ?>"><?= esc($product->category) ?> </option>
                                        <?php foreach($categories as $category): ?>

                                            <option value="<?= $category->category_name ?>"><?= $category->category_name ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'position') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="contact" class="form-label">Product Quantity</label>
                                    <input type="number" class="form-control" name="product_qty" value="<?= esc($product->product_qty) ?>" placeholder="Quantity here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'product_qty') : '' ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label for="contact" class="form-label">Supplier Name</label>
                                    <input type="text" class="form-control" name="supplier" value="<?= esc($product->supplier) ?>" placeholder="Supplier Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'supplier') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="contact" class="form-label">Your Buying Price</label>
                                    <input type="number" class="form-control" name="buying_price" value="<?= esc($product->buying_price) ?>" placeholder="Buying Price here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'buying_price') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label for="contact" class="form-label">Your Selling Price</label>
                                    <input type="number" class="form-control" name="selling_price" value="<?= esc($product->selling_price) ?>" placeholder="Selling Price here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'selling_price') : '' ?></span>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="lastname" class="form-label">Product Description</label>
                                    <textarea name="description" id="" class="form-control"><?= esc($product->description) ?></textarea>
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'description') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="" class="text-muted">Upload product image</label>
                                    <input type="file" class="form-control mt-1" name="product_image" accept="/images">
                                </div>
                            </div>
                            <button type="submit" class="col-md-12 btn btn-primary">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>