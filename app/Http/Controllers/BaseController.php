<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController
{
    protected $classe;

    public function index(Request $request)
    {
        return $this->classe::paginate($request->per_page);
    }

    public function store(Request $request)
    {
        return response()->json($this->classe::create($request->all()), 201);
    }

    public function show(int $id)
    {
        $item = $this->classe::find($id);
        if(is_null($item)) {
            return response()->json($item, 204);
        }
        return response()->json($item);
    }

    public function update(int $id, Request $request)
    {
        $item = $this->classe::find($id);
        if(is_null($item)) {
            return response()->json(['erro' => 'Recurso não encontrado'], 404);
        }
        $item->fill($request->all());
        $item->save();

        return $item;
    }

    public function destroy(int $id)
    {
        $count = $this->classe::destroy($id);
        if ($count === 0) {
            return response()->json(['erro' => 'Não encontrado'], 404);
        }
        return response()->json('', 204);
    }
}
