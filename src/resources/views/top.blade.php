<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WorksHub') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">


        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
      <div class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
          <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <section class="text-gray-600 body-font">
              <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
                <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
                  <img class="object-cover object-center rounded" alt="hero" src="{{ asset('img/top_image.png') }}">
                </div>
                <div class="lg:flex-grow md:w-1/2 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
                  <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">多くの作品に触れ、
                    <br class="hidden lg:inline-block">新たな創造へ！
                  </h1>
                  <p class="mb-8 leading-relaxed">本サービスはポートフォリオとして作成したwebアプリケーションを一元的に管理するアプリです。ご自身で作成したポートフォリオを登録するほか、他の方が作成したポートフォリオも閲覧できるようになっております。多くのアイデアに触れることで新たな創造へのヒントにしましょう！</p>
                  <div class="flex justify-center">
                    @if (Route::has('login'))
                        @auth
                            <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                              <a href="{{ route('boards.index') }}" class="text-white-500">作品一覧</a>
                            </button>
                        @else
                            <button class="inline-flex text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                              <a href="{{ route('login') }}" class="text-white-500">ログイン</a>
                            </button>
                            @if (Route::has('register'))
                                <button class="ml-4 inline-flex text-gray-700 bg-gray-100 border-0 py-2 px-6 focus:outline-none hover:bg-gray-200 rounded text-lg">
                                  <a href="{{ route('register') }}" class="text-white-500">新規登録</a>
                                </button>
                            @endif
                        @endauth
                    @endif
                  </div>
                </div>
              </div>
            </section>
          </div>
      </div>
    </body>
</html>
