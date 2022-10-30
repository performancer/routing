<?php

declare(strict_types=1);

namespace Routing\Contract;

interface Response
{
    public function send(): void;
}
