<article class="bg-white    flex flex-col shadow my-4">
    <!-- Article Image -->
    <a href="{{route('view', $blog)}}" class="hover:opacity-75">
        <img src="{{$blog->getThumbnail()}}" alt="{{$blog->title}}" class="aspect-[4/3] object-contain">
    </a>
    <div class="bg-white flex flex-col justify-start p-6">
       <!-- <div class="flex gap-4">
            @foreach($post->categories as $category)
                <a href="#" class="text-blue-700 text-sm font-bold uppercase pb-4">
                    {{$category->title}}
                </a>
            @endforeach
        </div>-->
        <a href="{{route('view', $blog)}}" class="text-3xl font-bold hover:text-gray-700 pb-4">
            {{$blog->title}}
        </a>
        @if ($showAuthor)
            <p href="#" class="text-sm pb-3">
                By <a href="#" class="font-semibold hover:text-gray-800">{{$blog->user->name}}</a>, Published on
                {{$blog->getFormattedDate()}} | {{ $blog->blog }}
            </p>
        @endif
        <a href="{{route('view', $blog)}}" class="pb-6">
            {{$blog->shortBody()}}
        </a>
        <a  href="{{route('view', $blog)}}" class="uppercase text-gray-800 hover:text-black">Continue Reading <i
                class="fas fa-arrow-right"></i></a>
    </div>
</article>