import PerfectScrollbar from "perfect-scrollbar";
import InfiniteLoading from "vue-infinite-loading";

export default {
    data: function () {
        return {
            ratings: {
                total: 0,
                data: [],
                current: 0,
                next: true,
            },
        }
    },

    mounted: function () {
        this.$nextTick(function () {
            this.handleScrollElements();
            this.initTradesChart();
        })
    },

    methods: {
        initTradesChart: function(){
            const vm = this;
            const canvas = $('#trades-chart');

            let config = {
                type: 'line',

                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetStrokeWidth: 3,
                    pointDotStrokeWidth: 4,
                    tooltipFillColor: "rgba(0,0,0,0.8)",
                    legend: {
                        display: false,
                        position: 'bottom',
                    },
                    hover: {
                        mode: 'label'
                    },
                    scales: {
                        xAxes: [{
                            display: false,
                        }],
                        yAxes: [{
                            display: false,
                            ticks: {
                                min: 0,
                                max: 70
                            },
                        }]
                    },
                    title: {
                        display: false,
                        fontColor: "#FFF",
                        fullWidth: false,
                        fontSize: 40,
                        text: '82%'
                    }
                },
            };

            let card = canvas.closest('.card');

            card.block({
                overlayCSS: {
                    backgroundColor: '#FFF',
                    cursor: 'wait',
                },
                message: '<div class="ft-refresh-cw icon-spin font-medium-2"></div>',
                css: {
                    border: 0,
                    backgroundColor: 'none',
                    padding: 0,
                }
            });

            const endpoint = route('home.successful-trades-data');

            axios.post(endpoint)
                 .then((response) => {
                     const data = response.data;

                     const chart = document.getElementById("trades-chart");

                     config = Object.assign(config, {
                         data: {
                             labels: data.month,
                             datasets: [{
                                 label: "Total",
                                 data: data.total,
                                 backgroundColor: 'rgba(30,196,129,0.12)',
                                 borderColor: "#1EC481",
                                 borderWidth: 3,
                                 strokeColor: "#1EC481",
                                 capBezierPoints: true,
                                 pointColor: "#fff",
                                 pointBorderColor: "#1EC481",
                                 pointBackgroundColor: "#FFF",
                                 pointBorderWidth: 3,
                                 pointRadius: 5,
                                 pointHoverBackgroundColor: "#FFF",
                                 pointHoverBorderColor: "#1EC481",
                                 pointHoverRadius: 7,
                             }]
                         }
                     });

                     new Chart(chart.getContext("2d"), config);

                     card.unblock();
                 })
                 .catch((error) => {
                     console.log(error);
                     card.unblock();
                 });
        },

        handleScrollElements: function () {
            if (this.$refs.ratingScrollWrapper) {
                new PerfectScrollbar(this.$refs.ratingScrollWrapper);
            }
        },

        dateDiffForHumans: function (date) {
            let localTime = moment.utc(date).toDate();

            return moment(localTime).fromNow();
        },


        getProfileAvatar: function (user) {
            if (user.profile && user.profile.picture) {
                return user.profile.picture;
            }

            return '/images/objects/avatar.png';
        },

        ratingInfiniteHandler: function ($state) {
            let vm = this;

            if (this.ratings.next) {
                let endpoint = route('ajax.profile.get-ratings', {
                    'user': window.Laravel.user.name
                });

                axios.post(endpoint, {
                    page: vm.ratings.current + 1,
                }).then(function (response) {
                    var ratings = response.data;

                    if (ratings.data.length && vm.ratings.next) {
                        vm.ratings.current = ratings.current_page;
                        vm.ratings.data = vm.ratings.data.concat(ratings.data);
                        vm.ratings.next = Boolean(ratings.next_page_url);
                        vm.ratings.total = ratings.total;
                    } else {
                        vm.ratings.next = false;
                    }

                    $state.loaded();

                    if (!vm.ratings.next) {
                        $state.complete();
                    }
                }).catch(function (error) {
                    if (error.response) {
                        let response = error.response.data;

                        if ($.isPlainObject(response)) {
                            $.each(response.errors, function (key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error(response);
                        }

                        vm.ratings.next = false;

                        $state.complete();
                    } else {
                        console.log(error.message);
                    }
                });
            } else {
                $state.complete();
            }
        },
    },

    components: {InfiniteLoading},
}
