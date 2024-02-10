<?php

namespace App\Services;

use App\Repositories\RedirectLogRepository;

class RedirectLogService
{
    protected $redirectLogRepository;

    public function __construct(RedirectLogRepository $redirectLogRepository)
    {
        $this->redirectLogRepository = $redirectLogRepository;
    }

    public function create(array $data)
    {
        return $this->redirectLogRepository->create($data);
    }
}
