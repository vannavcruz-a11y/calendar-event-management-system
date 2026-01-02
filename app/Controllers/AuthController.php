<?php namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session
                $sessionData = [
                    'user_id'   => $user['id'],
                    'name'      => $user['name'],
                    'email'     => $user['email'],
                    'role'      => $user['role'],        // important for sidebar
                    'campus_id' => $user['campus_id'] ?? null,
                    'logged_in' => TRUE
                ];
                $session->set($sessionData);

                // Redirect based on role
                if (in_array($user['role'], ['admin', 'usg'])) {
                    return redirect()->to('/usg/dashboard'); // Both admin & usg go here
                } else {
                    return redirect()->to('/campus/'.$user['campus_id']); // campus users
                }

            } else {
                return redirect()->back()->with('error', 'Incorrect password');
            }
        } else {
            return redirect()->back()->with('error', 'Email not found');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
