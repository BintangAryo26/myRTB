<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    @vite('resources/css/content.css')
    @vite('resources/css/dapur.css')
</head>

<body>
    @if(session('message'))
        @include('components.notification')
    @endif
    @include('components.sidebaruser')
    <div class="kontainer-header">
        @include('components.headercontent')
    </div>
    <div class="container-content">
        <div class="wrap-content">
            <div class="wrap-left">
                @include('components.date')
                <hr>
                <form action="/penghuni/dapur?date={{Request::get('date')}}" method="post">
                    @csrf
                    <div class="wrap-validate-choose-date">
                        @if (!Request::get('date'))
                            <div class="wrap-span">
                                <img src="{{ asset('/assets/ill-calendar.svg') }}" alt="">
                                <h6>Pilih tanggal dulu yuk</h6>
                            </div>
                        @else
                            <h4>Jam Booking</h4>
                            <div class="wrap-time">
                                <div class="from-time">
                                    <select name="from-time" id="time" class="from-time-select"
                                        onchange="timeChange()" required>
                                        <option value="">Pilih Jam</option>
                                        @foreach ($timeAvail as $time)
                                            <option value="{{ $time['value'] }}"
                                                {{ Request::get('time') == $time['value'] ? 'selected' : '' }}>
                                                {{ $time['label'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h4>Fasilitas</h4>

                            <h5>Kompor</h5>
                            <div class="wrap-stove">
                                <div class="stove">
                                    @foreach ($stoveAvailLeft as $sl)
                                        <label>
                                            <input type="radio" name="stuff" id="stuff" value="{{$sl['stuff_id']}}"
                                                class="radio" {{ empty(Request::get('time')) || $sl['booked'] ? 'disabled' : '' }}>
                                            <span class="custom-radio mr">{{$sl['index']}}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="stove">
                                    @foreach ($stoveAvailRight as $sl)
                                        <label>
                                            <input type="radio" name="stuff" id="stuff" value="{{$sl['stuff_id']}}"
                                                class="radio" {{ empty(Request::get('time')) || $sl['booked'] ? 'disabled' : '' }}>
                                            <span class="custom-radio mr">{{$sl['index']}}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="wrap-bottom">
                                <div class="rice-cooker">
                                    <h5>Rice Cooker</h5>
                                    <div class="item">
                                        @foreach ($riceCookerAvail as $rc)
                                        <label>
                                            <input type="radio" name="stuff" id="stuff" value="{{$rc['stuff_id']}}"
                                                class="radio" {{ empty(Request::get('time')) || $rc['booked'] ? 'disabled' : '' }}>
                                            <span class="custom-radio mr">{{$rc['index']}}</span>
                                        </label>      
                                        @endforeach
                                    </div>
                                </div>
                                <div class="air-fryer">
                                    <h5>Air Fryer</h5>
                                    <div class="item">
                                        @foreach ($airFryerAvail as $af)
                                        <label>
                                            <input type="radio" name="stuff" id="stuff" value="{{$af['stuff_id']}}"
                                                class="radio" {{ empty(Request::get('time')) || $af['booked'] ? 'disabled' : '' }}>
                                            <span class="custom-radio mr">{{$af['index']}}</span>
                                        </label>                                    
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-submit">Submit</button>
                        @endif
                    </div>
                </form>
            </div>
            <div class="wrap-right"></div>
        </div>
    </div>

    <script>
        function timeChange() {
            let queryString = window.location.search; // get url parameters
            console.log(queryString);
            let params = new URLSearchParams(queryString); // create url search params object
            params.delete("time"); // delete city parameter if it exists, in case you change the dropdown more then once
            params.append("time", document.getElementById("time").value); // add selected city
            document.location.href = "?" + params.toString(); // refresh the page with new url
        }
    </script>
</body>

</html>
