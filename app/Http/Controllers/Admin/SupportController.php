<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Support;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index(Support $support) 
    {
        $supports = $support->all();

        return view('admin/supports/index', compact('supports'));
    }

    public function show(String|int $id, Support $support)//metodo show
    { 
       if /* usa o if para verificar se o id existe ou não. Caso não exista ele retorna para a view anterior */
       (!$support = $support->find($id) /* recupera o support pelo id */) {
        return back();
       }
       return view('admin/supports/show', compact('support'));
    }

    public function create() 
    {
        return view('admin/supports/create');
    }

    public function store(Request $request, Support $support) // injeção de dependência
    {
        $data = $request->all();//inserindo regitros no banco
        $data['status'] = 'a';
        $support->create($data);
       
       return redirect()->route('supports.index');//redireciona a rota para a index quando for submetido
    }

    public function edit(Support $support, string|int $id) //metodo que mostra o registro na view
    {
        if(!$support = $support->where('id', $id)->first()) {
        return back();
       }
       return view('admin/supports.edit', compact('support'));
    }

    public function update(Request $request, Support $support, string $id) //metodo que edita o registro
    {
        if(!$support = $support->find($id)) {
            return back();
        }


        //    $support->subject = $request->subject;
        //    $support->body = $request->body;
        //    $support->save();

           $support->update($request->only([
            'subject',
            'body',
           ]));
           return redirect()->route('supports.index');
    }
}
