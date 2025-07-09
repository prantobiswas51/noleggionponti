<x-app-layout>
    <div class="max-w-6xl my-4 mx-auto">
        {{ $policy->version ?? "No data" }}
        {!! $policy->content ?? "No data" !!}
    </div>
</x-app-layout>