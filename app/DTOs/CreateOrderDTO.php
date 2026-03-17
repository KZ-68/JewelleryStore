<?php

namespace App\DTOs;

use App\Http\Requests\CreateOrderRequest;

final readonly class CreateOrderDTO
{
    public function __construct(
       public bool $gift,
       public string|null $gift_message,
       public string|null $note,
       public bool $valid,
       public bool $returned
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            gift: $data['gift'] ?? false,
            gift_message: $data['gift_message'] ?? null,
            note: $data['note'] ?? null,
            valid: $data['valid'] ?? false,
            returned: $data['returned'] ?? false,
        );
    }

    public static function fromRequest(CreateOrderRequest $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return [
            'gift' => $this->gift,
            'gift_message' => $this->gift_message,
            'note' => $this->note,
            'valid' => $this->valid,
            'returned' => $this->returned
        ];
    }
}