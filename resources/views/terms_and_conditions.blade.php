<x-app-layout>
    <div class="max-w-6xl my-4 px-2  mx-auto">
        {{ $terms->version ?? "No data" }}
        {!! $terms->content ?? "No data" !!}
    </div>
</x-app-layout>