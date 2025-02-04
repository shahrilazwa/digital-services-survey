<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function dashboardOverview1(): View
    {
        return view('pages/dashboard-overview-1');
    }

    public function dashboardOverview2(): View
    {
        return view('pages/dashboard-overview-2');
    }

    public function dashboardOverview3(): View
    {
        return view('pages/dashboard-overview-3');
    }

    public function dashboardOverview4(): View
    {
        return view('pages/dashboard-overview-4');
    }

    public function inbox(): View
    {
        return view('pages/inbox');
    }

    public function categories(): View
    {
        return view('pages/categories');
    }

    public function addProduct(): View
    {
        return view('pages/add-product');
    }

    public function productList(): View
    {
        return view('pages/product-list');
    }

    public function productGrid(): View
    {
        return view('pages/product-grid');
    }

    public function transactionList(): View
    {
        return view('pages/transaction-list');
    }

    public function transactionDetail(): View
    {
        return view('pages/transaction-detail');
    }

    public function sellerList(): View
    {
        return view('pages/seller-list');
    }

    public function sellerDetail(): View
    {
        return view('pages/seller-detail');
    }

    public function reviews(): View
    {
        return view('pages/reviews');
    }

    public function fileManager(): View
    {
        return view('pages/file-manager');
    }

    public function pointOfSale(): View
    {
        return view('pages/point-of-sale');
    }

    public function chat(): View
    {
        return view('pages/chat');
    }

    public function post(): View
    {
        return view('pages/post');
    }

    public function calendar(): View
    {
        return view('pages/calendar');
    }

    public function crudDataList(): View
    {
        return view('pages/crud-data-list');
    }

    public function crudForm(): View
    {
        return view('pages/crud-form');
    }

    public function usersLayout1(): View
    {
        return view('pages/users-layout-1');
    }

    public function usersLayout2(): View
    {
        return view('pages/users-layout-2');
    }

    public function usersLayout3(): View
    {
        return view('pages/users-layout-3');
    }

    public function profileOverview1(): View
    {
        return view('pages/profile-overview-1');
    }

    public function profileOverview2(): View
    {
        return view('pages/profile-overview-2');
    }

    public function profileOverview3(): View
    {
        return view('pages/profile-overview-3');
    }

    public function wizardLayout1(): View
    {
        return view('pages/wizard-layout-1');
    }

    public function wizardLayout2(): View
    {
        return view('pages/wizard-layout-2');
    }

    public function wizardLayout3(): View
    {
        return view('pages/wizard-layout-3');
    }

    public function blogLayout1(): View
    {
        return view('pages/blog-layout-1');
    }

    public function blogLayout2(): View
    {
        return view('pages/blog-layout-2');
    }

    public function blogLayout3(): View
    {
        return view('pages/blog-layout-3');
    }

    public function pricingLayout1(): View
    {
        return view('pages/pricing-layout-1');
    }

    public function pricingLayout2(): View
    {
        return view('pages/pricing-layout-2');
    }

    public function invoiceLayout1(): View
    {
        return view('pages/invoice-layout-1');
    }

    public function invoiceLayout2(): View
    {
        return view('pages/invoice-layout-2');
    }

    public function faqLayout1(): View
    {
        return view('pages/faq-layout-1');
    }

    public function faqLayout2(): View
    {
        return view('pages/faq-layout-2');
    }

    public function faqLayout3(): View
    {
        return view('pages/faq-layout-3');
    }

    public function login(): View
    {
        return view('public/login');
    }

    public function dashboard(): View
    {
        $breadcrumbs = [
            ['label' => 'Survey App', 'url' => route('dashboard'), 'active' => true],
        ];
        return view('auth/admin/dashboard', compact('breadcrumbs'));
    }

    public function register(): View
    {
        return view('pages/register');
    }

    public function errorPage(): View
    {
        return view('pages/error-page');
    }

    public function updateProfile(): View
    {
        return view('pages/update-profile');
    }

    public function changePassword(): View
    {
        return view('pages/change-password');
    }

    public function regularTable(): View
    {
        return view('pages/regular-table');
    }

    public function tabulator(): View
    {
        return view('pages/tabulator');
    }

    public function modal(): View
    {
        return view('pages/modal');
    }

    public function slideOver(): View
    {
        return view('pages/slide-over');
    }

    public function notification(): View
    {
        return view('pages/notification');
    }

    public function tab(): View
    {
        return view('pages/tab');
    }

    public function accordion(): View
    {
        return view('pages/accordion');
    }

    public function button(): View
    {
        return view('pages/button');
    }

    public function alert(): View
    {
        return view('pages/alert');
    }

    public function progressBar(): View
    {
        return view('pages/progress-bar');
    }

    public function tooltip(): View
    {
        return view('pages/tooltip');
    }

    public function dropdown(): View
    {
        return view('pages/dropdown');
    }

    public function typography(): View
    {
        return view('pages/typography');
    }

    public function icon(): View
    {
        return view('pages/icon');
    }

    public function loadingIcon(): View
    {
        return view('pages/loading-icon');
    }

    public function regularForm(): View
    {
        return view('pages/regular-form');
    }

    public function datepicker(): View
    {
        return view('pages/datepicker');
    }

    public function tomSelect(): View
    {
        return view('pages/tom-select');
    }

    public function fileUpload(): View
    {
        return view('pages/file-upload');
    }

    public function wysiwygEditorClassic(): View
    {
        return view('pages/wysiwyg-editor-classic');
    }

    public function wysiwygEditorInline(): View
    {
        return view('pages/wysiwyg-editor-inline');
    }

    public function wysiwygEditorBalloon(): View
    {
        return view('pages/wysiwyg-editor-balloon');
    }

    public function wysiwygEditorBalloonBlock(): View
    {
        return view('pages/wysiwyg-editor-balloon-block');
    }

    public function wysiwygEditorDocument(): View
    {
        return view('pages/wysiwyg-editor-document');
    }

    public function validation(): View
    {
        return view('pages/validation');
    }

    public function chart(): View
    {
        return view('pages/chart');
    }

    public function slider(): View
    {
        return view('pages/slider');
    }

    public function imageZoom(): View
    {
        return view('pages/image-zoom');
    }
}
