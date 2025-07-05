<?php

namespace Domain\Entities;

class Role
{
    public function __construct(
        public string $name,
        public string $description,
        public bool $active = true,
        public ?string $status = null,
    ) {}
}
