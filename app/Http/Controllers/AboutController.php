<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        try {
            $team = [
                ['name' => 'Sarah Mitchell', 'role' => 'Founder & Creative Director',  'bio' => 'With over 15 years in luxury event design, Sarah founded HK Rentals to bring world-class rental experiences to the Knoxville community.',                                        'image' => 'team-founder.png',     'email' => 'sarah@skrentals.com'],
                ['name' => 'Emily Rhodes',   'role' => 'Senior Event Coordinator',      'bio' => 'Emily\'s eye for detail and passion for creating perfect moments has helped over 300 couples achieve their dream wedding aesthetic.',                                             'image' => 'team-coordinator.png', 'email' => 'emily@skrentals.com'],
                ['name' => 'James Caldwell', 'role' => 'Logistics & Operations Manager','bio' => 'James ensures every delivery is flawless and every item arrives pristine. His team handles setup and breakdown with white-glove care.',                                         'image' => 'team-logistics.png',   'email' => 'james@skrentals.com'],
            ];

            $milestones = [
                ['year' => '2013', 'title' => 'Founded',       'desc' => 'HK Rentals opened its doors in downtown Knoxville with just 50 rental pieces.'],
                ['year' => '2016', 'title' => 'Expanded',      'desc' => 'Grew our collection to 500+ items and moved into our dedicated showroom space.'],
                ['year' => '2019', 'title' => 'Award Winning', 'desc' => 'Named Best Event Rental Company in Knoxville by East Tennessee Weddings Magazine.'],
                ['year' => '2023', 'title' => '500+ Events',   'desc' => 'Celebrated serving over 500 couples and corporate clients across the region.'],
            ];

            return view('pages.about', compact('team', 'milestones'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('pages.about', ['team' => [], 'milestones' => [], 'error' => 'Could not load page.']);
        }
    }
}
