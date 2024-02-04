<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ConfiguracaoController extends Controller
{

    public function index(Configuracao $configuracao)
    {
        return view('configuracao.index',
            [
                'configuracao' => $configuracao->get()->map(function ($item) {
                    $item->pdf = asset('storage/' . $item->pdf);
                    return $item;
                })
            ]
        );
    }

    public function store(Request $request, Configuracao $configuracao)
    {

        try {
            $request->validate([
                'file' => 'mimes:pdf'
            ]);

            if ($request->hasFile('file')) {

                $file = $request->file->store('pdfs', 'public');

                $request->query('pdf', $file);

                $request->request->add(['pdf' => $file]);
            }


            if ($request->id) {
                $configuracao = $configuracao->find($request->id);
                $configuracao->update($request->all());
            } else {
                $configuracao->create($request->all());
            }

            return redirect(route('config'));
        } catch (ValidationException $th) {
            return response()->json(['error' => $th->errors()], 422);
        } catch (Exception $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
