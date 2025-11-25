<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiscTooManyRequest extends Controller
{
  public function index()
  {
    return view('content.pages.page-misc-too-many-request');
  }
}
