<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TodoRepository;

class TodoController extends Controller
{
    protected $todoRepo;

    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todoRepo->index();
        return response()->json(['status' => 0, 'todo' => $todos]);
    }

    public function store(Request $request)
    {
        $data = $this->todoRepo->create(request()->all());
        return response()->json(['status' => 0, 'data' => $data]);
    }

    public function show($id)
    {
        $todos = $this->todoRepo->find($id);

        if (!$todos) {
            return response()->json(['status' => 1, 'message' => 'todo1 not found'], 404);
        }

        return response()->json(['status' => 0, 'todo' => $todos]);
    }

    public function update(Request $request, $id)
    {
        $result = $this->todoRepo->update(request()->all(), $id);
        if (!$result) {
            return response()->json(['status' => 1, 'message' => 'todo2 not found'], 404);
        }

        return response()->json(['status' => 0, 'message' => 'success']);
    }

    public function destroy($id)
    {
        $result = $this->todoRepo->destroy($id);

        if (!$result) {
            return response()->json(['status' => 1, 'message' => 'todo3 not found'], 404);
        }

        return response()->json(['status' => 0, 'message' => 'success']);
    }
    public function done(Request $request)
    {
        if($request->ajax()) {
            $result=$this->todoRepo->done($request);
        }
        if (!$result) {
            return response()->json(['status' => 1, 'message' => 'todo4 not found'], 404);
        }
        return response()->json(['status' => 0, 'message' => 'success']);
    }
    public function delete_all(){
        $result = $this->todoRepo->delete_all();

        if (!$result) {
            return response()->json(['status' => 1, 'message' => 'todo3 not found'], 404);
        }

        return response()->json(['status' => 0, 'message' => 'success']);
    }
    public function view($id){
        echo $id;
    }

}
