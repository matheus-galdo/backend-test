<?php

namespace App\Services;

use App\Models\Redirect;
use App\Repositories\RedirectRepository;

class RedirectService
{
    protected $redirectRepository;
    protected $redirectLogService;

    public function __construct(RedirectRepository $redirectRepository, RedirectLogService $redirectLogService = null)
    {
        $this->redirectRepository = $redirectRepository;
        $this->redirectLogService = $redirectLogService;
    }

    public function getAllRedirects()
    {
        return $this->redirectRepository->getAll();
    }

    public function createRedirect(string $url)
    {
        //TODO: Validar se aponta pra própria aplicação, usar env com o host do app
        return $this->redirectRepository->create(['url' => $url]);
    }

    public function updateRedirect(Redirect $redirectModel, array $partialRedirect)
    {
        if (!empty($partialRedirect)) {
            return $this->redirectRepository->update($redirectModel, $partialRedirect);
        }
    }

    public function accessRedirectUrl(Redirect $redirectModel, $redirectLogData)
    {
        $this->redirectLogService->create($redirectLogData);
        $fullUrl = $redirectModel->url;

        $hasQueryParamsSaved = str_contains($redirectModel->url, '?');
        $tHasQueryParamsOnRequest = $redirectLogData['query_params'] > 0;

        if ($tHasQueryParamsOnRequest) {
            if (!$hasQueryParamsSaved) {
                $fullUrl .= '?';
            }

            $fullUrl .= $redirectLogData['query_params'];
        }

        return $fullUrl;
    }

    public function deleteRedirect(Redirect $redirectModel)
    {
        return $this->redirectRepository->delete($redirectModel);
    }

    public function getRedirectLogs(Redirect $redirectModel)
    {
        return $this->redirectRepository->getRedirectLogs($redirectModel);
    }

    public function getRedirectStats(Redirect $redirectModel)
    {
        $stats = [
            'totalRedirectLogs' => $this->redirectRepository->getTopReferers($redirectModel),
            'uniqueIpsRedirectLogs' => $this->redirectRepository->getTotalRedirectLogs($redirectModel),
            'top_referrers' => $this->redirectRepository->getUniqueIpsRedirectLogs($redirectModel),
            'last10DaysLogs' => $this->redirectRepository->getLast10DaysLogs($redirectModel),
        ];

        return $stats;
    }
}
