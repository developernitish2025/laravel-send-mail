<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use Mail;

class ContactController extends Controller {
    public function showForm() {
        return view( 'contact' );
    }

    public function submitForm( Request $request ) {
        $validated = $request->validate( [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string'
        ] );

        try {
            Mail::to( 'your@email.com' )->send( new ContactFormMail( $validated ) );

            return response()->json( [
                'status' => 'success',
                'message' => 'Thank you for your message. We will contact you soon!'
            ] );
        } catch ( \Exception $e ) {
            \Log::error( 'Contact form error: ' . $e->getMessage() );
            return response()->json( [
                'status' => 'error',
                'message' => 'Sorry, something went wrong. Please try again later.'
            ], 500 );
        }
    }
}
