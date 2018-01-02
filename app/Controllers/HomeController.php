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
        $spotsLeft = 25 - $numContacts - $tempCount;

        // if ($numContacts > 25) {
        //     $spotsLeft = $numContacts % 25;
        //     $spotsLeft = 25 - $spotsLeft;
        // }

        return $this->view->render($response, 'home.twig', compact('spotsLeft', 'numContacts'));
    }

    public function post($request, $response, $args)
    {
        //
    }
}
