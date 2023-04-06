<x-app-layout>
    <x-slot name="header">
        <div class='flex'>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                  作品一覧 
                </h2>
                <button class="mt-2 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                  <a href="{{ route('boards.create') }}" class="text-white-500">新規作成</a>
                </button>
            </div>
            <form class='flex lg:w-2/3 w-3/5 sm:flex-row sm:item-center items-start mx-auto' method='get' action="{{ route('boards.index') }}">
                <div class="relative flex-grow">
                    <input type="text" name="search" placeholder='作品名で検索' class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-transparent focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 ml-2 border border-blue-500 hover:border-transparent rounded">検索</button> 
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container mx-auto">
                        <div class="flex flex-wrap -m-4">
                        @foreach($boards as $board)
                            <div class="p-4 md:w-1/3">
                                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                                    <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ asset('storage/'.$board->img_path) }}" alt="blog">
                                    <div class="p-6">
                                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">No.{{ $board->id }}</h2>
                                        <h1 class="title-font text-lg font-medium text-gray-900">{{ $board->title }} ({{ $board->user->name }}さん)</h1>
                                        <a href="{{ $board->url }}" class="text-indigo-500 inline-flex items-center md:mb-3 lg:mb-0" target="_blank">{{ $board->url }}</a>
                                        <div class="flex items-center flex-wrap mt-3 ">
                                            <a href="{{ route('boards.show', ['id' => $board->id ]) }}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">作品詳細
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
                        {{ $boards->links() }}
                   </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
