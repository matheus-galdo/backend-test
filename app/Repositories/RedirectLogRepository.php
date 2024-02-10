<?php

namespace App\Repositories;

use App\Models\RedirectLog;

class RedirectLogRepository
{
    protected $redirectLogModel;

    public function __construct(RedirectLog $redirectLogModel)
    {
        $this->redirectLogModel = $redirectLogModel;
    }

    public function create(array $data)
    {
        return $this->redirectLogModel->create($data);
    }
}
