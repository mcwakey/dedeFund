<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\InterventionArea;
use App\Models\Post;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'DedeFund Admin',
            'email' => 'admin@dedefund.local',
            'password' => 'password',
            'role' => 'super_admin',
        ]);

        $areas = collect([
            [
                'icon' => 'Women',
                'color' => 'emerald',
                'fr' => ['name' => 'Promotion de la femme', 'slug' => 'promotion-de-la-femme', 'summary' => 'Dignite, autonomisation et entrepreneuriat feminin.', 'body' => 'Actions pour les droits, les competences, la protection et l autonomie economique des femmes.'],
                'en' => ['name' => 'Women empowerment', 'slug' => 'women-empowerment', 'summary' => 'Dignity, empowerment, and women entrepreneurship.', 'body' => 'Programs for rights, skills, protection, and economic autonomy for women.'],
            ],
            [
                'icon' => 'Education',
                'color' => 'blue',
                'fr' => ['name' => 'Education et enfance', 'slug' => 'education-et-enfance', 'summary' => 'Scolarisation, protection et formation des enfants vulnerables.', 'body' => 'Soutien aux enfants, aux etudiants meritants, a la formation professionnelle et aux infrastructures educatives.'],
                'en' => ['name' => 'Education and children', 'slug' => 'education-and-children', 'summary' => 'Schooling, protection, and training for vulnerable children.', 'body' => 'Support for children, deserving students, vocational training, and education infrastructure.'],
            ],
            [
                'icon' => 'Health',
                'color' => 'sky',
                'fr' => ['name' => 'Sante et protection sociale', 'slug' => 'sante-protection-sociale', 'summary' => 'Acces aux soins, prevention et protection communautaire.', 'body' => 'Promotion de la sante, mutuelles, infrastructures sanitaires et education a la prevention.'],
                'en' => ['name' => 'Health and social protection', 'slug' => 'health-social-protection', 'summary' => 'Access to care, prevention, and community protection.', 'body' => 'Health promotion, community insurance, health infrastructure, and prevention education.'],
            ],
            [
                'icon' => 'Finance',
                'color' => 'amber',
                'fr' => ['name' => 'Finance sociale et solidaire', 'slug' => 'finance-sociale-solidaire', 'summary' => 'Microfinance inclusive et accompagnement des microentrepreneurs.', 'body' => 'Appui aux institutions solidaires, digitalisation, audits et renforcement des capacites.'],
                'en' => ['name' => 'Social and solidarity finance', 'slug' => 'social-solidarity-finance', 'summary' => 'Inclusive microfinance and support for microentrepreneurs.', 'body' => 'Support for solidarity finance institutions, digitization, audits, and capacity building.'],
            ],
            [
                'icon' => 'Climate',
                'color' => 'lime',
                'fr' => ['name' => 'Environnement et climat', 'slug' => 'environnement-climat', 'summary' => 'Initiatives vertes et resilience climatique.', 'body' => 'Projets communautaires pour la protection de l environnement et la resilience en milieu rural.'],
                'en' => ['name' => 'Environment and climate', 'slug' => 'environment-climate', 'summary' => 'Green initiatives and climate resilience.', 'body' => 'Community projects for environmental protection and rural resilience.'],
            ],
        ])->map(function (array $data, int $index) {
            $area = InterventionArea::create([
                'icon' => $data['icon'],
                'color' => $data['color'],
                'sort_order' => $index + 1,
            ]);

            foreach (['fr', 'en'] as $locale) {
                $area->translations()->create(['locale' => $locale] + $data[$locale]);
            }

            return $area;
        });

        $projects = [
            [
                'area' => 0,
                'location' => 'Togo',
                'target_amount' => 65000,
                'raised_amount' => 12500,
                'image' => 'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?auto=format&fit=crop&w=1200&q=80',
                'fr' => ['title' => 'Nyonu Zazin', 'slug' => 'nyonu-zazin', 'summary' => 'Appui technique et financier aux femmes pauvres et vulnerables.', 'description' => 'Nyonu Zazin accompagne des femmes en situation de vulnerabilite avec des formations, du suivi et un appui financier adapte.', 'beneficiaries' => 'Femmes pauvres et vulnerables.', 'general_objective' => 'Renforcer l autonomie sociale et economique des femmes.', 'expected_impact' => 'Augmentation des revenus, dignite renforcee et reduction des vulnerabilites.'],
                'en' => ['title' => 'Nyonu Zazin', 'slug' => 'nyonu-zazin', 'summary' => 'Technical and financial support for poor and vulnerable women.', 'description' => 'Nyonu Zazin supports vulnerable women with training, mentoring, and adapted financial support.', 'beneficiaries' => 'Poor and vulnerable women.', 'general_objective' => 'Strengthen women social and economic autonomy.', 'expected_impact' => 'Increased income, stronger dignity, and reduced vulnerability.'],
            ],
            [
                'area' => 1,
                'location' => 'West Africa',
                'target_amount' => 90000,
                'raised_amount' => 22000,
                'image' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?auto=format&fit=crop&w=1200&q=80',
                'fr' => ['title' => 'Dedesco', 'slug' => 'dedesco', 'summary' => 'Scolarisation, education et formation professionnelle des enfants et jeunes vulnerables.', 'description' => 'Dedesco soutient la scolarisation, les fournitures, les formations et l orientation professionnelle des jeunes.', 'beneficiaries' => 'Enfants et jeunes vulnerables.', 'general_objective' => 'Permettre a des jeunes vulnerables d apprendre et de construire un avenir digne.', 'expected_impact' => 'Maintien scolaire, competences professionnelles et meilleure insertion.'],
                'en' => ['title' => 'Dedesco', 'slug' => 'dedesco', 'summary' => 'Schooling, education, and vocational training for vulnerable children and youth.', 'description' => 'Dedesco supports schooling, supplies, training, and career orientation for young people.', 'beneficiaries' => 'Vulnerable children and youth.', 'general_objective' => 'Enable vulnerable youth to learn and build a dignified future.', 'expected_impact' => 'School retention, vocational skills, and better social integration.'],
            ],
            [
                'area' => 4,
                'location' => 'Mission Tove, Togo',
                'target_amount' => 175000,
                'raised_amount' => 30000,
                'image' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=1200&q=80',
                'fr' => ['title' => 'Riziculture irriguee a Mission Tove', 'slug' => 'riziculture-irriguee-mission-tove', 'summary' => 'Production de riz biologique avec un financement recherche de 175 000 dollars.', 'description' => 'Ce projet vise a developper une production locale de riz biologique grace a l irrigation et a l organisation communautaire.', 'beneficiaries' => 'Producteurs ruraux, familles et communautes locales.', 'general_objective' => 'Stimuler la production agricole durable et les revenus locaux.', 'expected_impact' => 'Securite alimentaire, emplois locaux et pratiques agricoles durables.'],
                'en' => ['title' => 'Irrigated rice farming in Mission Tove', 'slug' => 'irrigated-rice-farming-mission-tove', 'summary' => 'Organic rice production seeking 175,000 dollars in funding.', 'description' => 'This project develops local organic rice production through irrigation and community organization.', 'beneficiaries' => 'Rural producers, families, and local communities.', 'general_objective' => 'Boost sustainable agricultural production and local income.', 'expected_impact' => 'Food security, local jobs, and sustainable agricultural practices.'],
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'intervention_area_id' => $areas[$projectData['area']]->id,
                'location' => $projectData['location'],
                'target_amount' => $projectData['target_amount'],
                'raised_amount' => $projectData['raised_amount'],
                'currency' => 'USD',
                'status' => 'open',
                'featured_image' => $projectData['image'],
                'is_featured' => true,
                'is_published' => true,
                'published_at' => now(),
                'created_by' => $admin->id,
            ]);

            foreach (['fr', 'en'] as $locale) {
                $project->translations()->create([
                    'locale' => $locale,
                    'meta_title' => $projectData[$locale]['title'].' - DedeFund',
                    'meta_description' => $projectData[$locale]['summary'],
                ] + $projectData[$locale]);
            }
        }

        $category = Category::create(['type' => 'post']);
        $category->translations()->createMany([
            ['locale' => 'fr', 'name' => 'Actualites', 'slug' => 'actualites'],
            ['locale' => 'en', 'name' => 'News', 'slug' => 'news'],
        ]);

        $post = Post::create([
            'category_id' => $category->id,
            'author_id' => $admin->id,
            'featured_image' => 'https://images.unsplash.com/photo-1559027615-cd4628902d4a?auto=format&fit=crop&w=1200&q=80',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
        ]);

        $post->translations()->createMany([
            ['locale' => 'fr', 'title' => 'Lancement de la plateforme DedeFund', 'slug' => 'lancement-plateforme-dedefund', 'summary' => 'Une base digitale pour presenter les actions, projets et opportunites de solidarite.', 'content' => 'Cette premiere version pose les fondations du site public, du tableau de bord et des formulaires essentiels.'],
            ['locale' => 'en', 'title' => 'DedeFund platform launch', 'slug' => 'dedefund-platform-launch', 'summary' => 'A digital foundation to present actions, projects, and solidarity opportunities.', 'content' => 'This first version lays the foundation for the public website, dashboard, and essential forms.'],
        ]);

        SiteSetting::create(['key' => 'contact_emails', 'group' => 'contact', 'value' => ['info@dedefund.org', 'dedeusca@gmail.com']]);
        SiteSetting::create(['key' => 'whatsapp_number', 'group' => 'contact', 'value' => '+12403538332']);
    }
}
