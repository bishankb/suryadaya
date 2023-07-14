<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialMedia;
use App\Notifications\ViewerMailNotification;
use App\Mail\ViewerMailMailable;
use Mail;
use Notification;
use App\User;
use SEOMeta;
use OpenGraph;

class ContactUsController extends Controller
{
    public function index()
    {
        $this->seoIndex();

        $social_medias = SocialMedia::where('status', 1)->get();

        return view('frontend.contact-us.index', compact('social_medias'));
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'name'    => 'required|min:2|max:255', 
            'email'   => 'required|email|min:2|max:255', 
            'phone'   => 'nullable|min:5|max:20', 
            'address' => 'nullable|min:2|max:255', 
            'subject' => 'nullable|min:2|max:255', 
            'message' => 'required|min:5|max:655356', 
        ]);

        try {
            $viewer_message = new \stdClass();
            $viewer_message->name = request('name');
            $viewer_message->email = request('email');
            $viewer_message->phone = request('phone');
            $viewer_message->address = request('address');
            $viewer_message->subject = request('subject');
            $viewer_message->message = request('message');

            Mail::to(env('APP_EMAIL'))->send(new ViewerMailMailable($viewer_message));

            $message_viewers = User::whereHas('role', function ($r) {
                                $r->whereIn('name', config('suryadaya.message_viewer'));
                            })->get();

            Notification::send($message_viewers, new ViewerMailNotification(request('name')));

            $notification = array(
                'message'    => 'Message sent successfully. Please wait for response.',
                'alert-type' => 'success'
            );
         

        } catch (Exception $e) {
            logger()->error($exception->getMessage());
            
            $notification = array(
                'message'    => 'Internal Error, Please try again later.',
                'alert-type' => 'error'
            ); 
        }

        return redirect()->route('contact-us.index')->with($notification);
    }

    private function seoIndex()
    {
        SEOMeta::setTitle('Contact Us - '.env('APP_NAME'));
        SEOMeta::setDescription(env('APP_NAME').' -Send your query to us from the form. See our location in the map. Follow us on social medias.');
        SEOMeta::setCanonical(route('contact-us.index'));
        SEOMeta::addKeyword(['suryodaya', 'suryadaya', 'zerone technology', 'nepal', 'sahakari', 'syangja', 'pokhara', 'kathmandu', 'contact', 'facebook', 'instagram', 'youtube']);
        
        OpenGraph::setTitle('Contact Us - '.env('APP_NAME'));
        OpenGraph::setDescription(env('APP_NAME').' -Send your query to us from the form. See our location in the map. Follow us on social medias.');
        OpenGraph::setUrl(route('contact-us.index'));
    }
}