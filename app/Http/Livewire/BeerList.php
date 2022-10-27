<?php

namespace App\Http\Livewire;

use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use App\Models\Meal;
use App\Services\PunkapiService;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Livewire\Component;

class BeerList extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $beerName;

    public $food;

    public $ibu;

    public array $beerList = [];

    public function mount(PunkapiService $service): void
    {
        $this->form->fill([
            'beerName' => $this->beerName,
            'food' => $this->food,
            'ibu' => $this->ibu,
        ]);

        $this->beerList = $service->getBeers();
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make()->schema([

                //name
                TextInput::make('beerName')
                    ->label('Beer Name')
                    ->placeholder('Ex: Alpha Dog')
                    ->columnSpan([
                        'default' => 4,
                        'sm' => 4,
                        'xl' => 2,
                        '2xl' => 2,
                    ]),

                //food
                Select::make('food')
                    ->options(Meal::get()->pluck('name', 'name'))
                    ->columnSpan([
                        'default' => 4,
                        'sm' => 4,
                        'xl' => 1,
                        '2xl' => 1,
                    ]),

                //ibu
                TextInput::make('ibu')
                    ->label('IBU')
                    ->placeholder('Ex: 40')
                    ->numeric()
                    ->columnSpan([
                        'default' => 4,
                        'sm' => 4,
                        'xl' => 1,
                        '2xl' => 1,
                    ]),
            ])
            ->columns([
                'default' => 1,
                'sm' => 1,
                'xl' => 4,
                '2xl' => 4,
            ]),
        ];
    }

    private function getBeers(PunkapiService $service): void
    {
        $this->beerList = $service->getBeers(
            beer_name: $this->beerName,
            food: $this->food,
            ibu_gt: $this->ibu
        );
    }

    public function submit(PunkapiService $service): void
    {
        $this->getBeers($service);
    }

    public function formReset(PunkapiService $service)
    {
        $this->beerName = null;
        $this->food = null;
        $this->ibu = null;

        $this->getBeers($service);
    }

    public function export(PunkapiService $service)
    {
        $filename = 'beers-found-'.now()->format('Y-m-d - H_i').'.xlsx';

        $request = [
            'beer_name' => $this->beerName,
            'food' => $this->food,
            'ibu_gt' => $this->ibu,
        ];

        ExportJob::withChain([
            new StoreExportDataJob(auth()->user(), $filename),
            new SendExportEmailJob(auth()->user(), $filename),
        ])->dispatch($request, $filename);

        Notification::make()
            ->title('Exported successfully')
            ->body('You will receive an email notification with your beer list!')
            ->success()
            ->send();
    }

    public function render()
    {
        return view('livewire.beer-list');
    }
}
