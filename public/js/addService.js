var vm = new Vue({
    data: {
        key: ""
    },
    methods: {
        onChange(event) {
            console.log(event.target.value)
        }
    }
});
