<?= $this->include('templates/header') ?>
<div class="content">
    <div class="card" style="max-width:600px; margin:0 auto; padding:25px; background:#fff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="margin-bottom:20px; color:#003366;">
            <i class="fa-solid fa-user-plus"></i> Add Account for <?= esc($campus['campus_name'] ?? $campus['name'] ?? 'Unnamed Campus') ?>
        </h2>

        <!-- Display flash messages -->
        <?php if(session()->getFlashdata('error')): ?>
            <div style="color:#cc0000; background:#ffe5e5; padding:10px 15px; border-radius:5px; margin-bottom:15px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php elseif(session()->getFlashdata('success')): ?>
            <div style="color:#155724; background:#d4edda; padding:10px 15px; border-radius:5px; margin-bottom:15px;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('campus/'.$campus['id'].'/store-account') ?>" method="post">
            <div style="margin-bottom:15px;">
                <label style="font-weight:bold; color:#333;">Name</label>
                <input type="text" name="name" required placeholder="Enter full name" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="font-weight:bold; color:#333;">Email</label>
                <input type="email" name="email" required placeholder="Enter email address" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <div style="margin-bottom:15px;">
                <label style="font-weight:bold; color:#333;">Password</label>
                <input type="password" name="password" required placeholder="Enter password" style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
            </div>

            <button type="submit" style="padding:12px 20px; background:#28a745; color:#fff; font-weight:bold; border:none; border-radius:8px; cursor:pointer; transition:0.3s;">
                <i class="fa-solid fa-user-plus"></i> Add Account
            </button>
        </form>
    </div>
</div>

<!-- Optional: Hover and focus effects -->
<style>
    .content button:hover {
        background:#218838;
    }
    .content input:focus {
        border-color:#003366;
        outline:none;
        box-shadow:0 0 5px rgba(0,51,102,0.3);
    }
</style>

<?= $this->include('templates/footer') ?>
