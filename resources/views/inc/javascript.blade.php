{{--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>--}}

<script>
    window.Laravel = {!! json_encode([
       'csrfToken' => csrf_token(),
       'apiToken' =>  Auth::User()->api_token  ?? null,
   ]) !!};
</script>

@if(Request::is('zoocard'))
    <script>


    </script>
@endif

@if(Request::is('dashboard'))
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script>

        $(function() {
            var ctx = $("#myChart");
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    datasets: [{
                        data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                        lineTension: 0,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        borderWidth: 4,
                        pointBackgroundColor: '#007bff'
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false,
                    }
                }
            });
        });





    </script>
@endif


@if(App\Role\RoleChecker::check(Auth::user(),App\Role\UserRole::ROLE_PUBLIC))
    <script>
        var botmanWidget = {
            aboutText: "{{Auth::user()->name}}",
            title: "UOL ChatBot",
            introMessage: "Welcome to UOLChatBot",
            userId: "{{Auth::user()->name}}"
        };

    </script>

    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

@endif
