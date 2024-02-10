<?php

namespace App\Repositories;

use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;

class RedirectRepository
{
    protected $redirectModel;

    public function __construct(Redirect $redirectModel)
    {
        $this->redirectModel = $redirectModel;
    }

    public function getAll()
    {
        return $this->redirectModel->with(['redirectLogs' => function ($builder) {
            $builder->latest()->limit(1);
        }])->get();
    }

    public function create(array $data)
    {
        return $this->redirectModel->create($data);
        $this->redirectModel->code = Hashids::encode($this->redirectModel->id);
        $this->redirectModel->save();
    }

    public function update(Redirect $redirectModel, array $data)
    {
        return $redirectModel->update($data);
    }

    public function delete(Redirect $redirectModel)
    {
        try {
            DB::beginTransaction();

            $redirectModel->update(['status' => 'inactive']);
            $redirectModel->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }

        return $redirectModel;
    }

    public function getRedirectLogs(Redirect $redirectModel)
    {
        return $redirectModel->redirectLogs;
    }

    function getTopReferers(Redirect $redirectModel)
    {
        return $redirectModel->redirectLogs()
            ->select('referer', DB::raw('COUNT(*) as count'))
            ->groupBy('referer')
            ->orderByDesc('count')
            ->take(1)
            ->get();
    }

    function getTotalRedirectLogs(Redirect $redirectModel)
    {
        return $redirectModel->redirectLogs->count();
    }

    function getUniqueIpsRedirectLogs(Redirect $redirectModel)
    {
        $uniqueIpsRedirectLogs = $redirectModel->redirectLogs()->distinct('ip_address')->count('ip');
    }

    function getLast10DaysLogs(Redirect $redirectModel)
    {
        return RedirectLog::where('redirect_id', $redirectModel->id)
            ->whereDate('created_at', '>=', now()->subDays(10)->toDateString())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total, COUNT(DISTINCT ip_address) as unique')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}
