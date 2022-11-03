<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Add user page</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 offset-2">
                            <img src="<?= base_url('uploads/user_male.jpg') ?>" class="rounded-circle" alt="" width="190" height="190">
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/users" class="btn btn-primary float-end">Back</a>
                        <h5 class="card-title mb-0">Add User</h5>
                    </div>
                    <div class="card-body">
                        <form action="/user/store" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?= set_value('firstname') ?>" placeholder="First Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'firstname') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?= set_value('lastname') ?>" placeholder="Last Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'lastname') : '' ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="number" class="form-control" name="contact" value="<?= set_value('contact') ?>" placeholder="Last Name here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'contact') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Postion</label>
                                    <select name="position" class="form-select">
                                        <option value="<?= set_value('position') ?>"><?= isset($_POST['position']) ? set_value('position') : '--Select Postion--'; ?> </option>
                                        <option value="admin">Admin</option>
                                        <option value="employee">Employee</option>
                                        <option value="user">User</option>
                                    </select>
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'position') : '' ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?= set_value('email') ?>" placeholder="Email here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'email') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" value="<?= set_value('password') ?>" placeholder="Password here...">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'password') : '' ?></span>
                                </div>
                            </div>
                            <label for="" class="text-muted">Upload user profile</label>
                            <input type="file" class="form-control mt-1" name="image" accept="/images">

                            <button type="submit" class="col-md-12 btn btn-primary mt-3">Add User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>