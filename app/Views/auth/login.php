<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Calendar Events Management</title>
<style>
/* Center the container on the page */
body {
    margin: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f2f5;
    font-family: Arial, sans-serif;
}

/* Container styling */
.login-container {
    display: flex;
    width: 700px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

/* Left panel */
.login-left {
    background: linear-gradient(135deg, #4a90e2, #357ab8);
    color: white;
    padding: 40px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center; /* Center content horizontally */
    text-align: center;
}

.login-left h2 {
    font-size: 28px;
    margin: 0 0 20px 0;
}

.login-left .logo-container img {
    width: 120px; /* Adjust logo size */
    height: auto;
    border-radius: 50%;
    margin-top: 10px;
}

/* Right panel */
.login-right {
    background: #fff;
    padding: 40px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.login-right h2 {
    margin-bottom: 20px;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
}

.login-right form {
    display: flex;
    flex-direction: column;
}

.login-right input {
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.login-right button {
    padding: 12px;
    background-color: #4a90e2;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.3s;
}

.login-right button:hover {
    background-color: #357ab8;
}

.login-right .error {
    color: red;
    margin-bottom: 10px;
    font-size: 14px;
    text-align: center;
}
</style>
</head>
<body>

<div class="login-container">
    <!-- Left side: title + logo -->
    <div class="login-left">
        <h2>Calendar Events Management</h2>
        <div class="logo-container">
            <img src="<?= base_url('/usg_logo.jpg') ?>" alt="USG Logo">
        </div>
    </div>

    <!-- Right side: login form -->
    <div class="login-right">
        <h2>Login</h2>

        <?php if(session()->getFlashdata('error')): ?>
            <p class="error"><?= session()->getFlashdata('error') ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url('login') ?>">
            <input type="email" name="email" placeholder="SKSU Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>

</body>
</html>
