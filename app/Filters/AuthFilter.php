<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // ❌ User not logged in
        if (! $session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        // ✅ Role-based access
        if ($arguments) {
            $userRole = $session->get('role');
            if (! in_array($userRole, $arguments)) {
                // Redirect to appropriate dashboard
                if ($userRole === 'admin') {
                    return redirect()->to('/dashboard/admin')->with('error', 'Access denied for this page.');
                } elseif ($userRole === 'student') {
                    return redirect()->to('/dashboard/student')->with('error', 'Access denied for this page.');
                } else {
                    return redirect()->to('/login')->with('error', 'Access denied.');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed here
    }
}
