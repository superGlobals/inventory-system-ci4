<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0 offset-3">

        <h1 class="h3 mb-3">Add category page</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/category" class="btn btn-primary float-end">Back</a>
                        <h5 class="card-title mb-0">Add Category</h5>
                    </div>
                    <div class="card-body">
                        <form action="/category/store" method="POST">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="mb-3">
                                    <label for="firstname" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" value="<?= set_value('category_name') ?>" placeholder="Category Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'category_name') : '' ?></span>
                                </div>
                                <div class="mb-3">
                                    <label for="lastname" class="form-label">Category Description</label>
                                    <textarea name="description" id="" class="form-control"><?= set_value('description') ?></textarea>
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'description') : '' ?></span>
                                </div>
                            </div>
                            <button type="submit" class="col-md-12 btn btn-primary">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>