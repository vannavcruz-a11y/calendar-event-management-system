
<!-- Main Content -->
<div class="layout">
    <div class="content" id="content">
       
    </div>
</div>
<!-- Footer -->
<footer id="footer">
    <p>&copy; <?= date('Y') ?> SKSU Calendar System. All Rights Reserved.</p>
</footer>

<script>
    // Sidebar collapse
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    const header = document.getElementById('header');
    const footer = document.getElementById('footer');
    const collapseBtn = document.getElementById('collapseBtn');

    collapseBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('collapsed');
        header.classList.toggle('collapsed');
        footer.classList.toggle('collapsed');
    });

    // Dark mode toggle
    const darkToggle = document.getElementById('darkToggle');
    darkToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
    });

    // Load saved dark mode preference
    if(localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
    }
</script>

</body>
</html>