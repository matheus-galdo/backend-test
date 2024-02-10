<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRedirectRequest;
use App\Http\Requests\UpdateRedirectRequest;
use App\Services\RedirectService;
use App\Repositories\RedirectRepository;
use App\Models\Redirect;
use App\Models\RedirectLog;
use App\Repositories\RedirectLogRepository;
use App\Services\RedirectLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RedirectController extends Controller
{
    protected $redirectRepository;
    protected $redirectLogRepository;
    protected $redirectService;

    public function __construct(RedirectRepository $redirectRepository, RedirectLogRepository $redirectLogRepository)
    {
        $this->redirectRepository = $redirectRepository;
        $this->redirectService = new RedirectService($this->redirectRepository);
        $this->redirectLogRepository = $redirectLogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redirects = $this->redirectService->getAllRedirects();
        return response()->json($redirects);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRedirectRequest $request)
    {
        $redirect = $this->redirectService->createRedirect($request->url);
        return response()->json($redirect, Response::HTTP_CREATED);
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


        $redirect = $this->redirectService->updateRedirect($redirect, $partialRedirect);

        return response()->json(null, $redirect ? Response::HTTP_OK : Response::HTTP_UNPROCESSABLE_ENTITY);
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

        $redirectLogData = [
            'redirect_id' => $redirect->getId(),
            'ip_address' => $request->ip(),
            'query_params' => $queryStrings,
            'user_agent' => $request->header('user-agent'),
            'referer' => $request->header('referer'),
        ];

        $redirectLogService = new RedirectLogService($this->redirectLogRepository);
        $redirectService = new RedirectService($this->redirectRepository, $redirectLogService);

        $fullUrl = $redirectService->accessRedirectUrl($redirect, $redirectLogData);
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
        $redirect = $this->redirectService->deleteRedirect($redirect);
        return response($redirect);
    }

    function getRedirectLogs(Redirect $redirect): JsonResponse
    {
        $redirectLogs = $this->redirectService->getRedirectLogs($redirect);
        return response()->json($redirectLogs);
    }

    function getRedirectStats(Redirect $redirect)
    {
        $redirectStats = $this->redirectService->getRedirectStats($redirect);
        return response()->json($redirectStats);
    }
}
