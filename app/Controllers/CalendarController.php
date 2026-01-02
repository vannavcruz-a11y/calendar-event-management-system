<?php namespace App\Controllers;

use App\Models\EventModel;
use App\Models\CampusModel;

class CalendarController extends BaseController
{
    /**
     * Show the calendar page (hand-coded PHP calendar)
     */
    public function index()
    {
        $campusModel = new CampusModel();
        $campuses = $campusModel->findAll();

        $eventModel = new EventModel();
        $events = $eventModel->findAll(); // fetch all events

        // Pass both campuses and events to the view
        return view('calendar_view', [
            'campuses' => $campuses,
            'events'   => $events
        ]);
    }

    /**
     * Provide events as JSON for FullCalendar JS
     */
    public function events($campus_id = null)
    {
        $eventModel = new EventModel();

        // Fetch events by campus or all
        if ($campus_id) {
            $events = $eventModel->where('campus_id', $campus_id)->findAll();
        } else {
            $events = $eventModel->findAll();
        }

        // Assign colors to orgs
        $colors = [
            'Science Club' => '#3498db',
            'Arts Society' => '#e67e22',
            'Sports Org'   => '#27ae60',
            'Admin Event'  => '#9b59b6',
            'Default'      => '#95a5a6'
        ];

        // Format events for FullCalendar
        $formatted = [];
        foreach ($events as $event) {
            $time_in = !empty($event['time_in']) ? $event['time_in'] : '08:00:00';
            $time_out = !empty($event['time_out']) ? $event['time_out'] : '23:59:00';

            $eventColor = $colors[$event['org_name']] ?? $colors['Default'];

            $formatted[] = [
                'id'          => $event['id'],
                'title'       => $event['title'],
                'start'       => $event['date'] . 'T' . $time_in,
                'end'         => $event['date'] . 'T' . $time_out,
                'description' => $event['description'] ?? '',
                'location'    => $event['location'] ?? '',
                'color'       => $eventColor
            ];
        }

        return $this->response->setJSON($formatted);
    }
}
