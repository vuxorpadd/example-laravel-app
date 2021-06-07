@extends('layout.main')

@section('content')
    <div class="p-4">
        <div class="mb-4">
            <h3 class="px-2 text-xl">Hey! You've asked us to send you your wishlist. Here you go:</h3>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
            @foreach($wishlist->books as $book)
                <div
                    class="inline-flex p-2 bg-gray-50 rounded-md shadow-md hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <div class="flex md:space-y-4 md:block gap-4">
                        <a href={{ route("books.show", ['book' => $book] )}}>
                            <img src="{{ $book->cover_path ? $message->embed($book->cover_path) : $book->cover_url }}"
                                 alt="Book cover"
                                 class="w-32 md:mx-auto md:w-full"
                            />
                        </a>
                        <div class="flex-grow text-left md:space-y-2">
                            <div class="flex gap-2">
                                <div class="flex-grow">
                                    <div class="text-xl">
                                        <a
                                            href={{route("books.show", ['book' => $book] )}}
                                        >
                                            {{ $book->title}}
                                        </a>
                                    </div>
                                    <div class="italic">by {{ $book->author->name}}</div>
                                </div>
                            </div>
                            <div>{{ $book->subtitle}}</div>
                            <div>
                                <p>
                                    {{ $book->description && strlen($book->description) > 50
                                    ? substr($book->description, 0, 50) . '...'
                                    : $book->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
