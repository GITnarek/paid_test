<?php

namespace App\Http\Controllers;

use App\Http\Requests\BuyRequest;
use App\Http\Requests\ChangeColorRequest;
use App\Models\Taxi;
use App\Models\UserTaxi;
use App\Services\TaxiColorService;
use App\Services\TaxiService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private TaxiColorService $taxiColorService;
    private TaxiService $taxiService;

    /**
     * @param TaxiColorService $taxiColorService
     * @param TaxiService $taxiService
     */
    public function __construct(TaxiColorService $taxiColorService, TaxiService $taxiService)
    {
        $this->taxiColorService = $taxiColorService;
        $this->taxiService = $taxiService;
    }

    /**
     * @return Factory|\Illuminate\Foundation\Application|View|Application
     */
    public function home(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $taxis = Taxi::all();

        return view('taxi_list', [
            'taxis' => $taxis
        ]);
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function list(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $user = Auth::user();

        // Ensure user is authenticated and retrieve their purchased taxis
        $userTaxis = $user ? $user->taxis : [];
        return view('taxi_purchased', [
            'userTaxis' => $userTaxis,
        ]);
    }

    /**
     * @param BuyRequest $request
     * @param Taxi $taxi
     * @return RedirectResponse
     */
    public function buy(BuyRequest $request, Taxi $taxi): RedirectResponse
    {
        $user = auth()->user();
        $process = $this->taxiService->validateAndBuy($user, $taxi);

        if ($process !== true) {
            return redirect()->route('app')->with('error', $process);
        }

        return redirect()->route('app')->with('success', 'Вы приобрели машину');
    }

    /**
     * @param ChangeColorRequest $request
     * @param UserTaxi $taxi
     * @return RedirectResponse
     */
    public function changeColor(ChangeColorRequest $request, UserTaxi $taxi): RedirectResponse
    {
        $newColor = $request->validated()['new_color'];

        $user = auth()->user();

        $result =  $this->taxiColorService->validateAndChangeColor($user, $taxi, $newColor);

        if ($result === true) {
            return redirect()->back()->with('success', 'Color changed successfully.');
        } else {
            return redirect()->back()->with('error', $result);
        }
    }
}
