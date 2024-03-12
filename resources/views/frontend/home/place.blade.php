@php
    use App\Models\Property;
    use App\Models\District;

    // Get the top 5 districts with the most properties
    $topDistricts = Property::select('barangay', DB::raw('COUNT(*) as property_count'))
        ->groupBy('barangay')
        ->orderByDesc('property_count')
        ->limit(4)
        ->get();

    // Initialize an array to store district information
    $districts = [];

    // Iterate through the top districts
    for ($i = 0; $i < count($topDistricts); $i++) {
        $district = $topDistricts[$i];
        
        // Get the district name, property count, model, and image
        $districtName = $district->barangay;
        $districtPropertyCount = $district->property_count;
        $districtModel = District::where('district_name', $districtName)->first();
        $districtImage = $districtModel ? $districtModel->district_image : null;

        // Determine the width and height based on the district index
        $width = $i == 3 ? 770 : 370;
        $height = $i == 0 ? 580 : 275;

        // Store district information in the array
        $districts[$i] = [
            'name' => $districtName,
            'property_count' => $districtPropertyCount,
            'model' => $districtModel,
            'image' => $districtImage,
            'width' => $width,
            'height' => $height,
        ];
    }
@endphp

<section class="place-section sec-pad">
    <div class="auto-container">
        <div class="sec-title centred">
            <h5>Top Places</h5>
            <h2>Most Popular Places</h2>
            <p>Explore popular living spaces for rent and find your ideal home in top destinations.</p>

        </div>
        <div class="sortable-masonry">
            <div class="items-container row clearfix">

                @foreach ($districts as $index => $district)
                    <div class="col-lg-{{ $index == 3 ? '8' : '4' }} col-md-6 col-sm-12 masonry-item small-column all illustration brand marketing software">
                        <div class="place-block-one">
                            <div class="inner-box">
                                <figure class="image-box">
                                    @if ($district['image'])
                                        <img src="{{ asset($district['image']) }}" alt="" style="width:{{ $district['width'] }}px; height:{{ $district['height'] }}px;">
                                    @else
                                        <img src="{{ asset('frontend/assets/images/resource/place-1.jpg') }}" alt="">
                                    @endif
                                </figure>
                                <div class="text">
                                    <h4><a href="">{{ $district['name'] }}</a></h4>
                                    <p>{{ $district['property_count'] }} Properties</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
