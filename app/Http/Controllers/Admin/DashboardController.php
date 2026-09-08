<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApproachPillar;
use App\Models\ClienteleCriterion;
use App\Models\PrivateInquiry;
use App\Models\RetainerEngagement;
use App\Models\SiteSetting;
use App\Models\SubPage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInquiries = PrivateInquiry::count();
        $newInquiries = PrivateInquiry::where('status', 'new')->count();
        $recentInquiries = PrivateInquiry::latest()->take(5)->get();
        $subPagesCount = SubPage::count();
        $pillarsCount = ApproachPillar::count();
        $criteriaCount = ClienteleCriterion::count();
        $retainersCount = RetainerEngagement::count();

        $brandName = SiteSetting::get('brand_name', 'Stonebridge Advisory');

        return view('admin.dashboard', compact(
            'totalInquiries',
            'newInquiries',
            'recentInquiries',
            'subPagesCount',
            'pillarsCount',
            'criteriaCount',
            'retainersCount',
            'brandName'
        ));
    }
}
