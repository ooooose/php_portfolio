<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            掲示板一覧 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <button class="flex mt-16 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                        <a href="{{ route('boards.create') }}" class="text-white-500">新規作成</a>
                    </button>
                        <div class="container mx-auto">
                            <div class="flex flex-wrap -m-4">
                            @foreach($boards as $board)
                                <div class="p-4 md:w-1/3">
                                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ asset('storage/'.$board->img_path) }}" alt="blog">
                                        <div class="p-6">
                                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">No.{{ $board->id }}</h2>
                                            <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $board->title }}</h1>
                                            <p class="leading-relaxed mb-3">{{ $board->body }}</p>
                                            <div class="flex items-center flex-wrap ">
                                                <a href="{{ route('boards.show', ['id' => $board->id ]) }}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                                                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
