@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
<div>

    <div class="flex flex-1 space-x-4">
        <div class="mt-4">
            <x-jet-label for="filter" value="{{ __('Institutions') }}" />
            <select id="filter" name="filter" wire:model="filter" wire:change="updateFilter" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option>Select a filter</option>
                @foreach($institutions as $institution)
                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                @endforeach
            </select>
            @error('institution_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <x-jet-label for="range" value="{{ __('Range') }}" />
            <select id="range" name="range" wire:model="range" wire:change="updateFilter" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option>Select a range</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
            @error('range') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="mt-4">
            <button class="bg-mohs-green-500 hover:bg-mohs-green-700 text-white font-bold py-2 px-4 rounded" wire:click="resetChart">
                Reset
            </button>
        </div>
    </div>

    <div class="chart-container" style="width:100%;height: 400px;" wire:ignore>
        <canvas id="myChart"></canvas>
    </div>
</div>

@push('footerScripts')
<script>
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            datasets: {!! $ticks !!}
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            parsing: {
                xAxisKey: 'id',
                yAxisKey: 'nested.value'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    Livewire.on('updatedFilter', ticks => {
        myChart.data.datasets = JSON.parse(ticks);
        myChart.update();
    });

    Livewire.on('updatedSection', ticks => {
        myChart.data.datasets = JSON.parse(ticks);
        myChart.update();
    });

    Livewire.on('resetChart', ticks => {
        myChart.data.datasets = JSON.parse(ticks);
        myChart.update();
    });

</script>
@endpush