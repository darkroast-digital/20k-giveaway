<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contact;
use App\Models\Subscription;
use Mailgun\Mailgun;

class FormController extends Controller
{
    public function index($request, $response, $args)
    {
        $params = $request->getParams();

        $count = count(Contact::get()->where('name', '!=', NULL));

        if ($count >= 50) {
            return $response->withRedirect($this->router->pathFor('noSpots'));
        }

        $contact = Contact::where('email', $params['email'])->first();

        $subscribed = 0;

        if (isset($params['subscribe'])) {
            $subscribed = 1;
        }

        if ($contact === null) {
            $contact = Contact::create([
                'name' => $params['name'],
                'email' => $params['email'],
                'phone' => $params['phone'],
                'subscribed' => $subscribed
            ]);

            $contact->save();
        } elseif ($contact->name === NULL) {
            $contact->name = $params['name'];
            $contact->phone = $params['phone'];

            $contact->save();
        }

        $mg = Mailgun::create('key-1715c074f053673f6e3c4c79e8595390');

        $orderBody = $this->view->fetch('mail/order.twig', compact('contact', 'params'));

        $mg->messages()->send('darkroast.co', [
          'from'    => '20k@darkroast.co',
          'to'      => 'hi@darkroast.co',
          'subject' => 'New logo order from ' . $contact->name,
          'html'    => $orderBody
        ]);

        $confirmBody = $this->view->fetch('mail/confirmation.twig', compact('contact', 'params'));

        $mg->messages()->send('darkroast.co', [
          'from'    => 'hi@darkroast.co',
          'to'      => $contact->email,
          'subject' => 'Thank you for your order, ' . $contact->name,
          'html'    => $confirmBody
        ]);


        return $response->withRedirect($this->router->pathFor('success'));
    }

    public function subscribe($request, $response, $args)
    {
        $params = $request->getParams();

        $subscribed = 0;

        if (isset($params['subscribe'])) {
            $subscribed = 1;
        }

        $contact = Contact::where('email', $params['email'])->first();

        if ($contact === null) {
            $contact = Contact::create([
                'email' => $params['email'],
                'subscribed' => $subscribed
            ]);

            $contact->save();
        } else {
            $contact->subscribed = $subscribed;
            $contact->save();
        }

        $this->flash->addMessage('info', 'Thank you. You will be notified when the next session opens.');

        return $response->withRedirect($this->router->pathFor('home'));
    }

}

