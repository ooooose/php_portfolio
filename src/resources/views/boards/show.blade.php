<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            作品詳細画面 
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container mx-auto flex px-5 md:flex-row flex-col items-center">
                            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                            @if (App::environment('local'))
                                <img class="object-cover object-center rounded" alt="hero" src="{{ asset('storage/'.$board->img_path) }}">
                            @else
                                <img class="object-cover object-center rounded" alt="hero" src="https://workshub.s3.ap-northeast-1.amazonaws.com/{{ $board->img_path }}">
                            @endif
                            </div>
                            <div class="lg:flex-grow md:w-1/2 md:pl-16 flex flex-col md:items-start md:text-left text-center">
                            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                                {{ $board->title }}
                            </h1>
                            <p class="leading-relaxed">{{ $board->user->name }}さん</p>
                            <a class="text-indigo-500 inline-flex items-center" href="{{ $board->url }}" target="__blank">{{ $board->url }}</a> 
                            <p class="mb-8 leading-relaxed">{{ $board->description }}</p>
                            @if (Auth::user()->id == $board->user->id )
                                <div class="flex justify-center">
                                    <form method='get' action="{{ route('boards.edit', [ 'id' => $board->id ]) }}">
                                        <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集</button>
                                    </form>
                                    <form method="post" action="{{ route('boards.destroy', [ 'id' => $board->id ]) }}" id="delete_{{ $board->id }}">
                                    @csrf
                                        <a href="#" class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg" data-id="{{ $board->id }}" onclick="deletePost(this)" >削除</a>
                                    </form>
                                </div>
                            @endif
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(e){
            'use strict'
            if(confirm('本当に削除していいですか？')){
                document.getElementById('delete_' + e.dataset.id).submit() 
            } 
        }
    </script> 
</x-app-layout>
