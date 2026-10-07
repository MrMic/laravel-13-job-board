<x-layout>
  @foreach ($jobs as $job)
    <div class="job-card">
      <h2>{{ $job->title }}</h2>
    </div>
  @endforeach

</x-layout>
