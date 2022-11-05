<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Services\ContactService;

class HomeController extends Controller
{
    /**
     * Contact Service Manipulation
     *
     * @param ContactService $contactService
     */
    public function __construct(
        private ContactService $contactService
    )
    {
        $this->middleware('auth')->only([
            'dashboard',
            'store'
        ]);
    }

    public function home()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function about()
    {
        return view('pages.about');
    }

    // contact
    public function contact()
    {
        return view('pages.contact');
    }
    public function store(ContactRequest $request)
    {
        $data = ['user_id' => auth()->id() ] + $request->validated();
        $this->contactService->store($data);
        return redirect()->route('contact.index')->with('alert-success', 'Thanks for Your feedback !');
    }
    public function admin()
    {
        return view('pages.admin');
    }
}
