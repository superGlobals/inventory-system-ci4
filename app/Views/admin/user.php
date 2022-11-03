<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Users Page</h1>

        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <?php if(session('loggedUserRole') == 'admin'): ?>
                        <a href="/admin/add_user" class="btn btn-primary float-end">New User</a>
                        <?php endif; ?>
                        <h5 class="card-title mb-0">Users Table</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Profile</th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Contact #</th>
                                        <th>Postition</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $user): ?>
                                    <tr>
                                        <td><img src="<?= base_url() ?>/uploads/<?= $user->profile ?>" class="rounded-circle" width="70" height="70"></td>
                                        <td><?= $user->user_id ?></td>
                                        <td><?= esc(ucfirst($user->first_name)) ?> <?= esc(ucfirst($user->last_name)) ?></td>
                                        <td><?= esc($user->email) ?></td>
                                        <td><?= esc($user->contact) ?></td>
                                        <td><?= esc(ucfirst($user->position)) ?></td>
                                        <td>
                                            <a href="/admin/edit_user/<?= $user->id ?>" class="btn btn-success">Edit</a>
                                            <button type="button" class="confirm_del btn btn-danger" value="<?= $user->id ?>">Delete</button>
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
                text: "User info will be deleted permanently!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) 
                {
                    $.ajax({
                        url: "/user/delete/"+id,
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