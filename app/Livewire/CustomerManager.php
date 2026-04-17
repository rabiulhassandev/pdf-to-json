<?php

namespace App\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerManager extends Component
{
    use WithPagination;

    public $name, $email, $phone, $company_name, $extraction_notes;
    public $customerId;
    public $isModalOpen = false;

    public function render()
    {
        return view('livewire.customer-manager', [
            'customers' => Customer::paginate(10),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->company_name = '';
        $this->extraction_notes = '';
        $this->customerId = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $this->customerId,
            'phone' => 'nullable',
            'company_name' => 'nullable',
            'extraction_notes' => 'nullable',
        ]);

        Customer::updateOrCreate(['id' => $this->customerId], [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_name' => $this->company_name,
            'extraction_notes' => $this->extraction_notes,
        ]);

        session()->flash('message', $this->customerId ? 'Customer updated successfully.' : 'Customer created successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customerId = $id;
        $this->name = $customer->name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->company_name = $customer->company_name;
        $this->extraction_notes = $customer->extraction_notes;

        $this->openModal();
    }

    public function delete($id)
    {
        Customer::find($id)->delete();
        session()->flash('message', 'Customer deleted successfully.');
    }
}
