<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscricao;

class InscricoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inscricoes = Inscricao::all();
        return view('inscricoes.index')
            ->with('inscricoes', $inscricoes);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inscricoes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Inscricao = Inscricao::create( $request->all() );

        if ( $Inscricao ) {
            \Mail::send('emails.bemvindo', ['Inscricao' => $Inscricao], function ($message) use ($Inscricao) {
            $message->to($Inscricao->email, $Inscricao->email)->subject("[Minicurso-Laravel] Voce se inscreveu");
            $message->from('noreply@grupotesseract.com.br', 'Grupo Tesseract');
            });
        }

        return redirect('inscricoes/'.$Inscricao->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Inscriao = Inscricao::findOrFail($id);
        return view('inscricoes.show')->with('Inscricao', $Inscriao);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Inscricao = Inscricao::findOrFail($id);
        return view('inscricoes.edit')->with('Inscricao', $Inscricao);
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
        $Inscricao = Inscricao::findOrFail( $id );
        $Inscricao->update($request->all());
        return redirect('inscricoes/'.$Inscricao->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Inscricao = Inscricao::findOrFail( $id );
        $Inscricao->delete();
        return redirect('inscricoes');
    }
}
