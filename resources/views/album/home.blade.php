<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Home
        </h2>
    </x-slot>
    <div class="mt-[50px]"></div>
    @foreach($transformedAlbums as $albums)
        <div class="w-[600px] bg-gray-100 mx-auto border border-gray-300 flex justify-center items-center pt-[10px] pb-[10px]">
            {{ $albums['description'] }}
        </div>
        <div class="w-[600px] bg-gray-100 mx-auto border border-gray-300 flex justify-center items-center">
            <img src="{{ asset('storage/' . $albums['image']) }}" class="w-[50%]">
        </div>
        <div class="w-[600px] bg-gray-100 mx-auto border border-gray-300 flex justify-center items-center pt-[10px] pb-[10px] image-pair" onclick="like(this, {{ $albums['id'] }})">
        @if(!$albums['likes'])
            <img src="{{ asset('outline.png') }}" alt="Outline" class="w-[30px] image1">
            <img src="{{ asset('filled.png') }}" alt="Filled" class="w-[30px] image2" style="display: none;">
        @else
            <img src="{{ asset('filled.png') }}" alt="Filled" class="w-[30px] image2">
            <img src="{{ asset('outline.png') }}" alt="Outline" class="w-[30px] image1" style="display: none;">
        @endif

        </div>
        
        <div class="mb-[40px]"></div>
    @endforeach
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

const like = (element, album_id) => {
    var $element = $(element);
    var $image1 = $element.find('.image1');
    var $image2 = $element.find('.image2');

    // Toggle visibility of images
    $image1.toggle();
    $image2.toggle();

    // Send AJAX request to update like status
    $.ajax({
        url: '/like/' + album_id,
        method: 'POST',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Handle success (optional)
            console.log('Like status updated successfully!');
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed!');
            // Handle error (optional)
            // Revert the toggle in case of error
            $image1.toggle();
            $image2.toggle();
        }
    });
};





</script>
