<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::query()->pluck('id');

        if ($authors->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }

        $roomsByTitle = Room::query()->get()->keyBy('title');

        $articles = [
            [
                'title' => 'Election Committee Confirms Final Candidate List for BEM President 2026',
                'content' => '<p>The election committee has officially confirmed three candidate teams for the BEM President Election 2026 after completing administrative verification and public document review. This marks the beginning of the campaign period, where each team is expected to present realistic policy targets and implementation timelines.</p><p>According to the committee spokesperson, all candidates submitted complete policy documents covering student services, transparency, and cross-faculty collaboration. The committee also introduced a public dashboard where students can compare candidate programs side by side.</p><p>Debate sessions will be held over two evenings in the main auditorium and streamed online for students who cannot attend in person. Voting opens at 08:00 and closes at 17:00 on the final day. Students are reminded to verify their eligibility before entering the voting room.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => 'BEM President Election 2026',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Public Debate Highlights Data Transparency and Student Welfare Plans',
                'content' => '<p>The first public debate for the BEM President Election focused on two central themes: budget transparency and student welfare services. Candidates proposed a range of initiatives, from open budget publication to mental health support expansion and emergency academic assistance.</p><p>Audience engagement was notably high, with students submitting more than 120 questions through the official moderation portal. The strongest responses came from candidates who provided measurable targets, including quarterly reporting commitments and concrete implementation milestones.</p><p>The election committee encouraged voters to review each team\'s written platform before making a decision. A second debate will concentrate on organizational reform, faculty collaboration, and accountability mechanisms.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f8e1c1?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => 'BEM President Election 2026',
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Department Chair Candidates Present Curriculum Reform Roadmaps',
                'content' => '<p>Candidates for the Computer Science Department Chair position presented their curriculum reform roadmaps in front of faculty, student representatives, and industry advisors. The session emphasized balancing theoretical rigor with practical industry-aligned competencies.</p><p>Key themes included secure software engineering, AI ethics integration, and stronger internship pathways for final-year students. Several proposals included regular syllabus refresh cycles and partnerships with external laboratories for applied project supervision.</p><p>The voting committee confirmed that official ballots will open next week. Eligible voters are encouraged to review each roadmap in detail, particularly the sections on quality assurance and learning outcome measurement.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1488190211105-8b0e65b80b4e?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => 'Computer Science Department Chair Vote',
                'published_at' => now()->subHours(30),
            ],
            [
                'title' => 'Innovation Grant Finalists Pitch Community-Impact Programs',
                'content' => '<p>Finalists in the Community Innovation Grant Selection delivered strong project pitches centered on measurable social outcomes. Proposed initiatives addressed waste management, rural digital literacy, and local food supply chain efficiency.</p><p>The panel evaluated each team based on impact potential, implementation readiness, and sustainability after initial grant funding. Student observers praised the quality of field research and stakeholder engagement strategies presented by all teams.</p><p>Voting has now closed, and final results will be published after verification. The winning project will receive funding support, mentorship, and a six-month implementation review partnership with the community office.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => 'Community Innovation Grant Selection',
                'published_at' => now()->subWeeks(1),
            ],
            [
                'title' => 'School Council Election Introduces New Response-Time Accountability Policy',
                'content' => '<p>This year\'s School Council Representative election includes a new accountability commitment: public response-time targets for student reports. Candidates have agreed to publish monthly updates on follow-up status for policy and facility requests.</p><p>Education observers noted that this approach could significantly improve trust in council operations, especially when combined with transparent issue-tracking dashboards. Students can monitor both incoming requests and resolved cases through the council portal.</p><p>Election organizers hope the new policy framework will set a stronger standard for student leadership governance and create a more responsive communication loop between students and school management.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => 'School Council Representative 2026',
                'published_at' => now()->subHours(12),
            ],
            [
                'title' => 'How to Evaluate Candidate Programs Before You Vote',
                'content' => '<p>Many voters focus on slogans, but strong election decisions should be based on feasibility and accountability. A practical way to evaluate programs is to ask three questions: Is the target clear? Is there a realistic timeline? Is there a mechanism to monitor progress?</p><p>Voters are encouraged to compare candidate plans against past organizational performance and available resources. Proposals with measurable indicators and periodic reporting structures are generally easier to execute and audit publicly.</p><p>As voting participation increases, informed decision-making becomes more important. Reviewing official policy documents and attending candidate forums can help ensure votes are based on substance rather than campaign visibility.</p>',
                'thumbnail_url' => 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?auto=format&fit=crop&w=1200&q=80',
                'related_room_title' => null,
                'published_at' => now()->subDays(3),
            ],
        ];

        foreach ($articles as $index => $articleData) {
            $room = $articleData['related_room_title']
                ? $roomsByTitle->get($articleData['related_room_title'])
                : null;

            Article::updateOrCreate(
                ['title' => $articleData['title']],
                [
                    'author_id' => $authors[$index % $authors->count()],
                    'related_room_id' => $room?->id,
                    'content' => $articleData['content'],
                    'thumbnail_url' => $articleData['thumbnail_url'],
                    'published_at' => $articleData['published_at'],
                ]
            );
        }
    }
}
