<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contact;
use App\Models\Temp;
use Mailgun\Mailgun;

class SiteController extends Controller
{
    public function form($request, $response, $args)
    {
        header("refresh:1200;url=/");
        
        $count = count(Contact::get()->where('name', '!=', NULL));
        $tempCount = count(Temp::get());
        $total = $count + $tempCount;
        if (($count >= 1) || ($total >= 1)) {
            return $response->withRedirect($this->router->pathFor('noSpots'));
        }

        return $this->view->render($response, 'form.twig');
    }

    public function success($request, $response, $args)
    {
        return $this->view->render($response, 'success.twig');
    }

    public function noSpots($request, $response, $args)
    {
        return $this->view->render($response, 'no-spots.twig');
    }

    public function count($request, $response, $args)
    {
        $count = count(Contact::get()->where('name', '!=', NULL));
        $tempCount = count(Temp::get());
        $total = $count + $tempCount;
        if (($count >= 1) || ($total >= 1)) {
            return $response->withRedirect($this->router->pathFor('noSpots'));
        }

        $spotsLeft = 1 - $total;

        return $this->view->render($response, 'count.twig', compact('spotsLeft'));
    }

    public function batchSend($request, $response, $args)
    {
        $mg = Mailgun::create('key-1715c074f053673f6e3c4c79e8595390');

        $clients = Contact::where('name', NULL)->get();
        $to = array();

        foreach($clients as $c) {
            array_push($to, $c->email);
        }

        $orderBody = $this->view->fetch('mail/batch.twig');

        $mg->messages()->send('darkroast.co', [
          'from'    => '20k@darkroast.co',
          'to'      => $to,
          'subject' => '20K Giveaway - New spots have opened up for ' . date('l, F jS') . '!',
          'html'    => $orderBody
        ]);
    }
}

