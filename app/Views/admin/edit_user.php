<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Edit User <?= esc(ucfirst($user->first_name)) ?></h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 offset-2">
                            <img src="/uploads/<?= $user->profile ?>" class="rounded-circle" alt="" width="190" height="190">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <a href="/admin/users" class="btn btn-primary float-end">Back</a>
                        <h5 class="card-title mb-0">Edit User</h5>
                    </div>
                    <div class="card-body">
                        <form action="/user/update/<?= $user->id ?>" method="POST" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <input type="hidden" name="_method" value="PUT" />
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="firstname" class="form-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?= esc($user->first_name) ?>">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'firstname') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="lastname" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?= esc($user->last_name) ?>">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'lastname') : '' ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="contact" class="form-label">Contact Number</label>
                                    <input type="number" class="form-control" name="contact" value="<?= esc($user->contact) ?>">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'contact') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="exampleInputPassword1" class="form-label">Postion</label>
                                    <select name="position" class="form-select">
                                        <option value="<?= $user->position ?>"><?= ucfirst($user->position) ?> </option>
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
                                    <input type="text" class="form-control" name="email" value="<?= esc($user->email) ?>">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'email') : '' ?></span>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" name="password" placeholder="Password (leave empty to keep old password)">
                                    <span class="text-danger text-sm"><?= isset($validation) ? show_error($validation, 'password') : '' ?></span>
                                </div>
                            </div>
                            <label for="" class="text-muted">Update user profile</label>
                            <input type="file" class="form-control mt-1" name="image" accept="/images">

                            <button type="submit" class="col-md-12 btn btn-primary mt-3">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?= $this->endSection() ?>