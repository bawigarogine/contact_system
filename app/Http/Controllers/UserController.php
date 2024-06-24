<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactDeleteRequest;

class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function index(){
        $contacts = Contacts::where('user_id', Auth::user()->id)->paginate(5);
        return View::make('dashboard')
                ->with(compact('contacts'));
    }

    public function create(){
        return View::make('create');
    }
    
    public function greeting(){
        return View::make('greeting');
    }

    public function store(ContactCreateRequest $request){
        $request->validated();

        Contacts::create([
            "name" => $request->name,
            "company" => $request->company,
            "phone_num" => $request->phone_num,
            "email" => $request->email,
            "user_id" => Auth::user()->id
        ]);

        return redirect('contact');
    }

    public function delete(ContactDeleteRequest $request){
        $request->validated();

        Contacts::where('user_id', Auth::user()->id)->where('id', $request->id)->delete();

        return redirect('contact');
    }

    public function edit(int $id){
        $contact = Contacts::where('id', $id)->first();
        return View::make('edit')
                ->with(compact('contact'));
    }

    public function update(ContactCreateRequest $request, int $id){
        $request->validated();

        $update = Contacts::find($id);

        $update->update([
            "name" => $request->name,
            "company" => $request->company,
            "phone_num" => $request->phone_num,
            "email" => $request->email
        ]);

        return redirect('contact');
    }

    public function search(Request $request){
        $searchTerm = $request->data;
    $contacts = Contacts::where('name', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('company', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('phone_num', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                        ->paginate(5);

        return response()->json(['contacts' => $contacts]);
        
    }
}
