<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Image;
use App\Models\ContentItem;
use App\Models\ContentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Creating a user
        $user = User::create([
            'name' => 'Volodymyr',
            'email' => 'volodymyr@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Content types and Content items
        $contentTypesAndContentItems = [
            'Movie' => [
                [
                    'title' => 'The Shawshank Redemption',
                    'description' => 'A story of hope and friendship in a prison.',
                    'image' => 'images/The-Shawshank-Redemption/The-Shawshank-Redemption.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-2.jpg',
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-3.jpg',
                        'images/The-Shawshank-Redemption/The-Shawshank-Redemption-4.jpg'
                    ]
                ],
                [
                    'title' => 'Inception',
                    'description' => 'A mind-bending thriller about dreams within dreams.',
                    'image' => 'images/Inception/Inception.jpg',
                    'status' => \App\Enums\ContentStatus::WillWatch->value,
                    'additional_images' => [
                        'images/Inception/Inception-2.jpg',
                        'images/Inception/Inception-3.jpeg',
                        'images/Inception/Inception-4.jpeg',
                    ]
                ],
            ],
            'Serial' => [
                [
                    'title' => 'Breaking Bad',
                    'description' => 'A chemistry teacher turns to making meth.',
                    'image' => 'images/Breaking-Bad/Breaking-Bad.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Breaking-Bad/breaking-bad-1.jpeg',
                        'images/Breaking-Bad/breaking-bad-2.jpg',
                        'images/Breaking-Bad/breaking-bad-3.jpg',
                    ]
                ],
                [
                    'title' => 'Stranger Things',
                    'description' => 'A supernatural mystery in the 80s.',
                    'image' => 'images/Stranger-Things/stranger-things.jpg',
                    'status' => \App\Enums\ContentStatus::Watching->value,
                    'additional_images' => [
                        'images/Stranger-Things/stranger-things-1.jpg',
                        'images/Stranger-Things/stranger-things-2.jpeg',
                        'images/Stranger-Things/stranger-things-3.png',
                    ]
                ],
            ],
            'Anime' => [
                [
                    'title' => 'Ця фарфорова лялечка закохалася 2 сезон',
                    'description' => 'Одного разу, будучи маленьким хлопчиком, Вакана побачив святкових ляльок, створених його дідом. Той був великим майстром своєї справи, і Вакана вирішив, що хоче бути схожим на нього. Оскільки хлопчик ріс без батьків, дідусь і онук були дуже близькими друзями. Минали роки, Вакана навчився шити для ляльок різноманітні сукні, але от створення самої голови так і не піддавалося наполегливому хлопцеві. Проте Вакана боявся говорити однокласникам про своє захоплення, оскільки соромився того факту, що він обожнює возитися з ляльками. Одного разу його таємниця вирвалася назовні, та не комусь, а найяскравішій дівчині класу. Марін була здивована тому, що хлопець так вправно поводиться зі швейною машинкою. І він даремно хвилювався, що дівчина сміятиметься. Навпаки, це саме те, що було їй потрібно найбільше у світі...',
                    'image' => 'images/Sono-Bisque-Doll-wa-Koi-wo-Suru/Sono-Bisque-Doll-wa-Koi-wo-Suru-2-season.jpg',
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
                    'image' => 'images/Call-of-the-Night/Call-of-the-Night.jpg',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Call-of-the-Night/Call-of-the-Night.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-2.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-3.png',
                    ]
                ],
                [
                    'title' => 'Поклик ночі 2 сезон',
                    'description' => 'Безсонний підліток Коу Яморі вже прийняв рішення: він хоче стати вампіром і закохатися в прекрасну нічну мандрівницю Надзуну Нанакусу. Однак кохання виявляється не таким простим, і обом героям доводиться шукати справжнє його значення. У центрі сюжету також опиняється Анько Угіусу, детективка-венепоборниця, яка отримала місію знищувати вампірів, руйнуючи їхні зв’язки з людським світом. Особливо небезпечний зв’язок між Надзуною і життям до перевтілення, адже вона майже нічого не пам’ятає про своє людське минуле. Це призводить до кульмінаційного протистояння між її справжніми почуттями та існуючими обмеженнями.',
                    'image' => 'images/Call-of-the-Night/Call-of-the-Night-2.jpg',
                    'status' => \App\Enums\ContentStatus::Watching->value,
                    'additional_images' => [
                        'images/Call-of-the-Night/Call-of-the-Night.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-2.jpg',
                        'images/Call-of-the-Night/Call-of-the-Night-3.png',
                    ]
                ],
                [
                    'title' => 'Фрірен: після кінця пригоди 1 сезон',
                    'description' => 'Король демонів переможений, і група героїв, що перемогла, повертається додому перед тим, як розпуститися. Четверо - маг Фрірен, герой Хіммель, жрець Хейтер і воїн Ейзен - згадують про свою десятирічну подорож, коли настає момент попрощатися один з одним. Але плин часу для ельфів відрізняється, тому Фрірен стає свідком того, як її супутники повільно йдуть один за одним. Перед смертю Хайтеру вдається нав\'язати Фрірену молоду людину-учня на ім\'я Ферн. Ведена пристрастю ельфа до збирання безлічі магічних заклинань, пара вирушає до, здавалося б, безцільної подорожі, знову відвідуючи місця, які відвідали герої минулого. Під час своїх подорожей Фрірен повільно стикається з жалем про втрачені можливості встановити тісніші зв\'язки зі своїми нині покійними товаришами.',
                    'image' => 'images/Frieren/frieren-0.png',
                    'status' => \App\Enums\ContentStatus::Watched->value,
                    'additional_images' => [
                        'images/Frieren/frieren.jpg',
                        'images/Frieren/frieren-0.png',
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

        // 3. Database filling
        $colors = [
            'Movie' => '#ff9900',
            'Serial' => '#1db954',
            'Anime' => '#f23aa2',
        ];

        foreach ($contentTypesAndContentItems as $typeName => $items) {
            $type = ContentType::create([
                'user_id' => $user->id,
                'name' => $typeName,
                'color' => $colors[$typeName] ?? '#3b82f6',
            ]);

            foreach ($items as $itemData) {
                // Copy main image to storage/app/public/content-images
                $mainImagePath = $this->copyImageToStorage($itemData['image']);

                $contentItem = ContentItem::create([
                    'user_id' => $user->id,
                    'content_type_id' => $type->id,
                    'title' => $itemData['title'],
                    'description' => $itemData['description'],
                    'image' => $mainImagePath,
                    'status' => $itemData['status'],
                ]);

                foreach ($itemData['additional_images'] as $imgPath) {
                    $storedPath = $this->copyImageToStorage($imgPath);
                    Image::create([
                        'content_item_id' => $contentItem->id,
                        'path' => $storedPath,
                    ]);
                }
            }
        }
    }

    private function copyImageToStorage(string $relativePath): string
    {
        $sourcePath = public_path($relativePath);

        if (!file_exists($sourcePath)) {
            throw new \Exception("Image file not found: {$sourcePath}");
        }

        // Make directory if not exists
        $destinationDir = 'content-images';
        if (!Storage::disk('public')->exists($destinationDir)) {
            Storage::disk('public')->makeDirectory($destinationDir);
        }

        $fileName = basename($relativePath);
        $newPath = $destinationDir . '/' . $fileName;

        // Copy file
        Storage::disk('public')->put($newPath, file_get_contents($sourcePath));

        return $newPath;
    }
}
