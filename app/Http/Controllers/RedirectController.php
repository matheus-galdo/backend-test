<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRedirectRequest;
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
        // TODO: fazer resource que muda o nome de id pra code
        // TODO: pegar o último acesso, coluna de último acesso na tabela de redirect?
        $redirect = Redirect::withTrashed()->get();
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
            "url" => $request->url,
            "status" => "active",
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Toggle the status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($id)
    {
        //TODO: checar estado de deleção antes de fazer o toggle
    }

    /**
     * Acess the url of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accessRedirectUrl(Request $request, $redirectCode): RedirectResponse
    {
        $redirect = Redirect::findFromCode($redirectCode);
        $queryStrings = http_build_query($request->query());

        RedirectLog::create([
            "redirect_id" => $redirect->getOriginalId(),
            "ip_address" => $request->ip(),
            "query_params" => $queryStrings,
            "user_agent" => $request->header("user-agent"),
            "referer" => $request->header("referer"),
        ]);

        $fullUrl = $redirect->url;

        if (strlen($queryStrings) > 0) {
            $hasQueryParams = str_contains($redirect->url, "?");

            if (!$hasQueryParams) {
                $fullUrl .= "?";
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
    public function destroy($redirectCode): Response
    {
        //TODO: fazer DI dessa model
        $redirect = Redirect::findFromCode($redirectCode);
        $redirect->update(["status" => "inactive"]);
        $redirect->delete();
        return response($redirect);
    }

    function getRedirectStats($redirectCode): JsonResponse
    {
        $redirect = Redirect::findFromCode($redirectCode);
        return response()->json($redirect->redirectLogs);
    }
}
