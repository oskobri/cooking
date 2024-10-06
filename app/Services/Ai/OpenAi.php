<?php

namespace App\Services\Ai;

class OpenAi
{
    public string $model = 'gpt-4o-mini';

    public array $additionalParameters = [];

    public function chat($message): ?string
    {
        $parameters = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ],
            ]
        ];

        return \OpenAI\Laravel\Facades\OpenAI::chat()
            ->create(array_merge($parameters, $this->additionalParameters))
            ->choices[0]->message->content;
    }
}
