<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRedirectRequest;
use App\Models\Redirect;
use Illuminate\Http\Request;
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
        $redirect = Redirect::all();
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
        //
    }

    /**
     * Acess the url of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accessRedirectUrl($redirectCode)
    {
        $redirect = Redirect::findFromCode($redirectCode);
        //TODO: adicionar um redirectLog para a visita
        return redirect()->away($redirect->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($redirectCode)
    {
        $redirect = Redirect::findFromCode($redirectCode);
        $redirect->delete();
        return response($redirect);
    }
}
