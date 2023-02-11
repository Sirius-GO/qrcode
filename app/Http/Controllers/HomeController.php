<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\qr_codes;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        return view('welcome');
    }

    public function home()
    {

        $qr = qr_codes::where('user_id', Auth()->User()->id)->orderby('id', 'desc')->get();
        return view('home')->with('qr', $qr);
    }

    public function create(Request $request){

        //Get form inputs
        //$message = $request->input('message');
        $size = $request->input('size');
        $colorhex = $request->input('color');
        list($r, $g, $b) = sscanf($colorhex, "#%02x%02x%02x");
        $color = $r.', '.$g.', '.$b;
        $bcolorhex = $request->input('bcolor');
        list($r, $g, $b) = sscanf($bcolorhex, "#%02x%02x%02x");
        $bcolor = $r.', '.$g.', '.$b;        
        //$type = $request->input('type');
        //$image = $request->input('image');
        $rurl = $request->input('rurl');

        // $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        // $request->validate([
        //     'rurl' => 'required|regex:'.$regex,
        // ]);

        //Validate

        //Get last record ID
        $nid = qr_codes::orderby('id', 'desc')->limit(1)->pluck('id');

        //Insert into DB
        $qr = New qr_codes;
        $qr->user_id = Auth()->User()->id;
        $qr->message = 'https://' . $_SERVER['HTTP_HOST'] . '/dynamic_pages/qr_redirect_' . $nid[0] + 1 . '.html';
        $qr->size = $size;
        $qr->fcolor = $color;
        $qr->bcolor = $bcolor;
        $qr->rurl = $rurl;
        //$qr->type = $type;
        //$qr->logo = $image;
        $qr->save();

        //Create a new html landing page in the public folder with required redirect
        //Get the ID of the last record created by current user

        $id = qr_codes::where('user_id', Auth()->User()->id)->orderby('id', 'desc')->limit(1)->pluck('id');
        $myFile = "dynamic_pages/qr_redirect_" . $id[0] . ".html";
        $fh = fopen($myFile, 'w');
        $stringData = "<meta http-equiv='refresh' content='0; URL=$rurl' />" ;
        fwrite($fh, $stringData);
        fclose($fh);



        return redirect("/home")->with('success', 'You have successfully created a new QR Code!');


    }




    public function edit(Request $request){

        //Get form inputs
        $id = $request->input('rid');
        //$message = $request->input('message');
        $size = $request->input('size');
        $colorhex = $request->input('color');
        list($r, $g, $b) = sscanf($colorhex, "#%02x%02x%02x");
        $color = $r.', '.$g.', '.$b;
        $bcolorhex = $request->input('bcolor');
        list($r, $g, $b) = sscanf($bcolorhex, "#%02x%02x%02x");
        $bcolor = $r.', '.$g.', '.$b;        
        $rurl = $request->input('rurl');

        //Validate

        //Insert into DB
        $qr = qr_codes::find($id);
        $qr->user_id = Auth()->User()->id;
        $qr->message = 'https://' . $_SERVER['HTTP_HOST'] . '/dynamic_pages/qr_redirect_' . $id . '.html';
        $qr->size = $size;
        $qr->fcolor = $color;
        $qr->bcolor = $bcolor;
        $qr->rurl = $rurl;
        $qr->update();

        //Update the html landing page in the public folder with required redirect
        $myFile = "dynamic_pages/qr_redirect_" . $id . ".html";
        $fh = fopen($myFile, 'w');
        $stringData = "<meta http-equiv='refresh' content='0; URL=$rurl' />" ;
        fwrite($fh, $stringData);
        fclose($fh);

        return redirect("/home")->with('success', 'You have successfully updated your QR Code!');


    }


    public function delete(Request $request){
        
        $id = $request->input('rid');
        //return $id;

        try{ 
            $app = qr_codes::find($id);
            $app->delete();
        } catch (\Exception $e){
            return $e->getMessage();
        }
             
        return redirect('/home')->with('success', 'QR Code successfully Deleted');
    }







}
