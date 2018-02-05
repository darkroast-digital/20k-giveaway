<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contact;
use App\Models\Temp;
use Mailgun\Mailgun;


class HomeController extends Controller
{
    public function index($request, $response, $args)
    {
        $numContacts = count(Contact::get()->where('name', '!=', NULL));
        $tempCount = count(Temp::get());
        // $spotsLeft = 50 - $numContacts - $tempCount;

        $spotsLeft = 0;

        return $this->view->render($response, 'home.twig');
    }

    public function post($request, $response, $args)
    {
        //
    }
}
