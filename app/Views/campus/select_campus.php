<?= $this->include('templates/header') ?>
<h2>Select Your Campus</h2>
<div class="campus-buttons">
    <?php foreach($campuses as $campus): ?>
        <a class="campus-btn" href="<?= base_url('campus/'.$campus['id']) ?>"><?= $campus['name'] ?></a>
    <?php endforeach; ?>
</div>
<?= $this->include('templates/footer') ?>
