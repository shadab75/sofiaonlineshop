<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    //
    public function index()
    {

    $contactus = ContactUs::latest()->paginate(20);
    return view('admin.contactus.index',compact('contactus'));
    }

    public function show(ContactUs $form)
    {

        return view('admin.contactus.show',compact('form'));

    }
}
