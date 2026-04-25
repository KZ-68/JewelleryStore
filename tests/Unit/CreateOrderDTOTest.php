<?php

namespace Tests\Unit;

use App\DTOs\CreateOrderDTO;
use PHPUnit\Framework\TestCase;

class CreateOrderDTOTest extends TestCase
{

    public function test_fromArray_maps_all_fields_correctly(): void
    {
        $data = [
            'gift'         => true,
            'gift_message' => 'Joyeux anniversaire !',
            'note'         => 'Livrer le matin.',
            'valid'        => true,
            'returned'     => false,
        ];

        $dto = CreateOrderDTO::fromArray($data);

        $this->assertTrue($dto->gift);
        $this->assertSame('Joyeux anniversaire !', $dto->gift_message);
        $this->assertSame('Livrer le matin.', $dto->note);
        $this->assertTrue($dto->valid);
        $this->assertFalse($dto->returned);
    }

    public function test_fromArray_uses_default_values_for_missing_keys(): void
    {
        $dto = CreateOrderDTO::fromArray([]);

        $this->assertFalse($dto->gift);
        $this->assertNull($dto->gift_message);
        $this->assertNull($dto->note);
        $this->assertFalse($dto->valid);
        $this->assertFalse($dto->returned);
    }

    public function test_fromArray_accepts_null_gift_message_and_note(): void
    {
        $dto = CreateOrderDTO::fromArray([
            'gift'         => false,
            'gift_message' => null,
            'note'         => null,
            'valid'        => false,
            'returned'     => false,
        ]);

        $this->assertNull($dto->gift_message);
        $this->assertNull($dto->note);
    }

    public function test_toArray_returns_all_fields(): void
    {
        $dto = CreateOrderDTO::fromArray([
            'gift'         => true,
            'gift_message' => 'Cadeau',
            'note'         => 'Note test',
            'valid'        => false,
            'returned'     => true,
        ]);

        $expected = [
            'gift'         => true,
            'gift_message' => 'Cadeau',
            'note'         => 'Note test',
            'valid'        => false,
            'returned'     => true,
        ];

        $this->assertSame($expected, $dto->toArray());
    }

    public function test_toArray_roundtrip_is_consistent(): void
    {
        $data = [
            'gift'         => false,
            'gift_message' => null,
            'note'         => null,
            'valid'        => true,
            'returned'     => false,
        ];

        $this->assertSame($data, CreateOrderDTO::fromArray($data)->toArray());
    }
}
