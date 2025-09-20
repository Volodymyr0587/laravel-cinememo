<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professions = [
            // Development and Pre-Production
            'Executive Producer',
            'Producer',
            'Screenwriter',
            'Development Executive',
            'Casting Director',
            'Director',
            'Production Designer',
            'Storyboard Artist',
            'Concept Artist',
            'Location Manager',

            // Production (On-Set Crew)
            '1st Assistant Director (1st AD)',
            '2nd Assistant Director (2nd AD)',
            'Script Supervisor',
            'Production Manager',
            'Production Coordinator',
            'Production Assistant (PA)',
            'Director of Photography (Cinematographer)',
            'Camera Operator',
            '1st Assistant Camera (Focus Puller)',
            '2nd Assistant Camera (Clapper Loader)',
            'Digital Imaging Technician (DIT)',
            'Gaffer',
            'Key Grip',
            'Art Director',
            'Set Decorator',
            'Props Master',
            'Costume Designer',
            'Key Makeup Artist',
            'Special Effects (SFX) Makeup Artist',
            'Hairstylist',
            'Production Sound Mixer',
            'Boom Operator',
            'Stunt Coordinator',
            'Stunt Performer',

            // Post-Production
            'Editor',
            'Assistant Editor',
            'Colorist',
            'VFX Supervisor',
            'Compositor',
            '3D Modeler',
            'Animator',
            'Matte Painter',
            'Rotoscoping Artist',
            'Supervising Sound Editor',
            'Sound Designer',
            'Dialogue Editor',
            'Foley Artist',
            'Re-recording Mixer',
            'Composer',
            'Music Supervisor',

            // Animation & Anime
            'Voice Actor (Seiyū)',
            'Animation Director',
            'Character Designer',
            'Key Animator',
            'In-betweener',
            'Rigger',
            'Background Artist',
        ];

        foreach ($professions as $profession) {
            Profession::firstOrCreate(['name' => $profession]);
        }
    }
}
