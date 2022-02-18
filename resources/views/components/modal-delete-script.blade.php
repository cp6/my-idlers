<script>
    let app = new Vue({
        el: "#app",
        data: {
            "modal_hostname": '',
            "modal_id": '',
            "delete_form_action": '',
            showModal: false
        },
        methods: {
            modalForm(event) {
                this.showModal = true;
                this.modal_hostname = event.target.id.replace('btn-', '');
                this.modal_id = event.target.title;
                this.delete_form_action = '{{$uri}}/' + this.modal_id;
            }
        }
    });
</script>
