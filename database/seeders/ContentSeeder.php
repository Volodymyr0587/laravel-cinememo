<?php

namespace Database\Seeders;

use App\Models\ContentItem;
use App\Models\ContentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();

        $contentTypesAndContentItems = [
            'Movie' => [
                [
                    'title' => 'The Shawshank Redemption',
                    'description' => 'A story of hope and friendship in a prison.',
                    'main_image' => 'images/The-Shawshank-Redemption/The-Shawshank-Redemption.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-2.jpg',
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-3.jpg',
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-4.jpg'
                    ],
                    'release_date' => '1999-10-14',
                ],
                [
                    'title' => 'Inception',
                    'description' => 'A mind-bending thriller about dreams within dreams.',
                    'main_image' => 'images/Inception/Inception.jpg',
                    'status' => \App\Enums\ContentStatus::WillWatch->value,
                    'additional_images' => [
                        'images/Inception/Inception-2.jpg',
                        'images/Inception/Inception-3.jpeg',
                        'images/Inception/Inception-4.jpeg',
                    ],
                    'release_date' => '2010-07-16',
                ],
            ],
            'Series' => [
                [
                    'title' => 'Breaking Bad',
                    'description' => 'A chemistry teacher turns to making meth.',
                    'main_image' => 'images/Breaking-Bad/Breaking-Bad.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Breaking-Bad/breaking-bad-1.jpeg',
                        'images/Breaking-Bad/breaking-bad-2.jpg',
                        'images/Breaking-Bad/breaking-bad-3.jpg',
                    ],
                     'release_date' => 'January 20, 2008',
                ],
                [
                    'title' => 'Stranger Things',
                    'description' => 'A supernatural mystery in the 80s.',
                    'main_image' => 'images/Stranger-Things/stranger-things.jpg',
                    'status' => \App\Enums\ContentStatus::Watching->value,
                    'additional_images' => [
                        'images/Stranger-Things/stranger-things-1.jpg',
                        'images/Stranger-Things/stranger-things-2.jpeg',
                        'images/Stranger-Things/stranger-things-3.png',
                    ],
                    'release_date' => 'July 15, 2016',
                ],
            ],
            'Anime Series' => [
                [
                    'title' => 'Ця фарфорова лялечка закохалася 2 сезон',
                    'description' => 'Одного разу, будучи маленьким хлопчиком, Вакана побачив святкових ляльок, створених його дідом. Той був великим майстром своєї справи, і Вакана вирішив, що хоче бути схожим на нього. Оскільки хлопчик ріс без батьків, дідусь і онук були дуже близькими друзями. Минали роки, Вакана навчився шити для ляльок різноманітні сукні, але от створення самої голови так і не піддавалося наполегливому хлопцеві. Проте Вакана боявся говорити однокласникам про своє захоплення, оскільки соромився того факту, що він обожнює возитися з ляльками. Одного разу його таємниця вирвалася назовні, та не комусь, а найяскравішій дівчині класу. Марін була здивована тому, що хлопець так вправно поводиться зі швейною машинкою. І він даремно хвилювався, що дівчина сміятиметься. Навпаки, це саме те, що було їй потрібно найбільше у світі...',
                    'main_image' => 'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season.jpg',
                    'status' => \App\Enums\ContentStatus::Watching->value,
                    'additional_images' => [
                        'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season-2.jpg',
                        'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season-3.jpg',
                        'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season-4.png',
                        'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season-5.png',
                    ]
                ],
                [
                    'title' => 'Поклик ночі 1 сезон',
                    'description' => 'Нещасний юнак До Яморі насилу переносить проблеми повсякденності. Головний герой страждає на безсоння через постійні проблеми з побудовою відносин з представницями протилежної статі. Якось головний персонаж стикається з дивною дівчиною, яку звуть Надзуна Нанакуса. Головна героїня дуже дивна, дивовижна і вкрай неспокійна. Героїня запрошує юнака в одну покинуту будівлю, обіцяючи тому, що там він зможе спокійно виспатися, доки вона буде неподалік від нього. Так і виходить: головний персонаж спокійно лягає спати, але різко прокидається через гострий біль у шиї. Юнак одразу ж усвідомлює, що став жертвою вампіра. Нанкуса - кровопивця, яка обманом приваблює молодих людей. Щоправда, сам Ко не проти того, що з нього висмоктують кров. Він розуміє, що незабаром стане таким же вампіром. З цього моменту розпочинається велика дружба між цими персонажами. Що буде далі?',
                    'main_image' => 'images/Call-of-the-Night/Call-of-the-Night.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Call-of-the-Night/Call-of-the-Night-2.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-3.png',
                    ]
                ],
                [
                    'title' => 'Поклик ночі 2 сезон',
                    'description' => "Безсонний підліток Коу Яморі вже прийняв рішення: він хоче стати вампіром і закохатися в прекрасну нічну мандрівницю Надзуну Нанакусу. Однак кохання виявляється не таким простим, і обом героям доводиться шукати справжнє його значення. У центрі сюжету також опиняється Анько Угіусу, детективка-венепоборниця, яка отримала місію знищувати вампірів, руйнуючи їхні зв'язки з людським світом. Особливо небезпечний зв'язок між Надзуною і життям до перевтілення, адже вона майже нічого не пам'ятає про своє людське минуле. Це призводить до кульмінаційного протистояння між її справжніми почуттями та існуючими обмеженнями.",
                    'main_image' => 'images/Call-of-the-Night/Call-of-the-Night-2.jpg',
                    'status' => \App\Enums\ContentStatus::Watching->value,
                    'additional_images' => [
                        'images/Call-of-the-Night/Call-of-the-Night.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-3.png',
                    ]
                ],
                [
                    'title' => 'Фрірен: після кінця пригоди 1 сезон',
                    'description' => 'Король демонів переможений, і група героїв, що перемогла, повертається додому перед тим, як розпуститися. Четверо - маг Фрірен, герой Хіммель, жрець Хейтер і воїн Ейзен - згадують про свою десятирічну подорож, коли настає момент попрощатися один з одним. Але плин часу для ельфів відрізняється, тому Фрірен стає свідком того, як її супутники повільно йдуть один за одним. Перед смертю Хайтеру вдається нав\'язати Фрірену молоду людину-учня на ім\'я Ферн. Ведена пристрастю ельфа до збирання безлічі магічних заклинань, пара вирушає до, здавалося б, безцільної подорожі, знову відвідуючи місця, які відвідали герої минулого. Під час своїх подорожей Фрірен повільно стикається з жалем про втрачені можливості встановити тісніші зв\'язки зі своїми нині покійними товаришами.',
                    'main_image' => 'images/Frieren/frieren-0.png',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Frieren/frieren.jpg',
                        'images/Frieren/frieren-1.jpg',
                        'images/Frieren/frieren-2.jpg',
                        'images/Frieren/frieren-3.jpg',
                        'images/Frieren/frieren-4.jpg',
                        'images/Frieren/frieren-8.jpeg',
                        'images/Frieren/frieren-9.png',
                        'images/Frieren/frieren-11.jpeg',
                    ]
                ],
            ],
        ];

        $colors = [
            'Movie' => '#ff9900',
            'Series' => '#1db954',
            'Anime Series' => '#f23aa2',
        ];

        foreach ($contentTypesAndContentItems as $typeName => $items) {
            $type = ContentType::create([
                'user_id' => $user->id,
                'name' => $typeName,
                'color' => $colors[$typeName] ?? '#3b82f6',
            ]);

            foreach ($items as $itemData) {
                // Створюємо ContentItem без зображень
                $contentItem = ContentItem::create([
                    'user_id' => $user->id,
                    'content_type_id' => $type->id,
                    'title' => $itemData['title'],
                    'description' => $itemData['description'],
                    'status' => $itemData['status'],
                    'release_date' => $itemData['release_date'] ?? null
                ]);

                // Додаємо головне зображення через поліморфну систему
                if (isset($itemData['main_image'])) {
                    $mainImagePath = $this->copyImageToStorage($itemData['main_image']);
                    $contentItem->addMainImage($mainImagePath);
                }

                // Додаємо додаткові зображення через поліморфну систему
                foreach ($itemData['additional_images'] as $imgPath) {
                    $storedPath = $this->copyImageToStorage($imgPath);
                    $contentItem->addAdditionalImage($storedPath);
                }

                // Прив'язуємо випадкові жанри
                $genreIds = \App\Models\Genre::inRandomOrder()->take(rand(1, 3))->pluck('id');
                $contentItem->genres()->attach($genreIds);
            }
        }
    }

    private function copyImageToStorage(string $relativePath): string
    {
        $sourcePath = public_path($relativePath);

        if (!file_exists($sourcePath)) {
            throw new \Exception("Image file not found: {$sourcePath}");
        }

        $destinationDir = 'content-images';
        if (!Storage::disk('public')->exists($destinationDir)) {
            Storage::disk('public')->makeDirectory($destinationDir);
        }

        $fileName = basename($relativePath);
        $newPath = $destinationDir . '/' . $fileName;

        Storage::disk('public')->put($newPath, file_get_contents($sourcePath));

        return $newPath;
    }
}
