<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VanLog;
use App\Models\Vehicle;

class VanLogs extends Component
{
    public $vehicles = [];
    public $vehicle_id;
    public $vehicle_mileage;

    public $oil_level_action;
    public $oil_level_signed;
    public $water_level_action;
    public $water_level_signed;
    public $tyres_action;
    public $tyres_signed;
    public $screen_action;
    public $screen_signed;
    public $vehicle_defects;

    public $vanItems = [];
    public $ppeItems = [];

    public $loading = false;
    public $error = null;
    public $success = null;

    public function mount()
    {
        $this->loading = true;
        try {
            $this->vehicles = Vehicle::orderBy('registration')->get();
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'An error occurred while fetching vehicles.';
            $this->vehicles = collect([]);
        }
        $this->loading = false;

        $this->vanItems = [
            ['label' => 'Ladder/Steps', 'checked' => false, 'signed' => '', 'date' => ''],
            ['label' => 'Vacuum', 'checked' => false, 'signed' => '', 'date' => ''],
            ['label' => 'Tools on Van', 'checked' => false, 'signed' => '', 'date' => ''],
            ['label' => 'Fire Extinguisher Expiry Date', 'checked' => false, 'signed' => '', 'date' => ''],
        ];

        $this->ppeItems = [
            ['label' => 'First Aid Kit', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Fire Extinguisher', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Accident Book', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Eye Wash', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Company ID', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Safety Boots', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Safety Goggles', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Hi-Vision Jacket', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Gloves', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
            ['label' => 'Hard Hat', 'actual' => 0, 'checked' => false, 'signed' => '', 'defects' => ''],
        ];
    }

    public function updatedVehicleId($value)
    {
        $this->loading = true;
        try {
            $vehicle = Vehicle::find($value);
            if ($vehicle) {
                $this->vehicle_mileage = $vehicle->mileage;
            } else {
                $this->vehicle_mileage = null;
            }
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'An error occurred while fetching vehicle details.';
        }
        $this->loading = false;
    }

    public function save()
    {
        $this->loading = true;
        try {
            $this->validate([
                'vehicle_id' => 'required|exists:vehicles,id',
            ]);

            VanLog::create([
                'vehicle_id' => $this->vehicle_id,
                'user_id' => auth()->id(),
                'vehicle_mileage' => $this->vehicle_mileage,

                'oil_level_action' => $this->oil_level_action,
                'oil_level_signed' => $this->oil_level_signed,
                'water_level_action' => $this->water_level_action,
                'water_level_signed' => $this->water_level_signed,
                'tyres_action' => $this->tyres_action,
                'tyres_signed' => $this->tyres_signed,
                'screen_action' => $this->screen_action,
                'screen_signed' => $this->screen_signed,
                'vehicle_defects' => $this->vehicle_defects,

                'van_items_check' => $this->vanItems,
                'ppe_check' => $this->ppeItems,
            ]);

            $this->success = 'Van Log saved successfully.';
            $this->error = null;
        } catch (\Exception $e) {
            $this->error = 'An error occurred while saving the van log.';
        }
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.van-logs');
    }
}
