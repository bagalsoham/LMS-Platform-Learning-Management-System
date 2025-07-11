<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Withdraw;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WithdrawController extends Controller
{
    function index(): View
    {
        return view('frontend.instructor.withdraw.index');
    }

    function requestPayoutIndex(): View
    {
        $currentBallance = user()->wallet;
        $pendingBallance = Withdraw::where('instructor_id', user()->id)->where('status', 'pending')->sum('amount');
        $totalPayout = Withdraw::where('instructor_id', user()->id)->where('status', 'approved')->sum('amount');

        return view('frontend.instructor.withdraw.request-payout', compact('currentBallance', 'pendingBallance', 'totalPayout'));
    }

    function requestPayout(Request $request): RedirectResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Check if user has gateway information set up
        if (!user()->gatewayInfo) {
            notyf()->error("Please set up your payout gateway information first!");
            return redirect()->route('instructor.profile.index');
        }

        if (user()->wallet < $request->amount) {
            notyf()->error("Insufficient Balance!");
            return redirect()->back();
        }

        if (Withdraw::where('instructor_id', user()->id)->where('status', 'pending')->exists()) {
            notyf()->error("Withdraw Request Already Pending!");
            return redirect()->back();
        }

        $withdraw = new Withdraw();
        $withdraw->instructor_id = user()->id;
        $withdraw->amount = $request->amount;
        $withdraw->save();

        notyf()->success("Withdraw Request Sent!");
        return redirect()->back();
    }
}
