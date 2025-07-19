<?php

namespace App\Traits;

trait RoundNumericFields
{
    public function roundNumericFields(): array
    {
        $data = [];

        foreach ($this->getAttributes() as $key => $value) {
            if (is_numeric($value) && $this->isFillable($key)) {
                $data[$key] = round($value); // 👈 No precision passed = round to nearest int
            }
        }

        return $data;
    }

    public function isFillable($key)
    {
        return in_array($key, $this->getFillable());
    }

    public function applyRoundedFields(): static
    {
        $this->forceFill($this->roundNumericFields());
        return $this;
    }
}
