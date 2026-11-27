<?php

namespace App\Support;

class Media
{
    public static function all(): array
    {
        return [
            'elephant' => [
                'src' => '/media/elephant.jpg',
                'alt' => 'An elephant standing in green grass with hills behind it',
                'kind' => 'image',
                'ratio' => 'portrait',
            ],
            'lion' => [
                'src' => '/media/lion.jpg',
                'alt' => 'A male lion standing beside a river in dry grass',
                'kind' => 'image',
                'ratio' => 'portrait',
            ],
            'lunch' => [
                'src' => '/media/lunch.jpg',
                'alt' => 'A laid table and wicker chairs under acacia trees',
                'kind' => 'image',
                'ratio' => 'portrait',
            ],
            'rhino' => [
                'src' => '/media/rhino.jpg',
                'alt' => 'A black rhino walking through tall grass',
                'kind' => 'image',
                'ratio' => 'square',
            ],
            'cheetah' => [
                'src' => '/media/cheetah.jpg',
                'alt' => 'A cheetah and two cubs resting in dry grass',
                'kind' => 'image',
                'ratio' => 'landscape',
            ],
            'plains' => [
                'src' => '/media/plains.mp4',
                'alt' => 'A portrait film from the plains',
                'kind' => 'video',
                'ratio' => 'video-portrait',
            ],
            'drive' => [
                'src' => '/media/drive.mp4',
                'alt' => 'A landscape film from a game drive',
                'kind' => 'video',
                'ratio' => 'video-landscape',
            ],
        ];
    }

    public static function still(string $slug): array
    {
        $map = [
            'serengeti-migration' => 'cheetah',
            'ngorongoro-tarangire' => 'rhino',
            'mara-classic' => 'lion',
            'amboseli-tsavo' => 'elephant',
        ];

        return self::all()[$map[$slug] ?? 'elephant'];
    }
}
