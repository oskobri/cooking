<?php

namespace App\Services\Ai;

class ImageAi
{
    /**
     * @throws \JsonException
     */
    public static function create(string $prompt, string $quality = 'standard', string $size = '1024x1024', string $style = 'vivid'): array
    {
        $response = \OpenAI\Laravel\Facades\OpenAI::images()
            ->create([
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'n' => 1,
                'quality' => $quality, // standard, hd
                'size' => $size, // 1024x1024, 1792x1024, 1024x1792
                'style' => $style, // vivid, natural
                'response_format' => 'url',
            ]);

        return $response->toArray();
    }
}
