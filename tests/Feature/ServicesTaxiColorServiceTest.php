<?php

namespace Tests\Feature;

use App\Models\Taxi;
use App\Models\User;
use App\Models\UserTaxi;
use App\Services\TaxiColorService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ServicesTaxiColorServiceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test changing color of taxi with available credits and valid color.
     *
     * @return void
     */
    public function testChangeColorWithValidColorAndCredits(): void
    {
        $user = User::factory()->create(['credit' => 2000]);

        $taxi = Taxi::factory()->create();

        $userTaxi = UserTaxi::factory()->create(['user_id' => $user->id, 'taxi_id' => $taxi->id]);

        $result = TaxiColorService::validateAndChangeColor($user, $userTaxi, 'blue');

        $this->assertTrue($result);
    }

    /**
     * Test changing color of taxi with insufficient credits.
     *
     * @return void
     */
    public function testChangeColorWithInsufficientCredits(): void
    {
        $user = User::factory()->create(['credit' => 500]);

        $taxi = Taxi::factory()->create();

        $userTaxi = UserTaxi::factory()->create(['user_id' => $user->id, 'taxi_id' => $taxi->id]);

        $result = TaxiColorService::validateAndChangeColor($user, $userTaxi, 'blue');

        $this->assertEquals('Not enough credits to change color.', $result);
    }

}
