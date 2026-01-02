<?php
$users = [
    'USG Admin' => 'password123',
    'Campus Org User' => 'orgpassword',
    'Event Handler' => 'handlerpass'
];

foreach ($users as $name => $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    echo "User: $name\n";
    echo "Password: $password\n";
    echo "Hashed: $hash\n\n";
}
