<?php

namespace Database\Seeders;

use App\Models\ApproachPillar;
use App\Models\ClienteleCriterion;
use App\Models\PrivateInquiry;
use App\Models\RetainerEngagement;
use App\Models\SiteSetting;
use App\Models\SubPage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StonebridgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@stonebridge.com'],
            [
                'name' => 'Carl Malmsten (Admin)',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Site Settings
        $settings = [
            // General / Header
            ['key' => 'brand_name', 'value' => 'STONEBRIDGE ADVISORY', 'group' => 'header', 'label' => 'Brand Name', 'type' => 'text', 'order' => 1],
            ['key' => 'header_cta_text', 'value' => 'PRIVATE INQUIRY', 'group' => 'header', 'label' => 'Header CTA Button Label', 'type' => 'text', 'order' => 2],
            ['key' => 'header_cta_link', 'value' => '#private-inquiry', 'group' => 'header', 'label' => 'Header CTA Button Link', 'type' => 'text', 'order' => 3],

            // Hero Section
            ['key' => 'hero_title', 'value' => "STONEBRIDGE\nADVISORY", 'group' => 'hero', 'label' => 'Hero Main Title', 'type' => 'textarea', 'order' => 10],
            ['key' => 'hero_lead_1', 'value' => 'Confidential advisory relationships for individuals navigating complex personal, relational, family, and leadership demands.', 'group' => 'hero', 'label' => 'Hero Lead Paragraph 1', 'type' => 'textarea', 'order' => 11],
            ['key' => 'hero_lead_2', 'value' => 'Supporting those whose circumstances call for continuity, discretion, and thoughtful guidance.', 'group' => 'hero', 'label' => 'Hero Lead Paragraph 2', 'type' => 'textarea', 'order' => 12],
            ['key' => 'hero_badge', 'value' => 'BY REFERRAL AND LIMITED INVITATION.', 'group' => 'hero', 'label' => 'Hero Invitation Notice', 'type' => 'text', 'order' => 13],
            ['key' => 'hero_cta_text', 'value' => 'PRIVATE INQUIRY', 'group' => 'hero', 'label' => 'Hero CTA Button Label', 'type' => 'text', 'order' => 14],
            ['key' => 'hero_cta_link', 'value' => '#private-inquiry', 'group' => 'hero', 'label' => 'Hero CTA Button Link', 'type' => 'text', 'order' => 15],
            ['key' => 'hero_image', 'value' => '/images/hero-bridge.jpg', 'group' => 'hero', 'label' => 'Hero Background Image', 'type' => 'image', 'order' => 16],

            // The Stonebridge Approach
            ['key' => 'approach_tag', 'value' => 'THE STONEBRIDGE APPROACH', 'group' => 'approach', 'label' => 'Section Category Tag', 'type' => 'text', 'order' => 20],
            ['key' => 'approach_headline', 'value' => 'Meaningful work develops through continuity.', 'group' => 'approach', 'label' => 'Section Main Headline', 'type' => 'textarea', 'order' => 21],

            // Who Stonebridge Serves
            ['key' => 'clientele_tag', 'value' => 'WHO STONEBRIDGE SERVES', 'group' => 'clientele', 'label' => 'Section Category Tag', 'type' => 'text', 'order' => 30],
            ['key' => 'clientele_headline', 'value' => 'Stonebridge may be appropriate for individuals who:', 'group' => 'clientele', 'label' => 'Section Main Headline', 'type' => 'textarea', 'order' => 31],
            ['key' => 'clientele_disclaimer', 'value' => 'Stonebridge is not intended as emergency, crisis, or acute psychiatric care.', 'group' => 'clientele', 'label' => 'Psychiatric / Emergency Disclaimer', 'type' => 'textarea', 'order' => 32],

            // Retainer Relationships
            ['key' => 'retainer_tag', 'value' => 'RETAINER RELATIONSHIPS', 'group' => 'retainer', 'label' => 'Section Category Tag', 'type' => 'text', 'order' => 40],
            ['key' => 'retainer_headline', 'value' => 'Stonebridge operates through a limited number of ongoing advisory relationships.', 'group' => 'retainer', 'label' => 'Section Headline', 'type' => 'textarea', 'order' => 41],
            ['key' => 'retainer_intro', 'value' => 'Engagements may include:', 'group' => 'retainer', 'label' => 'Offerings Intro Label', 'type' => 'text', 'order' => 42],
            ['key' => 'retainer_note', 'value' => 'Investment and availability are discussed privately during the inquiry process.', 'group' => 'retainer', 'label' => 'Investment & Availability Note', 'type' => 'textarea', 'order' => 43],
            ['key' => 'retainer_image', 'value' => '/images/retainer-interior.jpg', 'group' => 'retainer', 'label' => 'Interior Still-Life Image', 'type' => 'image', 'order' => 44],

            // Carl Malmsten
            ['key' => 'founder_tag', 'value' => 'CARL MALMSTEN', 'group' => 'founder', 'label' => 'Section Category Tag', 'type' => 'text', 'order' => 50],
            ['key' => 'founder_headline', 'value' => 'Experience. Perspective. Discretion.', 'group' => 'founder', 'label' => 'Founder Main Headline', 'type' => 'text', 'order' => 51],
            ['key' => 'founder_p1', 'value' => 'Carl Malmsten brings decades of experience supporting individuals, couples, and families through complexity and transition.', 'group' => 'founder', 'label' => 'Biography Paragraph 1', 'type' => 'textarea', 'order' => 52],
            ['key' => 'founder_p2', 'value' => 'His work is characterized by warmth, practical wisdom, and a commitment to developing enduring relationships capable of adapting thoughtfully to the realities of a full and demanding life.', 'group' => 'founder', 'label' => 'Biography Paragraph 2', 'type' => 'textarea', 'order' => 53],
            ['key' => 'founder_p3', 'value' => 'Stonebridge Advisory represents an evolution of this work for a limited number of individuals seeking a more integrated and personalized framework of support.', 'group' => 'founder', 'label' => 'Biography Paragraph 3', 'type' => 'textarea', 'order' => 54],
            ['key' => 'founder_image', 'value' => '/images/carl-malmsten.jpg', 'group' => 'founder', 'label' => 'Portrait Photograph', 'type' => 'image', 'order' => 55],

            // Private Inquiry
            ['key' => 'inquiry_tag', 'value' => 'PRIVATE INQUIRY', 'group' => 'inquiry', 'label' => 'Section Category Tag', 'type' => 'text', 'order' => 60],
            ['key' => 'inquiry_headline', 'value' => 'A private conversation begins here.', 'group' => 'inquiry', 'label' => 'Section Headline', 'type' => 'text', 'order' => 61],
            ['key' => 'inquiry_p1', 'value' => 'Because Stonebridge maintains a limited number of relationships, inquiries are reviewed personally.', 'group' => 'inquiry', 'label' => 'Notice Paragraph 1', 'type' => 'textarea', 'order' => 62],
            ['key' => 'inquiry_p2', 'value' => 'Please share a brief overview of your circumstances and what led you to explore this type of relationship.', 'group' => 'inquiry', 'label' => 'Notice Paragraph 2', 'type' => 'textarea', 'order' => 63],
            ['key' => 'inquiry_disclaimer', 'value' => 'All inquiries are confidential.', 'group' => 'inquiry', 'label' => 'Confidentiality Guarantee', 'type' => 'text', 'order' => 64],
            ['key' => 'inquiry_btn_text', 'value' => 'PRIVATE INQUIRY', 'group' => 'inquiry', 'label' => 'Submit Button Text', 'type' => 'text', 'order' => 65],

            // Footer
            ['key' => 'footer_brand', 'value' => 'STONEBRIDGE ADVISORY', 'group' => 'footer', 'label' => 'Footer Brand Name', 'type' => 'text', 'order' => 70],
            ['key' => 'footer_tagline', 'value' => 'Confidential. Personalized. Enduring.', 'group' => 'footer', 'label' => 'Footer Tagline', 'type' => 'text', 'order' => 71],
            ['key' => 'footer_copyright', 'value' => '© Stonebridge Advisory. All rights reserved.', 'group' => 'footer', 'label' => 'Copyright Statement', 'type' => 'text', 'order' => 72],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // 3. The 5 Approach Pillars
        $pillars = [
            [
                'order' => 1,
                'title' => 'Continuity',
                'description' => 'Meaningful work develops through ongoing relationships, not isolated conversations.',
                'icon_svg' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="18"/><circle cx="24" cy="24" r="11"/><circle cx="24" cy="24" r="4"/><line x1="24" y1="2" x2="24" y2="46"/><line x1="2" y1="24" x2="46" y2="24"/></svg>',
            ],
            [
                'order' => 2,
                'title' => 'Prepared Support',
                'description' => 'Support is most valuable when already established before challenges become urgent.',
                'icon_svg' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="18" cy="24" r="14"/><circle cx="30" cy="24" r="14"/></svg>',
            ],
            [
                'order' => 3,
                'title' => 'Integrated Perspective',
                'description' => 'Personal, relational, family, and professional domains intersect. They are rarely separate.',
                'icon_svg' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="24" cy="38" rx="14" ry="5"/><ellipse cx="24" cy="27" rx="11" ry="4"/><ellipse cx="24" cy="18" rx="8" ry="3.5"/><ellipse cx="24" cy="10" rx="5" ry="2.5"/></svg>',
            ],
            [
                'order' => 4,
                'title' => 'Thoughtful Guidance',
                'description' => 'Perspective, experience, and responsiveness tailored to your circumstances.',
                'icon_svg' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="24" cy="24" r="18"/><circle cx="24" cy="24" r="2"/><line x1="24" y1="6" x2="24" y2="42"/><line x1="6" y1="24" x2="42" y2="24"/><line x1="11" y1="11" x2="37" y2="37"/><line x1="37" y1="11" x2="11" y2="37"/></svg>',
            ],
            [
                'order' => 5,
                'title' => 'Discretion & Trust',
                'description' => 'Confidentiality and discretion create the safety necessary for deeper work.',
                'icon_svg' => '<svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M24 6L8 12V23C8 33 15 40 24 43C33 40 40 33 40 23V12L24 6Z"/><line x1="24" y1="6" x2="24" y2="43"/></svg>',
            ],
        ];

        ApproachPillar::truncate();
        foreach ($pillars as $p) {
            ApproachPillar::create($p);
        }

        // 4. Clientele Criteria (8 Items)
        $criteria = [
            'Carry significant responsibilities',
            'Navigate complex relationships or family dynamics',
            'Face important life transitions or periods of change',
            'Value discretion and privacy',
            'Seek a trusted sounding board for difficult decisions',
            'Appreciate continuity',
            'Desire dedicated availability and responsiveness',
            'Prefer thoughtful guidance over reactive intervention',
        ];

        ClienteleCriterion::truncate();
        foreach ($criteria as $index => $c) {
            ClienteleCriterion::create([
                'text' => $c,
                'order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // 5. Retainer Engagements
        $leftOfferings = [
            'Reserved appointments',
            'Virtual consultations',
            'In-person meetings',
            'Brief communication between meetings',
            'Flexible scheduling',
        ];

        $rightOfferings = [
            'Extended consultations',
            'Focused intensives',
            'Consultation involving significant others',
            'Travel arrangements when circumstances warrant',
        ];

        RetainerEngagement::truncate();
        foreach ($leftOfferings as $idx => $title) {
            RetainerEngagement::create([
                'column_side' => 'left',
                'title' => $title,
                'order' => $idx + 1,
            ]);
        }
        foreach ($rightOfferings as $idx => $title) {
            RetainerEngagement::create([
                'column_side' => 'right',
                'title' => $title,
                'order' => $idx + 1,
            ]);
        }

        // 6. Sub-Pages
        $pages = [
            [
                'slug' => 'discretion-charter',
                'title' => 'Charter of Discretion & Confidentiality',
                'subtitle' => 'Our foundational protocol governing privacy, communications, and client protection.',
                'content' => "At Stonebridge Advisory, confidentiality is not simply an ethical obligation—it is the bedrock upon which high-level advisory relationships are forged.\n\n### Strict Privilege & Anonymity\nEvery engagement is governed by uncompromising non-disclosure standards. Inquiries, meeting records, and personal histories are handled with stringent data partitioning and zero third-party disclosure.\n\n### Direct Principal Contact\nAdvisory relationships are conducted directly with Carl Malmsten. There are no associates, intermediaries, or administrative conduits involved in private dialogues.\n\n### Encrypted & Discreet Channels\nAll digital interactions utilize end-to-end encrypted protocols. When physical consultations are scheduled, locations are chosen to safeguard personal privacy and complete discretion.",
                'meta_description' => 'Stonebridge Advisory Charter of Discretion and Confidentiality.',
                'order' => 1,
            ],
            [
                'slug' => 'engagements',
                'title' => 'Advisory Retainer Engagements',
                'subtitle' => 'The framework, rhythm, and mutual commitments of ongoing counsel.',
                'content' => "Stonebridge maintains intentionally limited active advisory retainers at any given time. This exclusivity guarantees deep contextual familiarity, immediate responsiveness, and unwavering focus on your strategic and personal landscape.\n\n### Core Retainer Dimensions\n- **Reserved Availability**: Dedicated calendar prioritization with guaranteed response windows.\n- **Flexible Modalities**: Seamless blending of scheduled in-depth sessions, ad-hoc sounding board calls, and intensive retreats.\n- **Family & Leadership Alignment**: Thoughtful facilitation when decisions intersect multiple family generations, leadership boards, or key stakeholders.\n\n### Commencing an Engagement\nRetainer agreements are established on an annual or multi-quarter basis following an initial bilateral inquiry dialogue to ensure reciprocal resonance.",
                'meta_description' => 'Details regarding Stonebridge Advisory ongoing retainer relationships and engagement structures.',
                'order' => 2,
            ],
            [
                'slug' => 'philosophy',
                'title' => 'The Stonebridge Philosophy',
                'subtitle' => 'Enduring clarity born from calm perspective, practical wisdom, and human depth.',
                'content' => "Complex lives cannot be navigated with superficial checklists or formulaic coaching. Real challenges require a sounding board that understands both high-stakes decision making and the intricate dynamics of human relationships.\n\n### Continuity Over Crisis\nThe greatest leverage in advisory work occurs before circumstances turn acute. By developing an ongoing, trusted rapport during periods of calm, solutions during moments of transition emerge naturally and thoughtfully.\n\n### Wholeness of Domain\nProfessional duties, personal aspirations, and family bonds continuously influence one another. Stonebridge operates at their intersection.",
                'meta_description' => 'The philosophy, history, and advisory doctrine of Stonebridge Advisory.',
                'order' => 3,
            ]
        ];

        SubPage::truncate();
        foreach ($pages as $p) {
            SubPage::create($p);
        }

        // 7. Seed 1 sample private inquiry for the admin inbox
        PrivateInquiry::truncate();
        PrivateInquiry::create([
            'full_name' => 'Henrik Lindqvist',
            'email' => 'h.lindqvist@crestviewholdings.se',
            'phone' => '+46 8 555 1290',
            'circumstances' => 'Navigating a multi-generational family office leadership transition while managing substantial public enterprise commitments.',
            'motivation' => 'Referred by Marcus V. Seeking an experienced, discreet sounding board for complex governance and personal boundary questions.',
            'status' => 'new',
            'admin_notes' => 'Received via private referral. Reviewing preliminary calendar availability for confidential introduction call.',
        ]);
    }
}
