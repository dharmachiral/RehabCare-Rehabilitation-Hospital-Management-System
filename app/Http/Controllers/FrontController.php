<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Testimonial\Entities\Testimonial;
use Modules\Blog\Entities\Blog;
use Modules\Team\Entities\Team;
use Modules\Service\Entities\Service;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Entities\GalleryCategory;
use Modules\Setting\Entities\CompanyProfile;
use Modules\CompanyProfile\Entities\Setting;
use Modules\Slider\Entities\Slider;
use Modules\Faq\Entities\Faq;
use Modules\Service\Entities\Baf;
use Modules\Treatment\Entities\Treatment;


class FrontController extends Controller
{
    public function index()
    {
        $data['testimonials'] = Testimonial::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['blog'] = Blog::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['blogs'] = Blog::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['teams'] = Team::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->take(3)->get();
        $data['baf'] = Baf::orderBy('created_at', 'DESC')->first();
        $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['galleries'] = Gallery::where('status', 'on')->get();
        $data['categories'] = GalleryCategory::where('status', 'on')->with('galleries')->orderby('created_at', 'DESC')->get();
        $data['profile'] = CompanyProfile::first();
        // $data['services'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->take(3)->get();
        // $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['profile'] = CompanyProfile::first();
        $data['slider'] = Slider::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['treatment'] = Treatment::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        return view('welcome',compact('data'));


    }
     public function about()
    {
        $data['profile'] = CompanyProfile::first();
        return view('frontend.pages.about', compact('data'));
     }
     public function contact()

    {
        $data['profile'] = CompanyProfile::first();
        // $data['profile'] = CompanyProfile::select('mission', 'vision', 'introduction')->first();
        return view('frontend.pages.contact',compact('data'));

     }
    public function service()
    {
        $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        $data['profile'] = CompanyProfile::first();
        $data['baf'] = Baf::orderBy('created_at', 'DESC')->first();

        // $data['services'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->take(3)->get();
        return view('frontend.pages.servicefront',compact('data'));
    }
    public function serviceDetails($id)
    {
        // Get the specific service detail
        $data['serviceDetail'] = Service::where('status', 'on')->where('id', $id)->first();

        // Get other services for the sidebar (excluding the current one)
        $data['servicefront'] = Service::where('status', 'on')
                                      ->where('id', '!=', $id)
                                      ->orderBy('created_at', 'DESC')
                                      ->get();
                                    //   $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->get();
                                      $data['profile'] = CompanyProfile::first();
        return view('frontend.pages.service_detail', compact('data'));
    }
    public function treatmentDetails($id)
    {
        // Get the specific service detail
        $data['treatmentdetail'] = Treatment::where('status', 'on')->where('id', $id)->first();

        // Get other services for the sidebar (excluding the current one)
        $data['treatment'] = Treatment::where('status', 'on')
                                      ->where('id', '!=', $id)
                                      ->orderBy('created_at', 'DESC')
                                      ->get();
                                    //   $data['servicefront'] = Service::where('status', 'on')->orderBy('created_at', 'DESC')->get();
                                      $data['profile'] = CompanyProfile::first();
        return view('frontend.pages.treatment_detail', compact('data'));
    }
    public function blog()
    {
        $data['profile'] = CompanyProfile::first();
        $data['blog'] = Blog::where('status', 'on')->orderBy('created_at', 'DESC')->get();

        return view('frontend.pages.blog',compact('data'));
    }
    // public function blogDetails()
    // {
    //     return view('frontend.pages.blog_details');
    // }
    public function blogDetails($id)
    {
        $data['profile'] = CompanyProfile::first();
        $data['blog'] = Blog::where('status', 'on')->orderBy('created_at', 'DESC')->where('id', $id)->first();
        $data['blogs'] = Blog::where('status', 'on')->orderBy('created_at', 'DESC')->whereNot('id', $id)->get();
        return view('frontend.pages.blog_details', compact('data'));
    }

    public function appointment()
    {

        $data['profile'] = CompanyProfile::first();
        return view('frontend.pages.appoinmentinfo',compact('data'));

    }
    public function gallery()
{
    $data['profile'] = CompanyProfile::first();
    $data['categories'] = GalleryCategory::where('status', 'on') ->with('galleries') ->orderBy('created_at', 'DESC')->get();
    $data['galleries'] = Gallery::where('status', 'on')->orderBy('created_at', 'DESC')->get();
    return view('frontend.pages.gallery', compact('data'));
}

    public function team()
    {
        $data['profile'] = CompanyProfile::first();
        $data['teams'] = Team::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        return view('frontend.pages.team',compact('data'));
    }
    public function teamDetails($id)
    {
        $data['profile'] = CompanyProfile::first();
        $data['team'] = Team::where('status', 'on')->orderBy('created_at', 'DESC')->where('id', $id)->first();
        $data['teams'] = Team::where('status', 'on')->orderBy('created_at', 'DESC')->whereNot('id', $id)->get();

        return view('frontend.pages.team_detail', compact('data'));
    }
    public function testimonial()
    {

        $data['profile'] = CompanyProfile::first();
        $data['testimonials'] = Testimonial::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        return view('frontend.pages.testimonial',compact('data'));
    }

    public function faq()
    {
        $data['profile'] = CompanyProfile::first();
        $data['faq'] = Faq::where('status', 'on')->orderBy('created_at', 'DESC')->get();
        return view('frontend.pages.faq',compact('data'));

    }
}
