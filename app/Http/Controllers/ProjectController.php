<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("index",
            [
                "datas" => project::where("status", "!=", "Cancel")->where("status", "!=", "Finish")->get(),
            ]
        );
    }

    public function create(Request $request){
        project::create([
            "no_spk" => $request->no_spk,
            "nama_project" => $request->nama_project,
            "keterangan" => $request->keterangan,
            "customer" => $request->customer,
            "pic" => $request->pic,
            "due_date" => $request->due_date,
            "status" => $request->status,
        ]);
        return redirect()->back();
    }

    public function editView()
    {
        return view("edit",
            [
                "datas" => project::get(),
            ]
        );
    }
    public function historyView()
    {
        return view("history",
            [
                "datas" => project::where(function ($query) {
                    $query->where('status', '=', "Finish")
                          ->orWhere('status', '=', "Cancel")
                          ->orWhere('due_date', '<', date('Y-m-d'));
                })->get(),
            ]
        );
    }
    public function getProject($id){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(project::where("id", "=", $id)->first());
        die;return;
    }
    public function deleteProject($id){
        project::where("id", "=", $id)->first()->delete();
        return redirect()->back();
    }
    public function editPost(Request $request){
        $data = project::where("id", "=", $request->id)->first();
        $data->no_spk = $request->no_spk;
        $data->nama_project = $request->nama_project;
        $data->keterangan = $request->keterangan;
        $data->customer = $request->customer;
        $data->pic = $request->pic;
        $data->due_date = $request->due_date;
        $data->status = $request->status;
        $data->save();
        return redirect()->back();
    }
}
