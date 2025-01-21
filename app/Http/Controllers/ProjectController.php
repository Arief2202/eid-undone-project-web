<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;
use DateTime;
session_start();

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        $user_type = "guest";

        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password'])) $user_type = 'admin';
            else if(password_verify('user', $user['username']) && password_verify(env("USER_PASSWORD", "password"), $user['password'])) $user_type = 'user';
            else{
                if(!$local) return redirect('/login');
            }
        }
        return view("index",
            [
                "user_type" => $user_type,
            ]
        );
    }

    public function create(Request $request){
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password']));
            else{
                if(!$local) return redirect('/login');
            }
        }
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

    public function editView(Request $request)
    {
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        $user_type = "guest";

        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password'])) $user_type = 'admin';
            else if(password_verify('user', $user['username']) && password_verify(env("USER_PASSWORD", "password"), $user['password'])) $user_type = 'user';
            else{
                if(!$local) return redirect('/login');
            }
        }
        if($user_type != "admin") return redirect('/login');

        return view("edit",
            [
                "user_type" => $user_type
            ]
        );
    }

    public function historyView(Request $request)
    {
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        $user_type = "guest";

        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password'])) $user_type = 'admin';
            else if(password_verify('user', $user['username']) && password_verify(env("USER_PASSWORD", "password"), $user['password'])) $user_type = 'user';
            else{
                if(!$local) return redirect('/login');
            }
        }
        return view("history",
            [
                "user_type" => $user_type
            ]
        );
    }
    public function getProject($id){
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(project::where("id", "=", $id)->first());
        die;return;
    }
    public function deleteProject($id){
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password']));
            else{
                if(!$local) return redirect('/login');
            }
        }
        project::where("id", "=", $id)->first()->delete();
        return redirect()->back();
    }
    public function editPost(Request $request){
        $local = $request->ip() == "127.0.0.1" || $request->ip() == "0.0.0.0" || $request->ip() == "localhost";
        if (!$request->session()->exists('user')){
            if(!$local) return redirect('/login');
        }
        else {
            $user =  $request->session()->get('user');
            if(password_verify('admin', $user['username']) && password_verify(env("ADMIN_PASSWORD", "password"), $user['password']));
            else{
                if(!$local) return redirect('/login');
            }
        }
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

    public function getDataAjaxHome(){
        foreach(project::where("status", "!=", "Cancel")->where("status", "!=", "Finish")->get() as $i=>$data){
            echo "<tr class=\"";

            $date1 = new DateTime();
            $date2 = new DateTime($data->due_date);
            $interval = $date1->diff($date2);
            $selisih = (int) $interval->format('%R%a');

            if($selisih < 0) echo "level3";
            else if($selisih < 14) echo "level2";

            echo "\">";

            echo "<td>$selisih</td>";
            echo "<td>$data->no_spk</td>";
            echo "<td>$data->nama_project</td>";
            echo "<td>$data->keterangan</td>";
            echo "<td>$data->customer</td>";
            echo "<td>$data->pic</td>";
            echo "<td>".date('d M Y', strtotime($data->due_date))."</td>";
            echo "<td>$data->status</td>";
            echo "</tr>";
        }
        die;return;
    }
    public function getDataAjaxHistory(){
        foreach(project::where(function ($query) {
                    $query->where('status', '=', "Finish")
                        ->orWhere('status', '=', "Cancel")
                        ->orWhere('due_date', '<', date('Y-m-d'));
                })->get() as $i=>$data)
        {
            echo "<tr class=\"history\">";
            echo "<td>$data->no_spk</td>";
            echo "<td>$data->nama_project</td>";
            echo "<td>$data->keterangan</td>";
            echo "<td>$data->customer</td>";
            echo "<td>$data->pic</td>";
            echo "<td>".date('d M Y', strtotime($data->due_date))."</td>";
            echo "<td>$data->status</td>";
            echo "</tr>";
        }
        die;return;
    }
    public function getDataAjaxEdit(){
        foreach(project::all() as $i=>$data){
            echo "<tr class=\"";

            $date1 = new DateTime();
            $date2 = new DateTime($data->due_date);
            $interval = $date1->diff($date2);
            $selisih = (int) $interval->format('%R%a');

            if($data->status == "Finish" || $data->status == "Cancel") echo "level0";
            else{
                if($selisih < 0) echo "level3";
                else if($selisih < 14) echo "level2";
            }

            echo "\">";
            if($data->status == "Finish" || $data->status == "Cancel") echo "<td>-</td>";
            else echo "<td>$selisih</td>";
            echo "<td>$data->no_spk</td>";
            echo "<td>$data->nama_project</td>";
            echo "<td>$data->keterangan</td>";
            echo "<td>$data->customer</td>";
            echo "<td>$data->pic</td>";
            echo "<td>".date('d M Y', strtotime($data->due_date))."</td>";
            echo "<td>$data->status</td>";
            echo "<td><button onclick=\"updateModal($data->id)\" class=\"btn btn-primary me-2\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\">Edit</button><form method=\"POST\" action=\"/delete/$data->id\" style=\"display: inline;\"><button class=\"btn btn-danger\" type=\"submit\">Delete</button></form></td>";
            echo "</tr>";
        }
        die;return;
    }
}
