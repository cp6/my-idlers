<script>
    window.addEventListener('load', function() {
        document.getElementById("confirmDeleteModal").classList.remove("d-none");
        let app = new Vue({
            el: "#app",
            data: {
                "modal_hostname": '',
                "modal_id": '',
                "delete_form_action": '',
                showModal: false
            },
            methods: {
                confirmDeleteModal(event) {
                    var el = event.target.closest('button') || event.target;
                    this.showModal = true;
                    this.modal_hostname = el.dataset.title || el.title;
                    this.modal_id = el.id;
                    this.delete_form_action = '/{{$uri}}/' + this.modal_id;
                }
            }
        });
    })
</script>
