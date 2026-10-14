<x-layout>
  @foreach ($jobs as $job)
    <x-card class="mb-4">
      <div class="mb-4 flex justify-between">
        <h2 class="text-lg font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">
          ${{ number_format($job->salary) }}
        </div>
      </div>
    </x-card>
  @endforeach
</x-layout>
