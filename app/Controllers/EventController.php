<?php namespace App\Controllers;

use App\Models\EventModel;

class EventController extends BaseController
{
    /* ===================== CREATE ===================== */
    public function create($campusId)
    {
        $session = session();

        if ($session->get('role') === 'org' && $session->get('campus_id') != $campusId) {
            return redirect()->back()->with('error', 'You can only create events for your assigned campus.');
        }

        return view('events/create', ['campus_id' => $campusId]);
    }

    public function store()
    {
        $session    = session();
        $eventModel = new EventModel();
        $campusId   = $this->request->getPost('campus_id');

        if ($session->get('role') === 'org' && $session->get('campus_id') != $campusId) {
            return redirect()->back()->with('error', 'Unauthorized campus.');
        }

        $posterFile = $this->request->getFile('poster');
        $posterName = null;

        if ($posterFile && $posterFile->isValid() && !$posterFile->hasMoved()) {
            $posterName = $posterFile->getRandomName();
            $posterFile->move(WRITEPATH . 'uploads/events', $posterName);
        }

        $eventModel->insert([
            'campus_id'   => $campusId,
            'org_name'    => $this->request->getPost('org_name'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'time_in'     => $this->request->getPost('time_in'),
            'time_out'    => $this->request->getPost('time_out'),
            'location'    => $this->request->getPost('location'),
            'poster'      => $posterName,
            'created_by'  => $session->get('name')
        ]);

        return redirect()->to('/campus/'.$campusId)->with('success', 'Event created successfully.');
    }

    /* ===================== EDIT ===================== */
    public function edit($id)
    {
        $eventModel = new EventModel();
        $session    = session();

        $event = $eventModel->find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if (
            $session->get('role') === 'org' &&
            $session->get('campus_id') != $event['campus_id']
        ) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        return view('events/edit', ['event' => $event]);
    }

    /* ===================== UPDATE ===================== */
    public function update($id)
    {
        $eventModel = new EventModel();
        $session    = session();

        $event = $eventModel->find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if (
            $session->get('role') === 'org' &&
            $session->get('campus_id') != $event['campus_id']
        ) {
            return redirect()->back()->with('error', 'Unauthorized update.');
        }

        $posterFile = $this->request->getFile('poster');
        $posterName = $event['poster'];

        if ($posterFile && $posterFile->isValid() && !$posterFile->hasMoved()) {
            $posterName = $posterFile->getRandomName();
            $posterFile->move(WRITEPATH . 'uploads/events', $posterName);
        }

        $eventModel->update($id, [
            'org_name'    => $this->request->getPost('org_name'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'date'        => $this->request->getPost('date'),
            'time_in'     => $this->request->getPost('time_in'),
            'time_out'    => $this->request->getPost('time_out'),
            'location'    => $this->request->getPost('location'),
            'poster'      => $posterName
        ]);

        return redirect()->to('/campus/'.$event['campus_id'])
            ->with('success', 'Event updated successfully.');
    }

    /* ===================== DELETE ===================== */
    public function delete($id)
    {
        $eventModel = new EventModel();
        $session    = session();

        $event = $eventModel->find($id);
        if (!$event) {
            return redirect()->back()->with('error', 'Event not found.');
        }

        if (
            !in_array($session->get('role'), ['admin', 'usg']) &&
            $session->get('campus_id') != $event['campus_id']
        ) {
            return redirect()->back()->with('error', 'Unauthorized delete.');
        }

        $eventModel->delete($id);

        return redirect()->to('/campus/'.$event['campus_id'])
            ->with('success', 'Event deleted successfully.');
    }
}
