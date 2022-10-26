<?php

declare(strict_types=1);

namespace SmartAssert\ArrayInspector;

class ArrayInspector
{
    /**
     * @param array<mixed> $data
     */
    public function __construct(
        private readonly array $data,
    ) {
    }

    /**
     * @param non-empty-string $type Any value returned by gettype()
     */
    public function has(int|string $key, string $type): bool
    {
        return gettype($this->data[$key] ?? null) === $type;
    }

    /**
     * @param callable(int|string $key, mixed $value): mixed $action
     *
     * @return array<mixed>
     */
    public function each(callable $action): array
    {
        $items = [];

        foreach ($this->data as $key => $value) {
            $item = $action($key, $value);
            if (null !== $item) {
                $items[] = $item;
            }
        }

        return $items;
    }

    /**
     * @return array<mixed>
     */
    public function getArray(int|string $key): array
    {
        $value = $this->data[$key] ?? [];

        return is_array($value) ? $value : [];
    }

    public function getString(int|string $key): ?string
    {
        $value = $this->data[$key] ?? null;

        return is_string($value) ? $value : null;
    }

    public function getInteger(int|string $key): ?int
    {
        $value = $this->data[$key] ?? null;

        return is_int($value) ? $value : null;
    }

    /**
     * @return null|non-empty-string
     */
    public function getNonEmptyString(int|string $key): ?string
    {
        return $this->createNonEmptyString(trim((string) $this->getString($key)));
    }

    public function getPositiveInteger(int|string $key): ?int
    {
        $value = $this->getInteger($key);

        return is_int($value) && $value > 0 ? $value : null;
    }

    /**
     * @return ?non-empty-string
     */
    private function createNonEmptyString(string $value): ?string
    {
        $value = trim($value);

        return '' === $value ? null : $value;
    }
}
