<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              お気に入り一覧 
            </h2>
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
                                    @if (App::environment('local'))
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="{{ asset('storage/'.$board->img_path) }}" alt="blog">
                                    @else
                                        <img class="lg:h-48 md:h-36 w-full object-cover object-center" src="https://workshub.s3.ap-northeast-1.amazonaws.com/{{ $board->img_path }}" alt="blog">
                                    @endif
                                    <div class="p-6">
                                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $board->user->name }}さん</h2>
                                        <h1 class="title-font text-lg font-medium text-gray-900">
                                            {{ $board->title }} 
                                            <small>
                                                <a href="{{ route('boards.show', ['id' => $board->id ]) }}" class="text-right inline-block text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">作品詳細
                                                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M5 12h14"></path>
                                                        <path d="M12 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </small>
                                        </h1>
                                        <a href="{{ $board->url }}" class="text-indigo-500 inline-flex items-center md:mb-3 lg:mb-0" target="_blank">{{ $board->url }}</a>
                                        <div class="float-right flex items-center flex-wrap mt-3">
                                            @if($board->is_bookmarked_by_auth_user())
                                                <a href="{{ route('boards.unbookmark', ['id' => $board->id]) }}" class="btn tbtn-success btn-sm">
                                                    <i class='fa-solid fa-star'></i>
                                                </a>
                                            @else
                                                <a href="{{ route('boards.bookmark', ['id' => $board->id]) }}" class="btn tbtn-success btn-sm">
                                                    <i class='fa-regular fa-star'></i>
                                                </a>
                                            @endif
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
