<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApproachPillar;
use App\Models\ClienteleCriterion;
use App\Models\RetainerEngagement;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    /**
     * Show the WordPress-style Customize Page / Section Editor
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'hero');
        $settings = SiteSetting::orderBy('order')->get()->groupBy('group');
        $pillars = ApproachPillar::orderBy('order')->get();
        $criteria = ClienteleCriterion::orderBy('order')->get();
        $retainerLeft = RetainerEngagement::where('column_side', 'left')->orderBy('order')->get();
        $retainerRight = RetainerEngagement::where('column_side', 'right')->orderBy('order')->get();

        return view('admin.customize', compact(
            'activeTab',
            'settings',
            'pillars',
            'criteria',
            'retainerLeft',
            'retainerRight'
        ));
    }

    /**
     * Update Site Settings
     */
    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token', '_method', 'tab', 'hero_image_file', 'retainer_image_file', 'founder_image_file']);
        $tab = $request->input('tab', 'hero');

        // Handle image uploads
        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('uploads', 'public');
            SiteSetting::set('hero_image', '/storage/' . $path, 'hero', 'Hero Background Image', 'image');
        }

        if ($request->hasFile('retainer_image_file')) {
            $path = $request->file('retainer_image_file')->store('uploads', 'public');
            SiteSetting::set('retainer_image', '/storage/' . $path, 'retainer', 'Interior Still-Life Image', 'image');
        }

        if ($request->hasFile('founder_image_file')) {
            $path = $request->file('founder_image_file')->store('uploads', 'public');
            SiteSetting::set('founder_image', '/storage/' . $path, 'founder', 'Portrait Photograph', 'image');
        }

        // Save normal text/textarea settings
        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value;
                $setting->save();
            } else {
                SiteSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'group' => $tab,
                    'label' => ucwords(str_replace('_', ' ', $key)),
                    'type' => 'text',
                ]);
            }
        }

        return redirect()->route('admin.customize', ['tab' => $tab])
            ->with('success', 'Changes saved successfully and updated live on the website!');
    }

    /**
     * Update Approach Pillars
     */
    public function updatePillars(Request $request)
    {
        $pillarsData = $request->input('pillars', []);

        foreach ($pillarsData as $id => $p) {
            $pillar = ApproachPillar::find($id);
            if ($pillar) {
                $pillar->title = $p['title'] ?? $pillar->title;
                $pillar->description = $p['description'] ?? $pillar->description;
                if (!empty($p['icon_svg'])) {
                    $pillar->icon_svg = $p['icon_svg'];
                }
                $pillar->save();
            }
        }

        return redirect()->route('admin.customize', ['tab' => 'approach'])
            ->with('success', 'The Stonebridge Approach pillars updated successfully!');
    }

    /**
     * Update Clientele Criteria
     */
    public function updateCriteria(Request $request)
    {
        $criteriaData = $request->input('criteria', []);

        foreach ($criteriaData as $id => $c) {
            $criterion = ClienteleCriterion::find($id);
            if ($criterion) {
                $criterion->text = $c['text'] ?? $criterion->text;
                $criterion->is_active = isset($c['is_active']);
                $criterion->save();
            }
        }

        return redirect()->route('admin.customize', ['tab' => 'clientele'])
            ->with('success', 'Clientele criteria updated successfully!');
    }

    /**
     * Update Retainer Engagements
     */
    public function updateRetainers(Request $request)
    {
        $engagementsData = $request->input('engagements', []);

        foreach ($engagementsData as $id => $e) {
            $item = RetainerEngagement::find($id);
            if ($item) {
                $item->title = $e['title'] ?? $item->title;
                $item->save();
            }
        }

        return redirect()->route('admin.customize', ['tab' => 'retainer'])
            ->with('success', 'Retainer engagements updated successfully!');
    }
}
