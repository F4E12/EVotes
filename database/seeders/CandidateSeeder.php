<?php

namespace Database\Seeders;

use App\Http\Controllers\CandidateController;
use App\Models\Candidate;
use App\Models\Room;
use Illuminate\Database\Seeder;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = Room::all();

        $candidateTemplates = [
            'BEM President Election 2026' => [
                [
                    'name' => 'Aulia Rahman',
                    'photo_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Building a responsive student government that is transparent, measurable, and focused on academic support for all faculties.',
                    'mission' => 'Launch an open budget dashboard, hold monthly student town halls, establish a cross-faculty mentorship network, and create a rapid response channel for urgent student services.',
                ],
                [
                    'name' => 'Nadine Pramesti',
                    'photo_url' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'A campus culture where leadership is inclusive and every student organization has equal access to development opportunities.',
                    'mission' => 'Standardize event support for student clubs, provide leadership bootcamps each semester, and publish impact reports for all BEM programs and collaborations.',
                ],
                [
                    'name' => 'Rifqi Mahendra',
                    'photo_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Making campus governance data-driven so policies are based on real student feedback and service performance.',
                    'mission' => 'Deploy quarterly student sentiment surveys, set service-level targets for academic administration, and run policy reviews with representatives from each cohort.',
                ],
            ],
            'Computer Science Department Chair Vote' => [
                [
                    'name' => 'Dr. Maya Saputra',
                    'photo_url' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'An adaptive computer science department that aligns curriculum, research, and industry relevance without sacrificing academic depth.',
                    'mission' => 'Refresh core courses every two years, expand lab partnerships with local startups, and fund applied research tracks for final-year students.',
                ],
                [
                    'name' => 'Prof. Arman Wibowo',
                    'photo_url' => 'https://images.unsplash.com/photo-1568602471122-7832951cc4c5?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Positioning the department as a center for trustworthy AI and software engineering excellence in the region.',
                    'mission' => 'Create a secure software engineering studio, establish ethics requirements in all AI courses, and increase publication + patent output through interdisciplinary grants.',
                ],
                [
                    'name' => 'Dr. Kevin Setiawan',
                    'photo_url' => 'https://images.unsplash.com/photo-1542909168-82c3e7fdca5c?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'A student-centered department where career outcomes, teaching quality, and research opportunities grow together.',
                    'mission' => 'Set up structured internship pipelines, improve advisor-to-student ratio, and launch a teaching quality council with transparent course feedback follow-up.',
                ],
            ],
            'Community Innovation Grant Selection' => [
                [
                    'name' => 'Tim SmartWaste Initiative',
                    'photo_url' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Reduce unmanaged waste around campus and nearby neighborhoods through citizen-driven monitoring and education.',
                    'mission' => 'Deploy smart sorting bins in three pilot zones, run school outreach with community leaders, and publish monthly waste reduction metrics accessible to the public.',
                ],
                [
                    'name' => 'Tim Rural Learning Hub',
                    'photo_url' => 'https://images.unsplash.com/photo-1513258496099-48168024aec0?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Closing digital literacy gaps for rural students through affordable, practical, and community-owned learning programs.',
                    'mission' => 'Set up weekend learning hubs, train volunteer mentors, provide modular learning kits, and partner with local schools for long-term implementation.',
                ],
                [
                    'name' => 'Tim FreshMarket Connect',
                    'photo_url' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Strengthening local food ecosystems by connecting small farmers directly with urban consumers and micro-businesses.',
                    'mission' => 'Build a transparent ordering platform, run fair-pricing workshops, and launch weekly pilot distribution routes with farmer co-ops and student volunteers.',
                ],
            ],
            'School Council Representative 2026' => [
                [
                    'name' => 'Salma Nur Azizah',
                    'photo_url' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'A school council that is present, accountable, and actively bridges communication between students and school leadership.',
                    'mission' => 'Publish monthly council outcomes, establish issue-tracking for student reports, and set response timelines for policy requests and facility concerns.',
                ],
                [
                    'name' => 'Daffa Ramadhan',
                    'photo_url' => 'https://images.unsplash.com/photo-1541534401786-2077eed87a72?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Creating a fair and transparent school environment where student wellbeing and academic excellence are equally prioritized.',
                    'mission' => 'Expand peer counseling, improve class scheduling transparency, and coordinate quarterly feedback sessions with students, parents, and teachers.',
                ],
                [
                    'name' => 'Nabila Putri Handayani',
                    'photo_url' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=700&q=80',
                    'vision' => 'Transforming the council into a strategic platform for student-led initiatives with measurable outcomes.',
                    'mission' => 'Allocate project-based council budgets, mentor student proposal teams, and publish impact scorecards every term.',
                ],
            ],
        ];

        if ($rooms->isEmpty()) {
            $this->command->info('No rooms found. Please run RoomSeeder first.');
            return;
        }

        foreach ($rooms as $room) {
            $candidates = $candidateTemplates[$room->title] ?? [];

            foreach ($candidates as $candidateData) {
                $candidate = Candidate::firstOrNew([
                    'room_id' => $room->id,
                    'name' => $candidateData['name'],
                ]);

                if (!$candidate->exists) {
                    $candidate->candidate_id = CandidateController::generateCandidateID();
                }

                $candidate->fill([
                    'photo_url' => $candidateData['photo_url'],
                    'vision' => $candidateData['vision'],
                    'mission' => $candidateData['mission'],
                ]);

                $candidate->save();
            }
        }
    }
}
