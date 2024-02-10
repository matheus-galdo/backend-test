<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRedirectRequest;
use App\Http\Requests\UpdateRedirectRequest;
use App\Models\Redirect;
use App\Models\RedirectLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Vinkla\Hashids\Facades\Hashids;

class RedirectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirect = Redirect::with(['redirectLogs' => function ($builder) {
            $builder->latest()->limit(1);
        }])->get();
        return response()->json($redirect);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRedirectRequest $request)
    {
        //TODO: Validar se aponta pra própria aplicação, usar env com o host do app
        $redirect = Redirect::create([
            'url' => $request->url,
            'status' => 'active',
        ]);

        return response()->json($redirect);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRedirectRequest $request, Redirect $redirect)
    {
        $partialRedirect = [];

        if ($request->url) {
            $partialRedirect['url'] = $request->url;
        }

        if ($request->status) {
            $partialRedirect['status'] = $request->status;
        }

        if (!empty($partialRedirect)) {
            $redirect->update($partialRedirect);
        }
        
        return response()->json($redirect);
    }

    /**
     * Acess the url of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accessRedirectUrl(Request $request, Redirect $redirect): RedirectResponse
    {
        $queryStrings = http_build_query($request->query());

        RedirectLog::create([
            'redirect_id' => $redirect->getId(),
            'ip_address' => $request->ip(),
            'query_params' => $queryStrings,
            'user_agent' => $request->header('user-agent'),
            'referer' => $request->header('referer'),
        ]);

        $fullUrl = $redirect->url;

        if (strlen($queryStrings) > 0) {
            $hasQueryParams = str_contains($redirect->url, '?');

            if (!$hasQueryParams) {
                $fullUrl .= '?';
            }

            $fullUrl .= $queryStrings;
        }

        return redirect()->away($fullUrl);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Redirect $redirect): Response
    {
        //TODO: transaction?
        $redirect->update(['status' => 'inactive']);
        $redirect->delete();
        return response($redirect);
    }

    function getRedirectLogs(Redirect $redirect): JsonResponse
    {
        return response()->json($redirect->redirectLogs);
    }

    function getRedirectStats(Redirect $redirect)
    {
        //
    }
}
