<?php namespace App\Controllers;

use App\Models\CampusModel;
use App\Models\EventModel;
use App\Models\UserModel;

class CampusController extends BaseController
{
    public function dashboard($campusId)
    {
        $campusModel = new CampusModel();
        $eventModel = new EventModel();

        $campus = $campusModel->find($campusId); // current campus
        $events = $eventModel->where('campus_id', $campusId)->findAll();
        $campuses = $campusModel->findAll(); // all campuses for buttons

        return view('campus/dashboard', [
            'campus' => $campus,
            'events' => $events,
            'campuses' => $campuses // pass it here
        ]);
    }

    public function createEvent($campusId)
    {
        $campusModel = new CampusModel();
        $campus = $campusModel->find($campusId);

        return view('campus/create_event', [
            'campus' => $campus
        ]);
    }

    public function storeEvent()
    {
        $eventModel = new EventModel();

        $data = [
            'campus_id' => $this->request->getPost('campus_id'),
            'org_name' => $this->request->getPost('org_name'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date' => $this->request->getPost('date'),
            'time' => $this->request->getPost('time'),
            'location' => $this->request->getPost('location'),
            'poster' => null // optional: handle file upload separately
        ];

        $eventModel->insert($data);

        return redirect()->to('/campus/'.$data['campus_id']);
    }

    // ================= Add Account Methods =================

    public function addAccount($campusId)
{
    $campusModel = new CampusModel();
    $campus = $campusModel->find($campusId);

    if(!$campus) {
        return redirect()->back()->with('error', 'Campus not found.');
    }

    // Only admin or USG can access
    if(!in_array(session()->get('role'), ['admin','usg'])) {
        return redirect()->back()->with('error', 'Unauthorized access.');
    }

    $data['campus'] = $campus;
    $data['title'] = 'Add Account - ' . ($campus['campus_name'] ?? $campus['name'] ?? 'Unnamed Campus');
    return view('campus/add_account', $data);
}
    public function storeAccount($campusId)
{
    $userModel = new UserModel();

    // Only admin or USG can perform this action
    if(!in_array(session()->get('role'), ['admin','usg'])) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Validate input (optional but recommended)
    $validation = $this->validate([
        'name' => 'required',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]'
    ]);

    if(!$validation) {
        return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
    }

    // Insert user for this campus
    $data = [
        'name' => $this->request->getPost('name'),
        'email' => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role' => 'org',   // default role for campus accounts
        'campus_id' => $campusId
    ];

    $userModel->insert($data);

    return redirect()->to('/campus/'.$campusId.'/add-account')->with('success', 'Account created successfully.');
}
}
