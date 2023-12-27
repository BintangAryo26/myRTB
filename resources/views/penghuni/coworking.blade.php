@include('components.sidebaruser')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @vite('resources/css/coworking.css')
    @vite('resources/css/content.css')
    <title>{{$title}}</title>
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
        <div class="bottom-box">
            <div class="schedule-box">
                @include('components.date')                
                <hr>
                <form action="/penghuni/coworking?date={{Request::get('date')}}" method="post">
                    @csrf
                    <div class="wrap-validate-choose-date">
                        @if(!Request::get('date'))
                        <div class="wrap-span">
                            {{-- <img src="{{ asset('/assets/ill-calendar.svg') }}" alt=""> --}}
                            <h6>Pilih tanggal dulu yuk</h6>
                        </div>
                        @else
                        <h4>Pilih Jam Booking</h4>
                        <div class="wrap-time">
                            <div class="from-time">
                                <h5>Dari :</h5>
                                <select name="from-time" id="fromtime" class="from-time-select" onchange="timeChange()" required>
                                <option value="PilihJam">Pilih Jam</option>
                                    @foreach ($roomAvail as $ra)
                                        <option value="{{$ra['value']}}" {{ Request::get('fromtime') == $ra['value']  ? 'selected' : '' }} 
                                        {{$ra['booked'] == true ? 'disabled' : ''}}>
                                            {{$ra['label']}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="to-time">
                                <h5>Sampai :</h5>
                                <select name="to-time" id="totime" class="to-time-select" required>
                                <option value="">Pilih Jam</option>
                                    @foreach ($timeTo as $time)
                                    <option value="{{ $time['allval'] }}"
                                        {{ Request::get('totime') == $time['value'] ? 'selected' : '' }} 
                                        {{$time['booked'] == true ? 'disabled' : ''}}>
                                        {{ $time['label'] }}
                                    </option>
                                @endforeach
                                </select>
                            </div>
                            
                        </div>
                        <h4>Jumlah Partisipan</h4>
                        <div class="wrap-participation">
                            <input type="text" name="count" placeholder="Type Here" required>
                        </div>
                        <h4>Tipe</h4>
                        <div class="wrap-type">
                            <div class="wrap-private">
                                <input type="radio" name="book_type" value="Private" required>
                                <p>Private</p>
                            </div>
                            <div class="wrap-public">
                                <input type="radio" name="book_type" value="Public" required>
                                <p>Public</p>
                            </div>
                        </div>
                        <div class="wrap-submit">
                            <button type="submit">Submit</button>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="wrap-right">
                <h5>Pengguna Hari Ini</h5>
                <div class="wrap-scrollable">
                    @if (empty($books))
                        <p class="empty">Tidak ada pengguna hari ini</p>
                    @else
                        @foreach ($books as $book)
                            <div class="wrap-detail-user">
                                <img src="{{ asset('data/' . $book['photo']) }}" alt="">
                                <div class="wrap-detail-mid">
                                    <h6>{{ $book['name'] }}</h6>
                                    <p>{{ $book['class'] }}</p>
                                </div>
                                <div class="wrap-detail-right">
                                    <p>{{ $book['start_time'] }} - {{ $book['end_time'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function timeChange() {
            let queryString = window.location.search; // get url parameters
            let params = new URLSearchParams(queryString); // create url search params object
            params.delete("fromtime"); // delete city parameter if it exists, in case you change the dropdown more then once
            params.append("fromtime", document.getElementById("fromtime").value); // add selected city
            document.location.href = "?" + params.toString(); // refresh the page with new url
        }
    </script>
</body>
</html>